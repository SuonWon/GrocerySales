<?php

namespace App\Http\Middleware;

use App\Models\SystemRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class mymiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
      
                $user = auth()->user();
        
                if (!$user) {
                    return redirect('/login')->with('warning','You must login!');
                }
                

     
               
                
                $allows = explode(',',$user->systemrole->RolePermissions);

                // dd($role);
                // dd($allows);

                // string to array  (explode)
                foreach ($allows as $allow) {
                    if($allow == $role || $allow == "all"){
                        return $next($request);
                    }
                }
            
            return redirect()->route('saleinvoices')->with('warning', 'Unauthorized access.');
    
        }
       
    }

