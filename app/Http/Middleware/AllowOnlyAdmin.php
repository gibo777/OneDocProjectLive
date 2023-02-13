<?php
    
    namespace App\Http\Middleware;
    
    use Closure;
    use Illuminate\Support\Facades\Auth;
    
    class AllowOnlyAdmin
    {
        public function handle($request, Closure $next)
        {
            if (Auth::user()->role_type=='SUPER ADMIN') {
                return $next($request);
            }
            
            abort(403);
        }
    }