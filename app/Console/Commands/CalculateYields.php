<?php

namespace App\Console\Commands;

use App\Models\AssetType;
use App\Models\YieldIndex;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use App\Services\YieldService;
use Illuminate\Console\Command;

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
        private readonly YieldService $yieldService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yieldIndexes = YieldIndex::all(); // all updated indexes

        foreach ($yieldIndexes as $yieldIndex) {
            $modifiers = YieldPercentageModifier::where('yield_index_id', $yieldIndex->id)->get();
            foreach ($modifiers as $modifier){
                $this->yieldService->calculateIndexedPercentage($yieldIndex, $modifier);
            }
        }
    }
}
