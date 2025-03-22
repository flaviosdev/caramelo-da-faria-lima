<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function save($asset)
    {
        DB::beginTransaction();

        $savedAsset = Asset::create($asset);

        if ($savedAsset->assetType->indexed) {
            $modifier = YieldPercentageModifier::create([
                'asset_id' => $savedAsset->id,
                'yield_index_id' => $asset['yield_index'],
                'value' => $asset['modifier']
            ]);
        } else {
            $percentage = YieldPercentage::create([
                'asset_id' => $savedAsset->id,
                'value' => $asset['percentage'] // TODO: IMPLEMENT THIS FIELD!
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
        $asset = Asset::find($id);

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
        $collection = Asset::where('portfolio_id', $portfolioId)->get();
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
        $storedAsset = Asset::find($id);
        $storedAsset->name = $asset['name'];
        return (bool) $storedAsset->save();
    }

    public function delete(string $id)
    {
        return Asset::find($id)->delete();
    }
}
