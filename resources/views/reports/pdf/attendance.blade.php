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
    <h1>Attendance Report — {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h1>
    <p>Generated: {{ now()->format('F d, Y h:i A') }}</p>
    <p>Total Records: {{ $records->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->employee?->full_name ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                <td>{{ $record->clock_in ? \Carbon\Carbon::parse($record->clock_in)->format('h:i A') : '—' }}</td>
                <td>{{ $record->clock_out ? \Carbon\Carbon::parse($record->clock_out)->format('h:i A') : '—' }}</td>
                <td>{{ $record->work_hours }}</td>
                <td>{{ ucfirst($record->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">HR Management System — Confidential</div>
</body>
</html>