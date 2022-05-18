<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin as AdminModel;
use App\Models\User;

class mainAdmin
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
        if ($request->user()->admin()->first("main")["main"] == 0) {
            $mainAdmin = AdminModel::where('main', true)->first("user_id");
            return response()->json([
                'errorAuth' => 'This action is allowed only for main admin: ' . User::where("id", $mainAdmin["user_id"])->first("name")["name"]
            ]);
        }
        return $next($request);
    }
}
