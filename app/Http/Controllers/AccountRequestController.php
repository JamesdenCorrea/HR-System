<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\User;
use App\Mail\AccountApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountRequestController extends Controller
{
    // view own request
    public function index()
    {
        $request = AccountRequest::where('requested_by', auth()->id())
        ->latest()->paginate(10);
        return view('account-requests.index', compact('request'));
    }

    // show request form
    public function create()
    {
        return view('account-requests.create');
    }

    // submit request

    public function store(Request $request)
    {
        $validated= $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|unique:account_requests,email',
            'role' => 'required|in:hr,employee',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
        ]);

        AccountRequest::create([
            ...$validated,
            'requested_by' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('account-requests.index')
        ->with('success', 'Account request submitted. Waiting for admin approval.');
    }

    // admin - view all pending request
    public function adminIndex()
    {
        $request = AccountRequest::with('requestedBy')
        ->latest()->paginate(15);

        return view('account-requests.admin-index', compact('request'));
    }

    // admin - approve and create account
    public function approve(AccountRequest $accountRequest)
    {
        if ($accountRequest->status !== 'pending'){
            return back()->with('error', 'This request has already been processed.');
        }
        // generate random password
        $plainPassword = Str::random(10);

        // Create the user account
        $user = User::create([
            'name' => $accountRequest->name,
            'email' => $accountRequest->email,
            'password' => Hash::make($plainPassword),
            'must_change_password' => true,
        ]);

        // assign role

        $user->assignRole($accountRequest->role);

        // generate employee ID

        $lastEmployee = Employee::withTrashed()->orderBy('id' , 'desc')->first();
        $nextNumber = $lastEmployee ? ($lastEmployee->id + 1) : 1;
        $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Create employee record
        $nameParts = explode(' ', $accountRequest->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $employee = Employee::create([
            'employee_id' => $employeeId,
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $accountRequest->email,
            'department' => $accountRequest->department ?? 'Unassigned',
            'position' => $accountRequest->position ?? 'Unassigned',
            'date_hired' => now()->format('Y-m-d'),
            'employment_status' => 'active',
        ]);
        // Create leave balance
        LeaveBalance::create([
            'employee_id' => $employee->id,
            'year' => now()->year,
            'vacation_total' => 15, 'vacation_used' => 0,
            'sick_total' => 15, 'sick_used' => 0,
            'emergency_total' => 5, 'emergency_used' => 0,
        ]);

        // update request status
        $accountRequest->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
        ]);
        // send email with credentials
        Mail::to($accountRequest->email)->send(
            new AccountApprovedMail(
                $accountRequest->name,
                $accountRequest->email,
                $plainPassword,
                $accountRequest->role
            )
        );
        return back()->with('success',
        "Account approved! Credentials sent to {$accountRequest->email}. ". 
        "Temporary password: {$plainPassword}"
        );
    }

    // admin reject request
    public function reject(Request $request, AccountRequest $accountRequest)
    {
        if($accountRequest->status !== 'pending'){
            return back()->with('error', 'This request has already processed.');
        }
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $accountRequest->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        return back()->with('success', 'Account request rejected.');
    }
}
