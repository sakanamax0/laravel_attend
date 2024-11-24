<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CarveController extends Controller
{
    
    public function startWork(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

       
        $existingAttendance = Attendance::where('user_id', $user->id)
                                    ->whereDate('start_time', Carbon::today())
                                    ->first();

        if ($existingAttendance) {
            return redirect()->route('carve')->with('error', '今日の勤務はすでに開始されています。');
        }

       
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'start_time' => Carbon::now(),
        ]);

        return redirect()->route('carve');
    }

   
    public function endWork(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $attendance = Attendance::where('user_id', $user->id)
                                ->whereNull('end_time')
                                ->whereDate('start_time', Carbon::today()) 
                                ->latest()
                                ->first();

        if ($attendance) {
            $attendance->end_time = Carbon::now();
            $attendance->save();
        }

        return redirect()->route('carve');
    }

    
    public function startBreak(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $attendance = Attendance::where('user_id', $user->id)
                                ->whereNull('break_start')
                                ->latest()
                                ->first();

        if ($attendance) {
            $attendance->break_start = Carbon::now();
            $attendance->save();

            
            BreakTime::create([
                'attendance_id' => $attendance->id,
                'break_start' => Carbon::now(),
            ]);
        }

        return redirect()->route('carve');
    }

    
    public function endBreak(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $attendance = Attendance::where('user_id', $user->id)
                                ->whereNotNull('break_start')
                                ->whereNull('break_end')
                                ->latest()
                                ->first();

        if ($attendance) {
            $attendance->break_end = Carbon::now();
            $attendance->save();

            
            $breakTime = BreakTime::where('attendance_id', $attendance->id)
                                  ->whereNull('break_end')
                                  ->latest()
                                  ->first();

            if ($breakTime) {
                $breakTime->break_end = Carbon::now();
                $breakTime->save();
            }
        }

        return redirect()->route('carve');
    }

    
    public function index()
    {
        $user = auth()->user();
        $userName = $user ? $user->name : 'ゲスト';

        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();

       
        $isWorking = $attendance && $attendance->start_time && !$attendance->end_time;

        
        $isOnBreak = $attendance && $attendance->break_start && !$attendance->break_end;

        
        $totalWorkedTime = 0;
        if ($attendance && $attendance->start_time && $attendance->end_time) {
            $totalWorkedTime = $attendance->start_time->diffInMinutes($attendance->end_time);
        }

        
        $totalBreakTime = 0;
        if ($attendance) {
            $breakTimes = BreakTime::where('attendance_id', $attendance->id)->get();
            foreach ($breakTimes as $breakTime) {
                
                $breakStart = Carbon::parse($breakTime->break_start);
                $breakEnd = Carbon::parse($breakTime->break_end);

                
                if ($breakStart && $breakEnd) {
                    $totalBreakTime += $breakStart->diffInMinutes($breakEnd);
                }
            }
        }

        return view('carve', compact('userName','attendance', 'isWorking', 'isOnBreak', 'totalWorkedTime', 'totalBreakTime'));
    }
}