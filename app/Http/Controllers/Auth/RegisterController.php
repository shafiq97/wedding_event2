<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function showRegistrationForm2()
    {
        return view('auth.register2');
    }

    public function register2(Request $request)
    {
        // Add your registration logic here
    }

}