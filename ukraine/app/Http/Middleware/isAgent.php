<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Auth\Guard;

class isAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $role)
    {

        if ($this->auth->guest()) {

            if ($request->ajax())
                return response('Unauthorized.', 401);
            else
                return redirect()->guest('login');
        }

        dd($request->user());


        if (!$request->user()->hasRole($role)) {
            return redirect('forbidden');
        }


        if (\Auth::User()->type_account == 1) {
            return redirect('account');
        }

        return $next($request);
    }

    public function hasRole($role)
    {
        switch ($role) {
            case "admin":
                return true;
                break;

            case "editor":
                return true;
                break;
        }

        return false;
    }
}
