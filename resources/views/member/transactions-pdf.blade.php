<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NMSG Transaction Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1a472a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a472a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
            font-size: 13px;
        }
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #1a472a;
            margin: 15px 0;
        }
        .member-info {
            margin-bottom: 20px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .member-info table {
            width: 100%;
        }
        .member-info td {
            padding: 3px 10px;
            font-size: 12px;
        }
        .member-info .label {
            font-weight: bold;
            color: #555;
            width: 150px;
        }
        .summary-cards {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .summary-cards td {
            width: 33.33%;
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .summary-cards .amount {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .summary-cards .label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        .amount-green { color: #1a472a; }
        .amount-blue { color: #0d6efd; }
        .amount-orange { color: #e67e22; }
        table.transactions {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.transactions th {
            background: #1a472a;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.transactions td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }
        table.transactions tr:nth-child(even) {
            background: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-deposit {
            background: #d4edda;
            color: #155724;
        }
        .badge-withdrawal {
            background: #f8d7da;
            color: #721c24;
        }
        .badge-completed {
            background: #d4edda;
            color: #155724;
        }
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 2px solid #1a472a;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nakawa Market Savings Group</h1>
        <p>Transaction Report</p>
    </div>

    <div class="report-title">
        Statement of Account
    </div>

    <div class="member-info">
        <table>
            <tr>
                <td class="label">Member Name:</td>
                <td>{{ $user->name }}</td>
                <td class="label">Report Date:</td>
                <td>{{ now()->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td>{{ $user->email }}</td>
                <td class="label">Member Since:</td>
                <td>{{ $user->created_at->format('F d, Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="summary-cards">
        <tr>
            <td>
                <div class="label">Account Balance</div>
                <div class="amount amount-green">UGX {{ number_format($user->account_balance, 0) }}</div>
            </td>
            <td>
                <div class="label">Total Deposits (Principal)</div>
                <div class="amount amount-blue">UGX {{ number_format($totalDeposits, 0) }}</div>
            </td>
            <td>
                <div class="label">Interest Earned</div>
                <div class="amount amount-orange">UGX {{ number_format($totalInterest, 0) }}</div>
            </td>
        </tr>
    </table>

    <h3 style="color: #1a472a; margin-bottom: 5px;">Transaction History</h3>
    <p style="color: #666; margin-top: 0; font-size: 11px;">Total transactions: {{ $transactions->count() }}</p>

    <table class="transactions">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Interest</th>
                <th class="text-right">Total</th>
                <th class="text-center">Status</th>
                <th>Transaction ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                    <td>
                        <span class="badge {{ $transaction->type == 'deposit' ? 'badge-deposit' : 'badge-withdrawal' }}">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </td>
                    <td class="text-right">UGX {{ number_format($transaction->amount, 0) }}</td>
                    <td class="text-right">
                        @if($transaction->interest_rate > 0)
                            UGX {{ number_format($transaction->final_amount - $transaction->amount, 0) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">UGX {{ number_format($transaction->final_amount, 0) }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $transaction->status }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated report from Nakawa Market Savings Group (NMSG).</p>
        <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
    </div>
</body>
</html>
