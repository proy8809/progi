<?php

namespace App\Http\Controllers;

use App\Services\QuotesCalculation\Services\QuoteEstimationService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index() {
        return view('QuotesCalculation.index', []);
    }

    public function get(
        Request $request,
        QuoteEstimationService $quoteEstimationService
    ) {
        return response()->json($quoteEstimationService->estimate($request->budget), 200);
    }
}
