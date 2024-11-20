<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Sheet;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function getSeatsByScheduleAndDate($scheduleId, $date)
    {
        $sheets = Sheet::all();
        $reservedSeats = Reservation::where('schedule_id', $scheduleId)
            ->where('date', $date)
            ->pluck('sheet_id')
            ->toArray();

        $seatData = $sheets->groupBy('row')->map(function ($row) use ($reservedSeats) {
            return $row->map(function ($seat) use ($reservedSeats) {
                return [
                    'id' => $seat->id,
                    'name' => $seat->row . $seat->column,
                    'reserved' => in_array($seat->id, $reservedSeats),
                ];
            });
        });

        return response()->json($seatData);
    }
}