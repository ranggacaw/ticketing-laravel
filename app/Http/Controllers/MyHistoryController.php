<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id())->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(25)->withQueryString();
        
        // Actions for this user
        $actions = ActivityLog::where('user_id', Auth::id())->select('action')->distinct()->pluck('action');
        if ($actions->isEmpty()) {
            $actions = collect(['LOGIN', 'LOGOUT']);
        }

        return view('my.history.index', compact('activities', 'actions'));
    }
}
