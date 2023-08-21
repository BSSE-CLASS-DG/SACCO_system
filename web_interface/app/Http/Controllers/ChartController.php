<?php

// app/Http/Controllers/ChartController.php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon; // Add a semicolon at the end
use App\Models\available_deposits; // Add a semicolon at the end
use Illuminate\Http\Request;
use App\Models\AvailableDeposit;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function fetchChartData()
{
    // Fetch data for loans chart
    $loanData = DB::table('loandetails')
        ->select(DB::raw('MONTH(startDate) as month, SUM(amount) as total'))
        ->groupBy(DB::raw('MONTH(startDate)'))
        ->orderBy(DB::raw('MONTH(startDate)'))
        ->get();

    $loanMonths = [];
    $loanAmounts = [];

    foreach ($loanData as $data) {
        $loanMonths[] = date('F', mktime(0, 0, 0, $data->month, 1));
        $loanAmounts[] = $data->total;
    }

    // Fetch data for contributions chart
    $contributionData = DB::table('contributions')
        ->select(DB::raw('MONTH(date) as month, SUM(amount) as total'))
        ->groupBy(DB::raw('MONTH(date)'))
        ->orderBy(DB::raw('MONTH(date)'))
        ->get();

    $contributionMonths = [];
    $contributionAmounts = [];

    foreach ($contributionData as $data) {
        $contributionMonths[] = date('F', mktime(0, 0, 0, $data->month, 1));
        $contributionAmounts[] = $data->total;
    }

    $chartData = [
        'loanMonths' => $loanMonths,
        'loanAmounts' => $loanAmounts,
        'contributionMonths' => $contributionMonths,
        'contributionAmounts' => $contributionAmounts,
    ];

    return response()->json($chartData);
}

}
