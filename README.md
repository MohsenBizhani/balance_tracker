# Balance Tracker

Balance Tracker is a web application built with Laravel that allows users to track their balances, make balance changes, generate reports, and visualize balance changes over time through charts.

## Features

- **User Authentication**: Users can sign up, log in, and log out securely.
- **Balance Management**: Users can update their balance by adding or subtracting amounts with a specified transaction date.
- **Chart Visualization**: Users can visualize their balance changes over time using interactive charts.

## Installation

1. Clone the repository:

```
git clone <github.com/MohsenBizhani/balance_tracker>
```

2. Install Composer dependencies:

```
composer install
```

3. Copy the `.env.example` file to `.env` and configure the database connection settings.

4. Generate an application key:

```
php artisan key:generate
```

5. Migrate the database:

```
php artisan migrate
```

6. Serve the application:

```
php artisan serve
```

The application will be accessible at `http://localhost:8000`.

## Usage

1. Sign up or log in to your account.
2. Navigate to the dashboard.
3. Update your balance by specifying the change type (addition or subtraction), amount, and transaction date.
4. Visualize your balance changes over time by viewing the chart.

## Technologies Used

- Laravel
- PHP
- MySQL
- JavaScript (Chart.js)
- HTML/CSS

## Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
