<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\group;

class GroupOwner
{

    public function handle(Request $request, Closure $next)
    {
        $group = group::find($request->id);
        if ($group->admin_id == auth()->user()->id)
        {
            return $next($request);
        }
        else
        {
        return redirect('/home')->with('error', 'Unauthorized');
        }
    }
}
