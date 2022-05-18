<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin as AdminModel;

class Admin
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
        if (AdminModel::all()->count() == 0) {
            $request->user()->admin()->create(['main' => true]);
        }
        if ($request->user()->admin()->count() == 0) {
            return response()->json([
                'errorAuth' => 'Not admin',
            ]);
        }
        return $next($request);
    }
}
