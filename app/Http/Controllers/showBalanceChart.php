<?php

namespace App\Http\Controllers;

use App\Models\BalanceChange;
use Illuminate\Http\Request;

class YourController extends Controller
{
    public function showBalanceChart()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Get the balance changes from the database
        $balanceChanges = BalanceChange::where('user_id', $user->id)->orderBy('transaction_date')->get();

        // Initialize arrays to store labels and data for the chart
        $labels = [];
        $data = [];
        $absoluteBalance = $user->balance; // Initialize absolute balance with the current balance

        // Loop through each balance change
        foreach ($balanceChanges as $change) {
            // Update the absolute balance based on the change type
            if ($change->change_type === 'addition') {
                $absoluteBalance += $change->amount;
            } elseif ($change->change_type === 'subtraction') {
                $absoluteBalance -= $change->amount;
            }

            // Add the transaction date and absolute balance to the arrays
            $labels[] = $change->transaction_date;
            $data[] = $absoluteBalance;
        }

        // Pass the processed data to the view
        return view('balance_chart', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
