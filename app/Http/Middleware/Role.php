<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next,... $roles) :Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        // Agar foydalanuvchining roli mos kelmasa, bosh sahifaga qaytaradi
        return redirect()->route('index')->with('error', 'Sizda ushbu sahifaga kirish huquqi mavjud emas.');
    }
}
