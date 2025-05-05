<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Transaction;
use App\Models\YieldIndex;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use App\Services\AssetService;
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
        private readonly AssetService $assetService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $assets = Asset::all();

        foreach ($assets as $asset) {
            $this->assetService->createYieldTransactionFor($asset);
        }
    }
}
