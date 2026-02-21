<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NMSG Members Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #1a472a;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #1a472a;
            margin: 0 0 5px 0;
            font-size: 22px;
        }
        .header p {
            color: #666;
            margin: 3px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #1a472a;
            color: #ffffff;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 7px 6px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e8f5e9;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary {
            margin-top: 20px;
            padding: 12px;
            background-color: #f0f7f0;
            border: 1px solid #c8e6c9;
            border-radius: 4px;
        }
        .summary h3 {
            margin: 0 0 8px 0;
            color: #1a472a;
            font-size: 13px;
        }
        .summary-row {
            display: inline-block;
            margin-right: 30px;
            font-size: 11px;
        }
        .summary-label {
            color: #666;
        }
        .summary-value {
            font-weight: bold;
            color: #1a472a;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nakawa Market Savings Group</h1>
        <p><strong>Members Report</strong></p>
        <p>Generated on: {{ $generatedAt }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Username</th>
                <th>Next of Kin</th>
                <th>Relationship</th>
                <th>Kin Phone</th>
                <th>Joined</th>
                @if($includeBalances)
                    <th class="text-right">Balance (UGX)</th>
                @endif
                @if($includeTransactions)
                    <th class="text-right">Deposits (UGX)</th>
                    <th class="text-right">Withdrawals (UGX)</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member['num'] }}</td>
                <td>{{ $member['name'] }}</td>
                <td>{{ $member['email'] }}</td>
                <td>{{ $member['phone'] }}</td>
                <td>{{ $member['username'] }}</td>
                <td>{{ $member['next_of_kin_name'] }}</td>
                <td>{{ $member['next_of_kin_relationship'] }}</td>
                <td>{{ $member['next_of_kin_phone'] }}</td>
                <td>{{ $member['joined'] }}</td>
                @if($includeBalances)
                    <td class="text-right">{{ $member['balance'] }}</td>
                @endif
                @if($includeTransactions)
                    <td class="text-right">{{ $member['deposits'] }}</td>
                    <td class="text-right">{{ $member['withdrawals'] }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <span class="summary-row">
            <span class="summary-label">Total Members:</span>
            <span class="summary-value">{{ count($members) }}</span>
        </span>
        @if($includeBalances)
        <span class="summary-row">
            <span class="summary-label">Total Savings:</span>
            <span class="summary-value">UGX {{ number_format(collect($members)->sum(fn($m) => (float) str_replace(',', '', $m['balance'])), 2) }}</span>
        </span>
        @endif
    </div>

    <div class="footer">
        <p>NMSG &copy; {{ date('Y') }} &mdash; Confidential Document</p>
    </div>
</body>
</html>
