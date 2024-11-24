<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreakTime;

class BreakController extends Controller
{
    /**
     * 
     */
    public function start(Attendance $attendance)
{
    
    if ($attendance->break_start) {
        return redirect()->route('attendance.index')->withErrors('Break has already started.');
    }

    
    $attendance->break_start = now();
    $attendance->save();

    
    return redirect()->route('attendance.show', $attendance);
}

    /**
     * 
     */
    public function end(Attendance $attendance)
{
    
    if (!$attendance->break_start || $attendance->break_end) {
        return redirect()->route('attendance.index')->withErrors('Break has not started or already ended.');
    }

    
    $attendance->break_end = now();
    $attendance->save();

    
    return redirect()->route('attendance.show', $attendance);
}
}
