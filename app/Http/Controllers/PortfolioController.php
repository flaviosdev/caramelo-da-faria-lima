<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Services\PortfolioService;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function __construct(
        private readonly PortfolioService $portfolioService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return $this->portfolioService->getByUserId(Auth::id());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PortfolioRequest $request)
    {
        $request['user_id'] = Auth::id();

        $savedPortfolio = $this->portfolioService->save($request);

        return [
            'portfolio_id' =>  $savedPortfolio->id,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $portfolio = $this->portfolioService->getById($id);

        if (!$portfolio) {
            return response()->json()
                ->setStatusCode(404);
        }

        return [
            'id' =>  $portfolio->id,
            'name' =>  $portfolio->name,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PortfolioRequest $request, string $id)
    {
        return $this->portfolioService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->portfolioService->delete($id);
    }
}
