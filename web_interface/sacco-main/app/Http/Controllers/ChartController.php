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
        // Fetch the total amount deposited for each month
        $monthlyDeposits = DB::table('available_deposits')
            ->select(DB::raw('YEAR(deposit_date) as year, MONTH(deposit_date) as month, SUM(amount_deposited) as total_amount'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    
        $labels = [];
        $amounts = [];
    
        foreach ($monthlyDeposits as $deposit) {
            $monthName = date('F', mktime(0, 0, 0, $deposit->month, 1));
            $labels[] = $monthName . ' ' . $deposit->year;
            $amounts[] = $deposit->total_amount;
        }
    
        $chartData = [
            'labels' => $labels,
            'amounts' => $amounts,
        ];
    
        return response()->json($chartData);
    }
    
    public function fetchPieChartData()
    {
        // Get the current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate the total amount of deposits for the ongoing month
        $depositsAmount = DB::table('available_deposits')
            ->whereMonth('deposit_date', $currentMonth)
            ->whereYear('deposit_date', $currentYear)
            ->sum('amount_deposited');

        // Calculate the total amount of loans for the ongoing month
        $loansAmount = DB::table('loandetails')
            ->whereMonth('StartDate', $currentMonth)
            ->whereYear('StartDate', $currentYear)
            ->sum('amount');

        $data = [
            'labels' => ['Deposits', 'Loans'],
            'amounts' => [$depositsAmount, $loansAmount],
        ];

        return response()->json($data);
    }
}
