<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DateController extends Controller
{
    public function show(Request $request, $date = null)
{
    $date = $date ?? Carbon::now()->toDateString(); 

    $attendances = Attendance::with('user') 
                                 ->whereDate('start_time', $date)
                                 ->paginate(5);
    
    
    

    
    return view('date', [
        'date' => $date,
        'attendances' => $attendances,
    ]);
}

    
    public function changeDate($direction, Request $request)
    {
        
        $currentDate = Carbon::parse($request->input('date', Carbon::now()->toDateString()));

        if ($direction == 'previous') {
            $date = $currentDate->subDay(); 
        } else {
            $date = $currentDate->addDay(); 
        }

        
        return redirect()->route('date.show', ['date' => $date->toDateString()]);
    }

    public function showAttendance()
{
    $attendance = Attendance::where('user_id', auth()->id())
                            ->whereDate('created_at', Carbon::today())
                            ->first();

    
    $totalWorkedTime = 0;
    if ($attendance && $attendance->start_time && $attendance->end_time) {
    
        $totalWorkedTime = $attendance->start_time->diffInMinutes($attendance->end_time);
    
    
        $totalBreakTime = 0;
         
            $breakTimes = BreakTime::where('attendance_id', $attendance->id)->get();
            foreach ($breakTimes as $breakTime) {
                $breakStart = Carbon::parse($breakTime->break_start);
                $breakEnd = Carbon::parse($breakTime->break_end);
                if ($breakStart && $breakEnd) {
                    $totalBreakTime += $breakStart->diffInMinutes($breakEnd);
                }
            }   
        }

    
        $totalWorkedTime -= $totalBreakTime;
      

    
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

    return view('date', compact('attendance', 'totalWorkedTime', 'totalBreakTime'));
    }

}



