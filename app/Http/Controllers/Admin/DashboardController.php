<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Notice;
use App\Models\TeacherApplication;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'       => Application::count(),
            'total_teachers'       => TeacherApplication::count(),
            'total_notices'        => Notice::count(),
            'total_visitors'       => Visitor::totalCount(),
            'today_visitors'       => Visitor::todayCount(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
