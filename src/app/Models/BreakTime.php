<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'break_start',
        'break_end',
    ];

    
    public function getBreakDurationAttribute()
    {
        if (!$this->break_start || !$this->break_end) return 0;

        $break_start = Carbon::parse($this->break_start);
        $break_end = Carbon::parse($this->break_end);
        return round($break_start->diffInMinutes($break_end), 2);
    }

    
    public static function createWithAttendance($attendance, $breakStart)
    {
        return self::create([
            'attendance_id' => $attendance->id,  
            'break_start' => $breakStart,
            'break_end' => null,  
        ]);
    }
}
