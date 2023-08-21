<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaccoAccount;

class InterestRateController extends Controller
{
    public function update(Request $request)
    {
        $interestRate = $request->input('interestRate');

        // Fetch the record from the database
        $saccoAccount = SaccoAccount::first();
        
        // Update the interest_rate field
        $saccoAccount->interestRate = $interestRate;
        $saccoAccount->save();

        // Redirect back or perform any other action as needed
        return redirect()->back()->with('success', 'Interest rate updated successfully');
    }
}
