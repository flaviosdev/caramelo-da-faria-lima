<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Services\YieldService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GeneratePercentages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-percentages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private YieldService $yieldService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPrefix = "Generate Percentages:";

        Log::info($logPrefix . "Start");
        $assetsWithoutPercentages = Asset::doesntHave('yieldPercentage')->get();

        Log::info($logPrefix . "{$assetsWithoutPercentages->count()} rows to be processed");

        foreach ($assetsWithoutPercentages as $asset) {

            Log::info("$logPrefix asset $asset->id - $asset->name ");
            $this->yieldService->calculateIndexedPercentage($asset);
            Log::info("Generate Percentages: Success!");
        }
    }
}
