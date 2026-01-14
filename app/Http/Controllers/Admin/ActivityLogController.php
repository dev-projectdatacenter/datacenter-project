<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Récupérer tous les logs (simple)
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();

        return view('admin.activity_logs.index', compact('logs'));
    }
}
