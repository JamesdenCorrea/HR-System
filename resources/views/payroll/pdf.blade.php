<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { color: #2563eb; margin: 0; font-size: 20px; }
        .header p { margin: 4px 0; color: #666; font-size: 11px; }
        .section-title { background: #2563eb; color: white; padding: 6px 12px; font-weight: bold; margin: 16px 0 8px; font-size: 11px; }
        .info-grid { display: table; width: 100%; margin-bottom: 12px; }
        .info-row { display: table-row; }
        .info-cell { display: table-cell; width: 50%; padding: 4px 0; }
        .info-label { color: #666; font-size: 10px; }
        .info-value { font-weight: bold; font-size: 11px; }
        .two-col { width: 100%; border-collapse: collapse; }
        .two-col td { width: 50%; vertical-align: top; padding: 0 10px 0 0; }
        .line-item { display: flex; justify-content: space-between; padding: 3px 0; border-bottom: 1px solid #f0f0f0; }
        .line-item.total { font-weight: bold; border-top: 2px solid #333; border-bottom: none; padding-top: 6px; }
        .net-pay { text-align: center; background: #f0fdf4; border: 2px solid #16a34a; padding: 16px; margin-top: 20px; }
        .net-pay .label { color: #666; font-size: 11px; }
        .net-pay .amount { color: #16a34a; font-size: 24px; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #999; font-size: 10px; border-top: 1px solid #eee; padding-top: 12px; }
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; background: #fef3c7; color: #92400e; }
        .status-released { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HR Management System</h1>
        <p>PAYSLIP — {{ strtoupper($payroll->period_label) }}</p>
        <p>{{ $payroll->period_start->format('F d') }} — {{ $payroll->period_end->format('F d, Y') }}</p>
        <span class="status-badge {{ $payroll->status === 'released' ? 'status-released' : '' }}">
            {{ strtoupper($payroll->status) }}
        </span>
    </div>

    <div class="section-title">EMPLOYEE INFORMATION</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Employee Name</div>
                <div class="info-value">{{ $payroll->employee?->full_name }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Employee ID</div>
                <div class="info-value">{{ $payroll->employee?->employee_id }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $payroll->employee?->department }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Position</div>
                <div class="info-value">{{ $payroll->employee?->position }}</div>
            </div>
        </div>
    </div>

    <table class="two-col">
        <tr>
            <td>
                <div class="section-title">EARNINGS</div>
                <div class="line-item">
                    <span>Basic Salary</span>
                    <span>₱{{ number_format($payroll->basic_salary, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>Allowance</span>
                    <span>₱{{ number_format($payroll->allowance, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>Overtime Pay</span>
                    <span>₱{{ number_format($payroll->overtime_pay, 2) }}</span>
                </div>
                <div class="line-item total">
                    <span>GROSS PAY</span>
                    <span>₱{{ number_format($payroll->gross_pay, 2) }}</span>
                </div>
            </td>
            <td>
                <div class="section-title">DEDUCTIONS</div>
                <div class="line-item">
                    <span>SSS</span>
                    <span>₱{{ number_format($payroll->sss_deduction, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>PhilHealth</span>
                    <span>₱{{ number_format($payroll->philhealth_deduction, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>Pag-IBIG</span>
                    <span>₱{{ number_format($payroll->pagibig_deduction, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>Tax</span>
                    <span>₱{{ number_format($payroll->tax_deduction, 2) }}</span>
                </div>
                <div class="line-item">
                    <span>Other Deductions</span>
                    <span>₱{{ number_format($payroll->other_deductions, 2) }}</span>
                </div>
                <div class="line-item total">
                    <span>TOTAL DEDUCTIONS</span>
                    <span>₱{{ number_format($payroll->total_deductions, 2) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="net-pay">
        <div class="label">NET PAY</div>
        <div class="amount">₱{{ number_format($payroll->net_pay, 2) }}</div>
    </div>

    <div class="footer">
        <p>This is a system-generated payslip. Generated on {{ now()->format('F d, Y h:i A') }}</p>
        <p>HR Management System — Confidential</p>
    </div>
</body>
</html>