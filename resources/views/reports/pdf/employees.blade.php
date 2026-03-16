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
        .footer { margin-top: 20px; text-align: center; color: #999; font-size: 9px; }
    </style>
</head>
<body>
    <h1>Employee Report</h1>
    <p>Generated: {{ now()->format('F d, Y h:i A') }}</p>
    <p>Total Employees: {{ $employees->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Date Hired</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            <tr>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->full_name }}</td>
                <td>{{ $emp->department }}</td>
                <td>{{ $emp->position }}</td>
                <td>{{ \Carbon\Carbon::parse($emp->date_hired)->format('M d, Y') }}</td>
                <td>{{ ucfirst($emp->employment_status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">HR Management System — Confidential</div>
</body>
</html>