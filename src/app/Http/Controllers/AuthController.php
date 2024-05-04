<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;



    class AuthController extends Controller
    {
        public function index()
        {
            $categories=Category::all();

            return view('register',compact('categories'));
        }

        public function register(Request $request) {

            $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);



            return redirect()->route('login');
        }

        public function login()
        {
            return view('login');
        }

        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }


    }