<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['schedule.movie', 'sheet'])
            ->whereHas('schedule', function ($query) {
                $query->where('end_time', '>', Carbon::now());
            })
            ->orderBy('date')
            ->get();
    
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        $movies = Movie::all();
        $schedules = Schedule::where('start_time', '>', Carbon::now())->get();
        $sheets = Sheet::all();
    
        return view('admin.reservations.show', compact('reservation', 'movies', 'schedules', 'sheets'));
    }
    

    public function create()
    {
        $movies = Movie::all();
        $schedules = Schedule::where('start_time', '>', Carbon::now())->get();
        $sheets = Sheet::all();

        return view('admin.reservations.create', compact('movies', 'schedules', 'sheets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'schedule_id' => 'required|exists:schedules,id',
            'sheet_id' => 'required|exists:sheets,id',
            'date' => 'required|date',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

    // 既存の予約チェックs  
        $existingReservation = Reservation::where('schedule_id', $validated['schedule_id'])
            ->where('sheet_id', $validated['sheet_id'])
            ->where('date', $validated['date'])
            ->first();

        if ($existingReservation) {
            // return redirect()->route('admin.reservations.index')->with('error', 'その座席はすでに予約済みです');
            return redirect()->back()->with('error', 'その座席はすでに予約済みです');
        }

        Reservation::create($validated);

        return redirect()->route('admin.reservations.index')->with('success', '予約が追加されました');
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
    
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);
    
        // 変更されていない情報を $validated に追加
        $validated['schedule_id'] = $reservation->schedule_id;
        $validated['sheet_id'] = $reservation->sheet_id;
        $validated['date'] = $reservation->date;
    
        $existingReservation = Reservation::where('schedule_id', $validated['schedule_id'])
            ->where('sheet_id', $validated['sheet_id'])
            ->where('date', $validated['date'])
            ->where('id', '!=', $id)
            ->first();
    
        if ($existingReservation) {
            return redirect()->route('admin.reservations.show', $id)->with('error', 'その座席はすでに予約済みです');
        }
    
        $reservation->update($validated);
    
        return redirect()->route('admin.reservations.index')->with('success', '予約のメールアドレスと名前が更新されました');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', '予約が削除されました');
    }
}