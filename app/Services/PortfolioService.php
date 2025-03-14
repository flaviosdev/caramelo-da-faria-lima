<?php

namespace App\Services;

use App\Models\Portfolio;

class PortfolioService
{
    public function save($portfolio)
    {
        $savedPortfolio = Portfolio::create($portfolio);

        return [
            'id' => $savedPortfolio->id,
            'name' => $savedPortfolio->name
        ];
    }

    public function getById(string $id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            return false;
        }

        return [
            'id' => $portfolio->id,
            'name' => $portfolio->name
        ];
    }

    public function getByUserId(int $userId)
    {
        $collection = Portfolio::where('user_id', $userId)->get();
        return $collection->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
    }

    public function update($id, $portfolio)
    {
        $storedPortfolio = Portfolio::find($id);
        $storedPortfolio->name = $portfolio['name'];
        return (bool) $storedPortfolio->save();
    }

    public function delete(string $id)
    {
        return Portfolio::find($id)->delete();

    }
}
