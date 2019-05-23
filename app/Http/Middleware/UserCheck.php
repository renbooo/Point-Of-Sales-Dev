<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth as Auth;

class UserCheck{
	public function handle($request, Closure $next, $level){
		$user = Auth::user();
		if($user && $user->level != $level){
			return redirect('/');
		}
		else return $next($request);
	}
}