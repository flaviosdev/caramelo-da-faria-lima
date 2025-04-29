<?php

namespace App\Console\Commands;

use App\Models\AssetType;
use App\Models\Transaction;
use App\Models\YieldIndex;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use App\Services\TransactionService;
use App\Services\YieldService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateYields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-yields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private readonly YieldService       $yieldService,
        private readonly TransactionService $transactionService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yieldPercentages = YieldPercentage::all();

        foreach ($yieldPercentages as $yieldPercentage) {

            // Check if a yield transaction already exists for today
            $isYieldAlreadyCalculated = DB::table('transactions')
                ->where([
                    ['created_at', '>=', Carbon::today()],
                    ['asset_id', $yieldPercentage['asset_id']],
                    ['transaction_type_id', 2] // TODO: REFACTOR IT!
                ])->exists();

            if ($isYieldAlreadyCalculated) {
                continue;
            }

            $lastTransaction = DB::table('transactions')
                ->where([
                    ['asset_id', $yieldPercentage['asset_id']],
                ])
                ->latest()
                ->first();

            if ($lastTransaction) {
                $balance = $lastTransaction->balance;
                $percentage = ($yieldPercentage->percentage / 252);
                $yield = $balance * $percentage / 100;

                // todo: IR and IOF deduction rules

                $this->transactionService->save([
                    'asset_id' => $yieldPercentage['asset_id'],
                    'amount' => $yield,
                    'transaction_type_id' => 2, // TODO: GET TYPE AS 'APORTE'; HOW?
                ]);
            }
        }
    }
}
