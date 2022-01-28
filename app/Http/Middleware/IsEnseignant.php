<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEnseignant
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->isEnseignant()) {
            return $next($request);
        }
        abort(403,'Vous n êtes pas enseignant');
    }
}
