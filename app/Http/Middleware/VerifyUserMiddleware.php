<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelp;
use App\Models\Users;
use Closure;
use Illuminate\Http\Request;

class VerifyUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->id;
        $user = Users::where('id', $userId)->first();
        if (empty($user)) {
           return ResponseHelp::error("User doesn't Exist", [], 400);
        }
        $request->request->add(['mobile' => $user->mobile, 'email' => $user->email]);
        return $next($request);
    }
}
