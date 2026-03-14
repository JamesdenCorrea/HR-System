<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees,employee_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'date_hired' => 'required|date',
            'employment_status' => 'required|in:active,inactive,resigned,terminated',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('profile_photo')){
            $validated['profile_photo'] = $request->file('profile_photo')
            ->store('profile_photos', 'public');
        }
        Employee::create($validated);

        return redirect()->route('hr.employees.index')
        ->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Employee $employee)
{
    $validated = $request->validate([
        'employee_id'       => 'required|unique:employees,employee_id,' . $employee->id,
        'first_name'        => 'required|string|max:100',
        'last_name'         => 'required|string|max:100',
        'email'             => 'required|email|unique:employees,email,' . $employee->id,
        'phone'             => 'nullable|string|max:20',
        'department'        => 'required|string|max:100',
        'position'          => 'required|string|max:100',
        'date_hired'        => 'required|date',
        'employment_status' => 'required|in:active,inactive,resigned,terminated',
        'profile_photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
    ]);

    if ($request->hasFile('profile_photo')) {
        if ($employee->profile_photo) {
            Storage::disk('public')->delete($employee->profile_photo);
        }
        $validated['profile_photo'] = $request->file('profile_photo')
            ->store('profile_photos', 'public');
    }

    $employee->update($validated);

    return redirect()->route('hr.employees.index')
        ->with('success', 'Employee updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('hr.employees.index')
        ->with('success', 'Employee deleted Successfully.');
    }
}
