<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        $inputs = $request->all();
        array_walk_recursive($inputs, function (&$value) {
            $value = $this->cleanInput($value);
        });

        $request->merge($inputs);

        if (Auth::check() && $this->userExistsInDatabase(Auth::user()->id)) {
            return $next($request);
        }
        return redirect('/login');
    }

    private function cleanInput($value)
    {
        $value = strip_tags($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return $value;
    }

    private function userExistsInDatabase($userId)
    {
        return \App\Models\User::find($userId) !== null;
    }
}
