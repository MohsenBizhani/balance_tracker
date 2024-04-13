<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BalanceChange;
use Carbon\Carbon;

class BalanceController extends Controller
{
    public function update(Request $request)
    {
        // Validate request data
        $request->validate([
            'change_type' => 'required|in:addition,subtraction',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
        ]);

        // Retrieve authenticated user
        $user = auth()->user();

        // Create a new balance change record
        $balanceChange = new BalanceChange();
        $balanceChange->user_id = $user->id;
        $balanceChange->amount = $request->amount;
        $balanceChange->change_type = $request->change_type;
        $balanceChange->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d H:i:s');
        $balanceChange->save();

        // Update user's balance based on the change type
        if ($request->change_type === 'addition') {
            $user->balance += $request->amount;
        } else {
            $user->balance -= $request->amount;
        }
        $user->save();

        return response()->json(['message' => 'Balance updated successfully']);
    }

    public function generateReport(Request $request)
    {
        // Validate request data
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Retrieve authenticated user
        $user = auth()->user();

        // Retrieve balance changes within the specified date range
        $balanceChanges = BalanceChange::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$request->start_date, $request->end_date])
            ->orderBy('transaction_date')
            ->get();

        // Return balance changes as a response
        return response()->json(['balance_changes' => $balanceChanges]);
    }

    public function showChart(Request $request)
{
    // Get the authenticated user
    $user = auth()->user();

    // Get start and end dates from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Get the balance changes from the database, filtered by start and end dates
    $balanceChanges = BalanceChange::where('user_id', $user->id)
                                    ->whereBetween('transaction_date', [$startDate, $endDate])
                                    ->orderBy('transaction_date')
                                    ->get();

    // Initialize arrays to store labels and data for the chart
    $labels = [];
    $data = [];


    // Set the initial absolute balance
    $absoluteBalance = 0;

    // Flag to check if it's the first change
    $firstChange = true;

    // Loop through each balance change
    foreach ($balanceChanges as $change) {
        // If it's the first change, set the absolute balance
        if ($firstChange) {
            // If the first change is an addition, subtract its amount from the initial balance
            if ($change->change_type === 'addition') {
                $absoluteBalance = $change->amount;
            }
            $firstChange = false; // Set the flag to false after processing the first change
        } else {

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
    }

    // Pass the processed data to the view
    return view('balance_chart', [
        'labels' => $labels,
        'data' => $data,
    ]);
}
}
