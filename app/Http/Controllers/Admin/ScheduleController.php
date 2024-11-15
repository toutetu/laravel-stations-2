<?php


namespace App\Http\Controllers\Admin; 

use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        $validatedData = $this->validateAndProcessScheduleData($request, $movieId);
    
        if ($validatedData instanceof \Illuminate\Http\RedirectResponse) {
            return $validatedData;
        }
    
        Schedule::create($validatedData);
    
        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが作成されました。');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateAndProcessScheduleData($request, null, $id);
    
        if ($validatedData instanceof \Illuminate\Http\RedirectResponse) {
            return $validatedData;
        }
    
        $schedule = Schedule::findOrFail($id);
        $schedule->update($validatedData);
    
        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが更新されました。');
    }

    private function validateAndProcessScheduleData(Request $request, $movieId = null, $scheduleId = null)
    {
        $rules = [
            'movie_id' => 'required|exists:movies,id',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $validatedData = $validator->validated();
    
        try {
            $startTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
            $endTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);
    
            $errors = [];
    
            if ($startTime->greaterThanOrEqualTo($endTime)) {
                $errors['start_time_date'] = '開始日時は終了日時より前である必要があります。';
                $errors['end_time_date'] = '終了日時は開始日時より後である必要があります。';
            }
    
            if ($startTime->diffInMinutes($endTime) <= 5) {
                $errors['start_time_time'] = '上映時間は5分より長い必要があります。';
                $errors['end_time_time'] = '上映時間は5分より長い必要があります。';
            }
    
            if (!empty($errors)) {
                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            }
    
            return [
                'movie_id' => $movieId ?? $validatedData['movie_id'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['date' => '日付と時刻の形式が正しくありません。'])
                ->withInput();
        }
    }
        
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('admin.schedules.edit', compact('schedule'));
    }


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'スケジュールが削除されました。');
    }
}