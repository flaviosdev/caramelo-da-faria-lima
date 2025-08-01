<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\TransactionType;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use App\Repositories\AssetRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetService
{

    public function __construct(
        private readonly AssetRepository       $assetRepository,
        private readonly TransactionService    $transactionService,
        private readonly TransactionRepository $transactionRepository,
        private readonly YieldService $yieldService,
    ) {}

    public function save($asset)
    {
        DB::beginTransaction();

        $savedAsset = $this->assetRepository->save($asset);

        if ($savedAsset->assetType->indexed) {
            $modifier = YieldPercentageModifier::create([ // todo: the formula must be here, not in index
                'asset_id' => $savedAsset->id,
                'yield_index_id' => $asset['yield_index'],
                'value' => $asset['modifier']
            ]);

            $this->yieldService->calculateIndexedPercentage($savedAsset);

        } else {
            $percentage = YieldPercentage::create([
                'asset_id' => $savedAsset->id,
                'percentage' => $asset['percentage'] // TODO: IMPLEMENT THIS FIELD!
            ]);
        }

        DB::commit();

        return [
            'id' => $savedAsset->id,
            'portfolio_id' => $savedAsset->portfolio_id,
            'asset_type_id' => $savedAsset->asset_type_id,
            'name' => $savedAsset->name
        ];
    }

    public function getById(string $id)
    {
        $asset = $this->assetRepository->getById($id);

        if (!$asset) {
            return false;
        }

        return [
            'id' => $asset->id,
            'portfolio_id' => $asset->portfolio_id,
            'asset_type_id' => $asset->asset_type_id,
            'name' => $asset->name
        ];
    }

    public function getByPortfolioId(int $portfolioId)
    {
        $collection = $this->assetRepository->getByPortfolioId($portfolioId);
        return $collection->map(function ($item) {
            return [
                'id' => $item->id,
                'portfolio_id' => $item->portfolio_id,
                'asset_type_id' => $item->asset_type_id,
                'name' => $item->name
            ];
        });
    }

    public function update($id, $asset)
    {
        $storedAsset = $this->assetRepository->getById($id);
        $storedAsset->name = $asset['name'];
        return (bool)$storedAsset->save();
    }

    public function delete(string $id)
    {
        return $this->assetRepository
            ->getById($id)
            ->delete();
    }

    public function shouldReceiveYield(Asset $asset)
    {
        $alreadyHasYieldToday = $this->transactionRepository->hasYieldToday($asset);
        if ($alreadyHasYieldToday) {
            return false;
        }

        $lastTransactionYesterday = $this->transactionRepository->getLastTransactionOnDate($asset, Carbon::yesterday());

        return $lastTransactionYesterday !== null && $lastTransactionYesterday->balance > 0;
    }

    public function createYieldTransactionFor(Asset $asset)
    {
        $shouldReceiveYield = $this->shouldReceiveYield($asset);

        Log::info("Asset: {$asset->id}, ShouldReceiveYield: " . ($shouldReceiveYield ? 'yes' : 'no'));

        if (!$shouldReceiveYield) {
            return false;
        }

        $yieldAmount = $this->calculateDailyYieldAmountFor($asset);

        $transaction = $this->transactionService->save([
            'asset_id' => $asset->id,
            'amount' => $yieldAmount,
            'transaction_type_id' => TransactionType::YIELD,
        ]);

        return $transaction;
    }

    public function calculateDailyYieldAmountFor(Asset $asset)
    {
        $lastTransaction = $this->transactionRepository->getLastTransactionOnDate($asset, Carbon::yesterday());

        if (!$lastTransaction) {
            return 0.0;  // todo: maybe return null
        }

        $balance = $lastTransaction->balance;
        $percentage = $asset->yieldPercentage->percentage;
        return $balance * ($percentage / 100 / 252);
    }
}
