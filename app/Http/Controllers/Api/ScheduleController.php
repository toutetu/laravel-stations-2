<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getSchedulesByMovie($movieId)
    {
        $schedules = Schedule::where('movie_id', $movieId)
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->get(['id', 'start_time']);

        return response()->json($schedules);
    }
}