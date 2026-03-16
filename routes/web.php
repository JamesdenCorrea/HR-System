<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // employee view own payslips
    Route::get('/my-payslips', [PayrollController::class, 'myPayslips'])->name('payroll.my-payslips');

    // Breeze profile routes (required by navigation.blade.php)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Force password change
    Route::get('/change-password', [PasswordChangeController::class, 'show'])->name('password.change');
    Route::post('/change-password', [PasswordChangeController::class, 'update'])->name('password.change.update');

    // Clock in/out (authenticated users)
    Route::get('/attendance/clock', [AttendanceController::class, 'clockPage'])->name('attendance.clock');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
    
    // Leave - employee routes
    Route::get('/leaves/my', [LeaveController::class, 'myLeaves'])->name('leaves.my');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');

    // Account requests - HR submits
    Route::get('/account-requests', [AccountRequestController::class, 'index'])->name('account-requests.index');
    Route::get('/account-requests/create', [AccountRequestController::class, 'create'])->name('account-requests.create');
    Route::post('/account-requests', [AccountRequestController::class,'store'])->name('account-requests.store');

});

// Admin only
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin routes will go here
    Route::get('account-requests', [AccountRequestController::class, 'adminIndex'])->name('account-requests.index');
    Route::post('account-requests/{accountRequest}/approve', [AccountRequestController::class, 'approve'])->name('account-requests.approve');
    Route::post('account-requests/{accountRequest}/reject', [AccountRequestController::class, 'reject'])->name('account-requests.reject');
});

// Admin and HR
Route::middleware(['auth', 'role:admin,hr'])->prefix('hr')->name('hr.')->group(function () {
    // HR routes will go here
    Route::resource('employees', EmployeeController::class);

    //Attendance Managements
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/monthly', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthly');

    //Leave management
    Route::get('leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::post('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::get('leave-balances', [LeaveController::class, 'balances'])->name('leaves.balances');

    //Payroll management
    Route::get('payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
    Route::post('payroll', [PayrollController::class, 'store'])->name('payroll.store');
    Route::get('payroll/{payroll}', [PayrollController::class, 'show'])->name('payroll.show');
    Route::post('payroll/{payroll}/release',[PayrollController::class, 'release'])->name('payroll.release');
    Route::get('payroll/{payroll}/pdf', [PayrollController::class, 'downloadPdf'])->name('payroll.pdf');
    Route::get('payroll-salary', [PayrollController::class, 'salaryIndex'])->name('payroll.salary-index');
    Route::get('payroll-salary/{employee}/edit', [PayrollController::class, 'salaryEdit'])->name('payroll.salary-edit');
    Route::post('payroll-salary/{employee}', [PayrollController::class, 'salaryUpdate'])->name('payroll.salary-update');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('reports/leaves', [ReportController::class, 'leaves'])->name('reports.leaves');
    Route::get('reports/payroll', [ReportController::class, 'payroll'])->name('reports.payroll');
    Route::get('reports/export/{type}/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('reports/export/{type}/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

require __DIR__.'/auth.php';