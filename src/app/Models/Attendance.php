<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Attendance extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
    ];

    
    protected $dates = ['start_time', 'end_time', 'break_start', 'break_end'];

    
    public function getWorkHoursAttribute()
    {
        if (!$this->start_time || !$this->end_time) return 0;

        $start_time = Carbon::parse($this->start_time);
        $end_time = Carbon::parse($this->end_time);
        $total_break_time = 0;

        if ($this->break_start && $this->break_end) {
            $break_start = Carbon::parse($this->break_start);
            $break_end = Carbon::parse($this->break_end);
            $total_break_time = $break_end->diffInSeconds($break_start);
        }

        $work_seconds = $end_time->diffInSeconds($start_time) - $total_break_time;
        return round($work_seconds / 3600, 2);
    }

    public function getTotalBreakTimeAttribute()
    {
        if (!$this->break_start || !$this->break_end) return 0;

        $break_start = Carbon::parse($this->break_start);
        $break_end = Carbon::parse($this->break_end);
        return round($break_start->diffInMinutes($break_end), 2);
    }


}