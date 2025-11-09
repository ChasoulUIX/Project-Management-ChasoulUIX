<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $project->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px 20px;
            background: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        
        .invoice-container {
            width: 100%;
            max-width: 800px;
            background: white;
            border: 2px solid #2563eb;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 32px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .invoice-title {
            font-size: 20px;
            color: #64748b;
            margin-top: 10px;
            font-weight: 600;
        }
        
        .invoice-number {
            font-size: 14px;
            color: #94a3b8;
            margin-top: 5px;
        }
        
        .project-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #2563eb;
        }
        
        .project-info h2 {
            color: #1e293b;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #475569;
        }
        
        .info-value {
            color: #1e293b;
        }
        
        .description {
            background: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #f59e0b;
        }
        
        .description h3 {
            color: #92400e;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .description p {
            color: #78350f;
            line-height: 1.6;
            font-size: 14px;
        }
        
        .payment-history {
            margin-bottom: 30px;
        }
        
        .payment-history h3 {
            color: #1e293b;
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background: #2563eb;
            color: white;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }
        
        tbody tr:hover {
            background: #f8fafc;
        }
        
        .amount {
            font-weight: bold;
            color: #059669;
        }
        
        .summary {
            background: #ecfdf5;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #059669;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .summary-row.total {
            font-size: 18px;
            font-weight: bold;
            color: #065f46;
            padding-top: 10px;
            border-top: 2px solid #059669;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .print-button:hover {
            background: #1d4ed8;
        }
        
        @media print {
            .print-button {
                display: none;
            }
            
            body {
                background: white;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border: 2px solid #2563eb;
                max-width: 100%;
            }
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-process {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-cancel {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">
        🖨️ Print PDF
    </button>

    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">ChasoulUIX Development</div>
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-number">INV-{{ strtoupper(substr(md5($project->id . $project->created_at), 0, 8)) }}</div>
        </div>

        <!-- Project Information -->
        <div class="project-info">
        <h2>Project Information</h2>
        <div class="info-row">
            <div class="info-label">Project Name:</div>
            <div class="info-value">{{ $project->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Client:</div>
            <div class="info-value">{{ $client->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Project Value:</div>
            <div class="info-value">Rp {{ number_format($project->price, 0, ',', '.') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                <span class="status-badge status-{{ $project->status }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Created Date:</div>
            <div class="info-value">{{ $project->created_at->format('d F Y') }}</div>
        </div>
        </div>

        <!-- Description/Notes -->
        @if($project->notes)
        <div class="description">
        <h3>Project Description</h3>
            <p>{{ $project->notes }}</p>
        </div>
        @endif

        <!-- Payment History -->
        <div class="payment-history">
            <h3>Payment History</h3>
            
            @if($payments->count() > 0)
            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->payment_date->format('d M Y') }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td class="amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->notes ?? '-' }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Summary -->
            <div class="summary">
            <div class="summary-row">
                <span>Total Project Value:</span>
                <span>Rp {{ number_format($project->price, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Total Paid:</span>
                <span>Rp {{ number_format($project->total_paid, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Remaining Balance:</span>
                <span>Rp {{ number_format($project->remaining_balance, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Payment Progress:</span>
                <span>{{ number_format($project->payment_progress, 1) }}%</span>
            </div>
            </div>
            @else
            <p style="text-align: center; color: #94a3b8; padding: 40px;">No payment records found</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
            <p>ChasoulUIX Development - Invoice</p>
        </div>
    </div>
</body>
</html>
