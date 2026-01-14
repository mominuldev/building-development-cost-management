<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan History - {{ $recipient['name'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }

        .header h1 {
            font-size: 24px;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 18px;
            color: #6366f1;
            font-weight: 500;
        }

        .header .date {
            font-size: 11px;
            color: #64748b;
            margin-top: 10px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }

        .recipient-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 13px;
            color: #1e293b;
            font-weight: 500;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card.total-given {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .stat-card.total-repaid {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.outstanding {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #6366f1;
            color: white;
        }

        th {
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        th.text-right {
            text-align: right;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-partial {
            background: #fed7aa;
            color: #9a3412;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .repayment-item {
            background: #f0fdf4;
            padding: 8px;
            margin-left: 20px;
            border-left: 3px solid #10b981;
            margin-top: 8px;
            font-size: 11px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #64748b;
        }

        @page {
            margin: 15mm;
            size: A4;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Loan History Report</h1>
        <h2>{{ $project->name }}</h2>
        <div class="date">Generated on {{ now()->format('F j, Y \a\t g:i A') }}</div>
    </div>

    <!-- Recipient Information -->
    <div class="section">
        <div class="section-title">Recipient Information</div>
        <div class="recipient-info">
            <div class="info-item">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $recipient['name'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone Number</span>
                <span class="info-value">{{ $recipient['phone'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $recipient['address'] ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">National ID</span>
                <span class="info-value">{{ $recipient['nid'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="section">
        <div class="section-title">Summary Statistics</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Loans</div>
                <div class="stat-value">{{ $totalLoans }}</div>
            </div>
            <div class="stat-card total-given">
                <div class="stat-label">Total Given</div>
                <div class="stat-value">{{ number_format($totalGiven, 2) }}</div>
            </div>
            <div class="stat-card total-repaid">
                <div class="stat-label">Total Repaid</div>
                <div class="stat-value">{{ number_format($totalRepaid, 2) }}</div>
            </div>
            <div class="stat-card outstanding">
                <div class="stat-label">Outstanding</div>
                <div class="stat-value">{{ number_format($outstanding, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Loan History -->
    <div class="section">
        <div class="section-title">Loan History</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Loan ID</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th class="text-right">Repaid</th>
                    <th class="text-right">Balance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->loan_date->format('M j, Y') }}</td>
                        <td>#{{ $loan->id }}</td>
                        <td>{{ number_format($loan->amount, 2) }}</td>
                        <td>{{ ucfirst($loan->payment_method) }}</td>
                        <td class="text-right">{{ number_format($loan->amount_repaid, 2) }}</td>
                        <td class="text-right">{{ number_format($loan->remaining_balance, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $loan->status }}">
                                {{ $loan->payment_status_text }}
                            </span>
                        </td>
                    </tr>
                    @if($loan->repayments->count() > 0)
                        @foreach($loan->repayments as $repayment)
                            <tr>
                                <td colspan="7">
                                    <div class="repayment-item">
                                        <strong>Repayment:</strong>
                                        {{ $repayment->payment_date->format('M j, Y') }} -
                                        {{ number_format($repayment->amount, 2) }} via {{ ucfirst($repayment->payment_method) }}
                                        @if($repayment->transaction_reference)
                                            (Ref: {{ $repayment->transaction_reference }})
                                        @endif
                                        @if($repayment->notes)
                                            - {{ $repayment->notes }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Payment Timeline -->
    @if($allRepayments->count() > 0)
    <div class="section">
        <div class="section-title">Payment Timeline</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allRepayments as $repayment)
                    <tr>
                        <td>{{ $repayment->payment_date->format('M j, Y') }}</td>
                        <td>{{ number_format($repayment->amount, 2) }}</td>
                        <td>{{ ucfirst($repayment->payment_method) }}</td>
                        <td>{{ $repayment->transaction_reference ?? 'N/A' }}</td>
                        <td>{{ $repayment->notes ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This document was automatically generated by Construction Cost Calculator</p>
        <p>Project: {{ $project->name }} | Recipient: {{ $recipient['name'] }} | Date: {{ now()->format('F j, Y') }}</p>
    </div>
</body>
</html>
