<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user tidak punya role admin
        if (!$user || !$user->hasRole('admin')) {
            Auth::logout();
            return redirect()->route('filament.admin.auth.login')
                ->with('message', 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
