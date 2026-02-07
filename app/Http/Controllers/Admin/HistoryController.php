<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        $query = $this->applyFilters($query, $request);

        $activities = $query->paginate(25)->withQueryString();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        
        // Define action types for filter - distinct actions found in DB
        // If DB is empty, provide default list from spec
        $actions = ActivityLog::select('action')->distinct()->pluck('action');
        if ($actions->isEmpty()) {
            $actions = collect(['CREATE', 'UPDATE', 'DELETE', 'SCAN', 'LOGIN', 'LOGOUT', 'LOGIN_FAILED', 'EXPORT']);
        }

        return view('admin.history.index', compact('activities', 'users', 'actions'));
    }

    public function show($id)
    {
        $activityLog = ActivityLog::with('user')->findOrFail($id);
        return view('admin.history.show', compact('activityLog'));
    }

    public function export(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        $query = $this->applyFilters($query, $request);

        // Limit export to reasonable size
        $activities = $query->limit(10000)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity_logs_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Action', 'Resource Type', 'Resource ID', 'Description', 'Metadata', 'IP Address', 'User Agent', 'Date']);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->user ? $activity->user->name : 'System',
                    $activity->action,
                    $activity->resource_type,
                    $activity->resource_id,
                    $activity->description,
                    json_encode($activity->metadata),
                    $activity->ip_address,
                    $activity->user_agent,
                    $activity->created_at,
                ]);
            }
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->whereIn('action', (array) $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('metadata', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}
