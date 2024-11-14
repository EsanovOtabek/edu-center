<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') return redirect()->route('admin.index');
//            if (Auth::user()->role == 'teacher') return redirect()->route('teacher.index');
        }
        return view('login');
    }


    public function loginCheck(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = $request->only('login', 'password');

        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            $r = new RoleController();
            $successMessage = $r->getAuthMessage($role);
            session(['userRole'=>$role]);
            session(['userDescription'=> $r->getRoleDescription($role)]);
            return redirect($role)->with('success_msg', $successMessage);
        }

        return redirect()->route('login')->with('error_msg', "Login yoki parol xato");
    }


    public function logout(){
        session()->flush();
        Auth::logout();
        session()->regenerate();
        return redirect()->route('login');
    }
}
