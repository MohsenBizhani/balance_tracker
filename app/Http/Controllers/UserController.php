<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BalanceChange;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        // Retrieve authenticated user
        $user = auth()->user();

        // Pass user data to the dashboard view
        return view('dashboard', compact('user'));
    }

    public function updateBalance(Request $request)
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
    // Retrieve authenticated user
    $user = auth()->user();

    // Retrieve balance changes within the specified date range
    $balanceChanges = BalanceChange::where('user_id', $user->id)
        ->whereBetween('transaction_date', [$request->start_date, $request->end_date])
        ->orderBy('transaction_date')
        ->get();

    // Prepare data for the chart
    $labels = $balanceChanges->pluck('transaction_date')->toArray();
    $data = $balanceChanges->pluck('amount')->toArray();

    // Define chart data
    $chartData = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Balance',
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
                'data' => $data,
            ],
        ],
    ];

    // Pass chart data to the view
    return view('chart', ['chartData' => json_encode($chartData)]);
}

}
