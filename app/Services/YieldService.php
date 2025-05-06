<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\YieldIndex;
use App\Models\YieldPercentage;
use App\Models\YieldPercentageModifier;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class YieldService
{
    public function __construct(
        private readonly ExpressionLanguage $expressionLanguage,
    ) {}

    public function calculateIndexedPercentage(Asset $asset)
    {
        $yieldIndex = $asset->assetType->yieldIndex;
        $yieldModifier = $asset->yieldPercentageModifier;

        $formula = str_replace(
            ['_INDEX', '_MODIFIER'],
            [$yieldIndex->value, $yieldModifier->value],
            $yieldIndex->formula
        );
        $result = $this->expressionLanguage->evaluate($formula);

        $percentage = YieldPercentage::create([
            'asset_id' => $asset->id,
            'percentage' => round($result, 4)
        ]);
    }
}
