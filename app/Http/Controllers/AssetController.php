<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function __construct(
        private readonly AssetService $assetService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(int $portfolioId) {
        return $this->assetService->getByPortfolioId($portfolioId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetRequest $request,  $portfolioId)
    {
        if ($portfolioId !== $request->get('portfolio_id')) {
            return response()->json(
                ['portfolio_id from url and body does not match'],
                400
            );
        }

        $savedAsset = $this->assetService->save($request->all());

        return [
            'id' =>  $savedAsset['id'],
            'portfolio_id' => $savedAsset['portfolio_id'],
            'name' =>  $savedAsset['name'],
            'asset_type_id' =>  $savedAsset['asset_type_id'],
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asset = $this->assetService->getById($id);

        if (!$asset) {
            return response()->json()
                ->setStatusCode(404);
        }

        return [
            'id' =>  $asset['id'],
            'portfolio_id' => $asset['portfolio_id'],
            'name' =>  $asset['name'],
            'asset_type' =>  $asset['asset_type'],
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssetRequest $request, string $portfolioId, string $assetId, PortfolioRequest $portfolioRequest)
    {
        return $this->assetService->update($assetId, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $portfolioId, string $assetId)
    {
        $this->assetService->delete($assetId);
    }
}
