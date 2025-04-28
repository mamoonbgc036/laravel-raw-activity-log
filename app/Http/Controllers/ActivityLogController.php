<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::with(['subject', 'causer'])->latest()->get();
        return view('activity_logs.index', compact('activities'));
    }
}
