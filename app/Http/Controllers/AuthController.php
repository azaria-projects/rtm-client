<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('layouts.auth.login');
    }

    public function register()
    {
        return view('layouts.auth.register');
    }
}
