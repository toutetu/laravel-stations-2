<?php


namespace App\Http\Controllers\Admin; 

use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class ScheduleController extends Controller
{

    public function index()
    {
        $movies = Movie::where('is_showing', true)
                    ->with('schedules')
                    ->get();
        return view('admin.schedules.index', compact('movies'));
    }

    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function create($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        return view('admin.schedules.create', compact('movie'));
    }
    

    public function store(Request $request, $movieId)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        $startTime = $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time'];
        $endTime = $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time'];

        Schedule::create([
            'movie_id' => $movieId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが作成されました。');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->start_time = $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time'];
        $schedule->end_time = $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time'];
        $schedule->save();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが更新されました。');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが削除されました。');
    }
}