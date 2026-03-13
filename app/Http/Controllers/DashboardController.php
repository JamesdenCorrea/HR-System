<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')){
            return view('dashboard.admin');
        }elseif ($user->hasRole('hr')){
            return view('dashboard.hr');
        }else{
            return view('dashboard.employee');
        }
    }
}
