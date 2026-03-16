<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        h1 { color: #2563eb; font-size: 16px; margin-bottom: 4px; }
        p { margin: 2px 0; color: #666; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #2563eb; color: white; padding: 8px; text-align: left; font-size: 10px; }
        td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
        .total-row { font-weight: bold; background: #eff6ff !important; }
        .footer { margin-top: 20px; text-align: center; color: #999; font-size: 9px; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Payroll Report — {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h1>
    <p>Generated: {{ now()->format('F d, Y h:i A') }}</p>
    <p>Total Employees: {{ $payrolls->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th class="text-right">Gross Pay</th>
                <th class="text-right">Deductions</th>
                <th class="text-right">Net Pay</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $payroll)
            <tr>
                <td>{{ $payroll->employee?->full_name ?? '—' }}</td>
                <td class="text-right">₱{{ number_format($payroll->gross_pay, 2) }}</td>
                <td class="text-right">₱{{ number_format($payroll->total_deductions, 2) }}</td>
                <td class="text-right">₱{{ number_format($payroll->net_pay, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="text-right">₱{{ number_format($summary['total_gross'], 2) }}</td>
                <td class="text-right">₱{{ number_format($summary['total_deductions'], 2) }}</td>
                <td class="text-right">₱{{ number_format($summary['total_net'], 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">HR Management System — Confidential</div>
</body>
</html>