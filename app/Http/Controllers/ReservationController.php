<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function showSeats($movie_id, $schedule_id, Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['error' => 'Date is required'], 400);
        }
        $movie = Movie::findOrFail($movie_id);
        $schedule = Schedule::findOrFail($schedule_id);

        $sheets = Sheet::all();
        $reservedSheets = Reservation::where('schedule_id', $schedule_id)
            ->where('date', $date)
            ->pluck('sheet_id')
            ->toArray();
    
        return view('reservations.seats', compact('movie', 'schedule', 'date', 'sheets', 'reservedSheets'));
    }
    
    public function create($movie_id, $schedule_id, Request $request)
    {
        $date = $request->query('date');
        $sheetId = $request->query('sheetId');
        if (!$date || !$sheetId) {
            return response()->json(['error' => 'Date and sheetId are required'], 400);
        }

        // 既存の予約をチェック
        $existingReservation = Reservation::where('schedule_id', $schedule_id)
            ->where('sheet_id', $sheetId)
            ->where('date', $date)
            ->first();

        if ($existingReservation) {
            return response()->json(['error' => 'This seat is already reserved for the selected date and time'], 400);
        }

        $movie = Movie::findOrFail($movie_id);
        $schedule = Schedule::findOrFail($schedule_id);
        
        return view('reservations.create', compact('movie', 'schedule', 'date', 'sheetId'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'sheet_id' => 'required|exists:sheets,id',
            'date' => 'required|date',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);
    
        $existingReservation = Reservation::where('schedule_id', $validated['schedule_id'])
            ->where('sheet_id', $validated['sheet_id'])
            ->where('date', $validated['date'])
            ->first();
    
        if ($existingReservation) {
            return back()->with('error', 'この座席は既に予約されています。');
        }
    
        $validated['is_canceled'] = false;
    
        try {
            Reservation::create($validated);
        } catch (\Exception $e) {
            return back()->with('error', '予約の作成中にエラーが発生しました。もう一度お試しください。');
        }
    
        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $movie_id = $schedule->movie_id;
    
        $dateOnly = Carbon::parse($validated['date'])->startOfDay();
    
        return redirect()->route('movies.schedules.sheets', [
            'movie_id' => $movie_id,
            'schedule_id' => $validated['schedule_id'],
            'date' => $dateOnly
        ])->with('success', '予約できました');
    }
}