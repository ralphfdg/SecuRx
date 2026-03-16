<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    public function index()
    {
        return view('pharmacist.dashboard');
    }
}