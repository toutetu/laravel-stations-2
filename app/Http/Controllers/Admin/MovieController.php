<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
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
            $movies = collect()->paginate(20); // 空のコレクションをページネーション
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
    
    public function store(CreateMovieRequest $request)
    {
        
        $movie = Movie::create($request->validated());
        return redirect()->route('admin.movies.index')->with('success', '映画が正常に登録されました。');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }


    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        \Log::info('Update method called', ['request' => $request->all(), 'movie' => $movie]);

        $movie->update($request->validated());
        return redirect()->route('admin.movies.index')->with('success', '映画情報が更新されました。');
    }


    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', '映画情報が削除されました。');
    }
}