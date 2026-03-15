<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = Attendance::with('employee');

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    if ($request->filled('employee_id') && $request->employee_id !== '') {
        $query->where('employee_id', (int) $request->employee_id);
    }

    if ($request->filled('status') && $request->status !== '') {
        if ($request->status === 'present') {
            // Present includes present, late and half-day
            $query->whereIn('status', ['present', 'late', 'half-day']);
        } else {
            $query->where('status', $request->status);
        }
    }

    $attendances = $query->latest('date')->paginate(20)->withQueryString();
    $employees   = Employee::where('employment_status', 'active')->get();

    return view('attendance.index', compact('attendances', 'employees'));
}

    // clock in / out page

    public function clockPage()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        $today = Carbon::today();
        $attendance = null;

        if ($employee){
            $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();
        }

        return view('attendance.clock', compact('employee', 'attendance'));
    }

        // clock in
        public function clockIn(Request $request)
        {
            $employee = Employee::where('user_id', auth()->id())->firstOrFail();

            $today = Carbon::today();
            $existing = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

            if ($existing){
                return back()->with('error', 'You have already clocked in today.');
            }
            $clockInTime = Carbon::now();
            $workStart = Carbon::today()->setTime (9,0);
            $status = $clockInTime->greaterThan($workStart) ? 'late' : 'present';

            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'clock_in' => $clockInTime->format('H:i:s'),
                'status' => $status,
                'ip_address' => $request->ip(),
            ]);

            return back()->with('success', 'Clocked in successfully at' . $clockInTime->format('h:i A'));
        }

        // clock out
        public function clockOut(Request $request)
        {
            $employee = Employee::where('user_id', auth()->id())->firstOrFail();
            $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', Carbon::today())
            ->firstOrFail();

            if($attendance->clock_out){
                return back()->with('error', 'You have already clocked out today.');
            }

            $attendance->update([
                'clock_out' => Carbon::now()->format('H:i:s'),
            ]);

            return back()->with('success', 'Clocked out successfully at'. Carbon::now()->format('h:i A'));
        }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // manual attendance entry
            $employees = Employee::where('employment_status', 'active')->get();
            return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date'        => 'required|date',
        'status'      => 'required|in:present,late,absent,half-day',
        'notes'       => 'nullable|string|max:255',
    ]);

    // Clock in and out are set to current server time automatically
    $now = Carbon::now();

    $existing = Attendance::where('employee_id', $validated['employee_id'])
        ->whereDate('date', $validated['date'])
        ->first();

    if ($existing) {
        // If record exists and no clock out yet, set clock out
        if (!$existing->clock_out) {
            $existing->update([
                'clock_out' => $now->format('H:i:s'),
                'status'    => $validated['status'],
                'notes'     => $validated['notes'] ?? null,
            ]);
        } else {
            return back()->with('error', 'Attendance record for this employee on this date already exists.');
        }
    } else {
        // New record — set clock in to now
        Attendance::create([
            'employee_id' => $validated['employee_id'],
            'date'        => $validated['date'],
            'clock_in'    => $now->format('H:i:s'),
            'status'      => $validated['status'],
            'notes'       => $validated['notes'] ?? null,
        ]);
    }

    return redirect()->route('hr.attendance.index')
        ->with('success', 'Attendance record saved at ' . $now->format('h:i A') . '.');
}

    public function monthlyReport(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $employees = Employee::where('employment_status', 'active')
        ->with(['attendances' => function ($q) use ($month){
            $q->whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2));
        }])->get();
        return view('attendance.monthly', compact('employees', 'month'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
