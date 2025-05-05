<?php

namespace App\Repositories;

use App\Models\Asset;

class AssetRepository
{
    public function save($asset): Asset|bool
    {
        return Asset::create($asset);
    }

    public function getById($id)
    {
        return Asset::find($id);
    }

    public function getByPortfolioId($portfolioId)
    {
        return Asset::where('portfolio_id', $portfolioId)->get();
    }
}
