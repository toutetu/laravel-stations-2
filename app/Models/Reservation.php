<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;


    protected $fillable = [
        'schedule_id',
        'sheet_id',
        'date',
        'email',
        'name',
        // 'is_canceled' を除外
    ];
    

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }
}