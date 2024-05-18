<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ITStaffController extends Controller
{
    public function index(){
        return view('itstaff.dashboard');
    }
}
