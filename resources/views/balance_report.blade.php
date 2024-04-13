<!-- resources/views/balance_report.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Balance Report</div>

                    <div class="card-body">
                        <!-- Display balance report table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Change Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Iterate through balance changes and display each row -->
                                @foreach ($balanceChanges as $balanceChange)
                                    <tr>
                                        <td>{{ $balanceChange->transaction_date }}</td>
                                        <td>{{ $balanceChange->amount }}</td>
                                        <td>{{ $balanceChange->change_type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
