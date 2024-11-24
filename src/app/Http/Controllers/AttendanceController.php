<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'break_start' => 'nullable|date_format:H:i:s',
            'break_end' => 'nullable|date_format:H:i:s',
        ]);

        
        $attendance = Attendance::where('user_id', auth()->id())
                                ->whereDate('created_at', Carbon::today())
                                ->first();

        
        if (!$attendance) {
            $attendance = new Attendance;
            $attendance->user_id = auth()->id();
        }

        
        if ($request->has('start_time') && !$attendance->start_time) {
            $attendance->start_time = $validatedData['start_time'];
        }

        if ($request->has('end_time') && !$attendance->end_time) {
            $attendance->end_time = $validatedData['end_time'];
        }

        if ($request->has('break_start') && !$attendance->break_start) {
            $attendance->break_start = $validatedData['break_start'];
        }

        if ($request->has('break_end') && !$attendance->break_end) {
            $attendance->break_end = $validatedData['break_end'];
        }

        $attendance->save();

        
        if ($request->has('break_start') && $request->has('break_end')) {
            $breakTime = new BreakTime();
            $breakTime->attendance_id = $attendance->id;
            $breakTime->break_start = $validatedData['break_start'];
            $breakTime->break_end = $validatedData['break_end'];
            $breakTime->save();
        }

        return redirect()->back();
    }

    public function showAttendance()
    {
        $attendance = Attendance::where('user_id', auth()->id())
                                ->whereDate('created_at', Carbon::today())
                                ->first();

        $work_hours = $attendance ? $attendance->calculateWorkHours() : 0;
        $total_break_time = $attendance ? $attendance->getTotalBreakTime() : 0;

        return view('attendance.show', compact('attendance', 'work_hours', 'total_break_time'));
    }
}
