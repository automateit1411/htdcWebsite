<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display visitor stats and list of all unique IPs
     */
    public function index(Request $request)
    {
        $totalVisitors = Visitor::totalCount();
        $todayVisitors = Visitor::todayCount();

        // Daily stats (last 30 days)
        $dailyStats = Visitor::dailyStats(30);

        // All unique IPs with their last visit and total days visited
        $visitors = Visitor::selectRaw('ip_address, user_agent, MAX(visited_at) as last_visit, COUNT(*) as days_visited')
            ->groupBy('ip_address', 'user_agent')
            ->orderByDesc('last_visit')
            ->paginate(20);

        // Blocked IPs
        $blockedIps = BlockedIp::orderByDesc('created_at')->get();

        return view('admin.visitors.index', compact(
            'totalVisitors',
            'todayVisitors',
            'dailyStats',
            'visitors',
            'blockedIps'
        ));
    }

    /**
     * Block an IP address
     */
    public function block(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|string|max:45',
            'reason'     => 'nullable|string|max:255',
        ]);

        BlockedIp::updateOrCreate(
            ['ip_address' => $request->ip_address],
            ['reason'     => $request->reason]
        );

        return back()->with('success', __('admin.ip_blocked', ['ip' => $request->ip_address]));
    }

    /**
     * Unblock an IP address
     */
    public function unblock($id)
    {
        $blocked = BlockedIp::findOrFail($id);
        $ip = $blocked->ip_address;
        $blocked->delete();

        return back()->with('success', __('admin.ip_unblocked', ['ip' => $ip]));
    }

    /**
     * Reset (delete) all visitor records
     */
    public function reset()
    {
        Visitor::truncate();
        return back()->with('success', __('admin.visitors_reset'));
    }
}
