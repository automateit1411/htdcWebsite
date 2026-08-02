<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyAttendance;
use App\Models\ProgramGroup;
use Illuminate\Http\Request;

class DailyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyAttendance::with('programGroup');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('program')) {
            $query->whereHas('programGroup', function ($q) use ($request) {
                $q->where('program', $request->program);
            });
        }

        $attendances = $query->latest('date')->paginate(20)->withQueryString();
        $programGroups = ProgramGroup::where('is_active', true)->get();

        return view('admin.daily-attendances.index', compact('attendances', 'programGroups'));
    }

    public function create()
    {
        $programGroups = ProgramGroup::where('is_active', true)->get();
        return view('admin.daily-attendances.create', compact('programGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'program_group_id' => 'required|exists:program_groups,id',
            'total_students' => 'required|integer|min:0',
            'present_students' => 'required|integer|min:0|lte:total_students',
        ]);

        DailyAttendance::updateOrCreate(
            [
                'date' => $request->date,
                'program_group_id' => $request->program_group_id,
            ],
            [
                'total_students' => $request->total_students,
                'present_students' => $request->present_students,
            ]
        );

        return redirect()->route('admin.daily-attendances.index')
            ->with('success', 'Attendance saved successfully.');
    }

    public function edit(DailyAttendance $dailyAttendance)
    {
        $programGroups = ProgramGroup::where('is_active', true)->get();
        return view('admin.daily-attendances.edit', compact('dailyAttendance', 'programGroups'));
    }

    public function update(Request $request, DailyAttendance $dailyAttendance)
    {
        $request->validate([
            'date' => 'required|date',
            'program_group_id' => 'required|exists:program_groups,id',
            'total_students' => 'required|integer|min:0',
            'present_students' => 'required|integer|min:0|lte:total_students',
        ]);

        $dailyAttendance->update([
            'date' => $request->date,
            'program_group_id' => $request->program_group_id,
            'total_students' => $request->total_students,
            'present_students' => $request->present_students,
        ]);

        return redirect()->route('admin.daily-attendances.index')
            ->with('success', 'Attendance updated successfully.');
    }

    public function destroy(DailyAttendance $dailyAttendance)
    {
        $dailyAttendance->delete();
        return redirect()->route('admin.daily-attendances.index')
            ->with('success', 'Attendance deleted successfully.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.program_group_id' => 'required|exists:program_groups,id',
            'attendances.*.total_students' => 'required|integer|min:0',
            'attendances.*.present_students' => 'required|integer|min:0',
        ]);

        foreach ($request->attendances as $attendance) {
            DailyAttendance::updateOrCreate(
                [
                    'date' => $request->date,
                    'program_group_id' => $attendance['program_group_id'],
                ],
                [
                    'total_students' => $attendance['total_students'],
                    'present_students' => $attendance['present_students'],
                ]
            );
        }

        return redirect()->route('admin.daily-attendances.index')
            ->with('success', 'All attendance records saved successfully.');
    }

    public function bulkCreate()
    {
        $programGroups = ProgramGroup::where('is_active', true)->get();
        return view('admin.daily-attendances.bulk-create', compact('programGroups'));
    }
}
