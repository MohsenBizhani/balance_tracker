<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>

    <p>Email: {{ $user->email }}</p>
    <p>Balance: ${{ $user->balance }}</p>

    <!-- Form for updating balance -->
    <form id="updateBalanceForm" method="POST" action="{{ route('balance.update') }}">
        @csrf
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" required>
        <label for="change_type">Change Type:</label>
        <select name="change_type" id="change_type" required>
            <option value="addition">Addition</option>
            <option value="subtraction">Subtraction</option>
        </select>
        <label for="transaction_date">Transaction Date:</label>
        <input type="date" name="transaction_date" id="transaction_date" required>
        <button type="submit" id="updateBalanceBtn">Update Balance</button>
    </form>

    <!-- Form for showing chart -->
    <form method="GET" action="{{ route('balance.chart') }}">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>
        <button type="submit">Show Chart</button>
    </form>

    <script>
        // Add event listener for form submission
        document.getElementById('updateBalanceForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            var form = this;
            var formData = new FormData(form); // Create FormData object
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // If request successful, reload the page
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
