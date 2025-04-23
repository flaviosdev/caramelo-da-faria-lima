<?php

namespace App\Console\Commands;

use App\Models\AssetType;
use App\Models\TransactionType;
use App\Models\YieldIndex;
use Illuminate\Console\Command;

class PrePopulate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pre-populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cdb = YieldIndex::firstOrCreate([
            'name' => 'CDB',
            'formula' => '_INDEX * (_MODIFIER/100)',
            'value' => 13.15
        ]);
        $ipca = YieldIndex::firstOrCreate([
            'name' => 'IPCA',
            'formula' => '_INDEX + _MODIFIER',
            'value' => 5.06
        ]);

        AssetType::firstOrCreate([
            'yield_index_id' => $cdb->id,
            'name' => 'Renda Fixa Atrelada ao CDB',
            'indexed' =>  1,
            'description' => 'Renda Fixa Atrelada ao CDB',
        ]);

        AssetType::firstOrCreate([
            'name' => 'Renda Fixa Prefixada',
            'indexed' =>  0,
            'description' => 'Renda Fixa Prefixada',
        ]);

        AssetType::firstOrCreate([
            'yield_index_id' => $ipca->id,
            'name' => 'Renda Fixa Atrelada ao IPCA',
            'indexed' =>  1,
            'description' => 'Renda Fixa Atrelada ao IPCA',
        ]);

        TransactionType::firstOrCreate([
            'name' => 'Aporte',
        ]);
        TransactionType::firstOrCreate([
            'name' => 'Rendimento',
        ]);


    }
}
