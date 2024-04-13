<!-- resources/views/balance_update.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Balance</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('balance.update') }}">
                            @csrf

                            <div class="form-group">
                                <label for="change_type">Change Type</label>
                                <select name="change_type" id="change_type" class="form-control" required>
                                    <option value="addition">Addition</option>
                                    <option value="subtraction">Subtraction</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="transaction_date">Transaction Date</label>
                                <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Balance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
