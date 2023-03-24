<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            if (auth()->user()->role == "admin") {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->role == "kepala") {
                return redirect()->route('kepala.dashboard');
            }
        }
        return view('index');
    }

    public function root()
    {
        return view('welcome');
    }
}
