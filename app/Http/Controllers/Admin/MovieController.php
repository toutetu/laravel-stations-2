<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\CreateMovieRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::connection()->getPdo();
            $dbStatus = "Connected successfully to: " . DB::connection()->getDatabaseName();
            
            $query = Movie::query();
    
            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function($q) use ($keyword) {
                    $q->where('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%");
                });
            }
    
            if ($request->has('is_showing')) {
                $query->where('is_showing', $request->input('is_showing'));
            }
    
            $movies = $query->paginate(20);

            $dbStatus .= " | Movies count: " . $movies->total();
        } catch (\Exception $e) {
            $dbStatus = "Could not connect to the database. Error: " . $e->getMessage();
            $movies = new LengthAwarePaginator([], 0, 20); // 空のページネーションを作成
        }
        return view('admin.movies.index', compact('movies', 'dbStatus'));
    }


    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }
    
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function store(CreateMovieRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $genre = Genre::firstOrCreate(['name' => $request->genre]);
                
                $movie = new Movie($request->except('genre'));
                $movie->genre()->associate($genre);
                $movie->save();
            });

            return redirect()->route('admin.movies.index')->with('success', '映画が正常に登録されました。');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', '映画の登録に失敗しました: ' . $e->getMessage())->withInput();
            return response()->json(['error' => '映画の登録に失敗しました: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        \Log::info('Update method called', ['request' => $request->all(), 'movie' => $movie]);

        try {
            DB::transaction(function () use ($request, $movie) {
                $genre = Genre::firstOrCreate(['name' => $request->genre]);
                
                $movie->fill($request->except('genre'));
                $movie->genre()->associate($genre);
                $movie->save();
            });

            return redirect()->route('admin.movies.index')->with('success', '映画情報が更新されました。');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', '映画情報の更新に失敗しました: ' . $e->getMessage())->withInput();
            return response()->json(['error' => '映画情報の更新に失敗しました: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', '映画情報が削除されました。');
    }

    
}