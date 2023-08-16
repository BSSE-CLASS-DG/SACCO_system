<?php
// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Loans;
use App\Models\Contribution;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $loanResults = Loans::whereBetween('startDate', [$startDate, $endDate])->get();
    $contributionResults = Contribution::whereBetween('date', [$startDate, $endDate])->get();

    return response()->json([
        'loans' => $loanResults,
        'contributions' => $contributionResults,
    ]);
}

}
