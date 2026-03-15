<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveBalance;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // all leave requests

        $query = Leave::with('employee');

        if ($request->filled('status')){
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')){
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->filled('employee_id')){
            $query->where('employee_id', (int) $request->employee_id);
        }

        $leaves = $query->latest()->paginate(15)->withQueryString();
        $employees = Employee::where('employment_status', 'active')->get();

        return view('leaves.index', compact('leaves','employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // file a leave request
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $balance = LeaveBalance::firstOrCreate(
            ['employee_id' => $employee->id, 'year' => now()->year],
            [
                'vacation_total' => 15,
                'vacation_used' => 0,
                'sick_total' => 15,
                'sick_used' => 0,
                'emergency_total' => 5,
                'emergency_used' => 0,
            ]
        );

        return view('leaves.create', compact('employee', 'balance'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // submit a leave request
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    $validated = $request->validate([
        'leave_type' => 'required|in:vacation,sick,emergency',
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'reason'     => 'required|string|max:500',
    ]);

    $startDate     = Carbon::parse($validated['start_date']);
    $endDate       = Carbon::parse($validated['end_date']);
    $daysRequested = $startDate->diffInWeekdays($endDate) + 1;

    $balance = LeaveBalance::firstOrCreate(
        ['employee_id' => $employee->id, 'year' => now()->year],
        [
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]
    );

    $remainingKey = $validated['leave_type'] . '_remaining';
    if ($balance->$remainingKey < $daysRequested) {
        return back()->withInput()->with('error',
            "Insufficient {$validated['leave_type']} leave balance. " .
            "You have {$balance->$remainingKey} day(s) remaining."
        );
    }

    Leave::create([
        'employee_id'    => $employee->id,
        'leave_type'     => $validated['leave_type'],
        'start_date'     => $validated['start_date'],
        'end_date'       => $validated['end_date'],
        'days_requested' => $daysRequested,
        'reason'         => $validated['reason'],
        'status'         => 'pending',
    ]);

    return redirect()->route('leaves.my')
        ->with('success', "Leave request submitted for {$daysRequested} day(s).");
}

public function myLeaves()
{
    $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    $leaves = Leave::where('employee_id', $employee->id)
        ->latest()->paginate(10);

    $balance = LeaveBalance::firstOrCreate(
        ['employee_id' => $employee->id, 'year' => now()->year],
        [
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]
    );

    // Calculate pending days per type
    $pendingDays = Leave::where('employee_id', $employee->id)
        ->where('status', 'pending')
        ->get()
        ->groupBy('leave_type')
        ->map(fn($group) => $group->sum('days_requested'));

    return view('leaves.my', compact('leaves', 'balance', 'pendingDays'));
}

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        // show leave details
        return view('leaves.show', compact('leave'));
    }

public function approve(Leave $leave)
{
    // approve leave
    if ($leave->status !== 'pending') {
        return back()->with('error', 'This leave request has already been processed.');
    }

    // Check if employee still has enough balance before approving
    $balance = LeaveBalance::firstOrCreate(
        ['employee_id' => $leave->employee_id, 'year' => now()->year],
        [
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]
    );

    $remainingKey = $leave->leave_type . '_remaining';
    if ($balance->$remainingKey < $leave->days_requested) {
        return back()->with('error',
            "Cannot approve. Employee only has {$balance->$remainingKey} " .
            "{$leave->leave_type} day(s) remaining but requested {$leave->days_requested}."
        );
    }

    $leave->update([
        'status'      => 'approved',
        'approved_by' => auth()->id(),
    ]);

    $usedKey = $leave->leave_type . '_used';
    $balance->increment($usedKey, $leave->days_requested);

    return back()->with('success',
        "Leave approved. {$leave->days_requested} {$leave->leave_type} day(s) deducted from balance."
    );
}

    public function reject(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending'){
            return back()->with('error', 'This leave request has already been processed.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Leave request rejected.');
    }

    public function balances()
    {
        $employees = Employee::where('employment_status', 'active')
        ->with(['leaveBalance'])->get();

        return view('leaves.balances', compact('employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
