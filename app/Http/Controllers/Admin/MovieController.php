<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\CreateMovieRequest;

class MovieController extends Controller
{
    // public function index()
    // {
    //     try {
    //         DB::connection()->getPdo();
    //         echo "Connected successfully to: " . DB::connection()->getDatabaseName();
    //     } catch (\Exception $e) {
    //         die("Could not connect to the database. Error: " . $e->getMessage());
    //     }

    //     $movies = Movie::all();
       
    //     return view('admin.movies.index', compact('movies'));
    // }
    public function index()
    {
        try {
            DB::connection()->getPdo();
            $dbStatus = "Connected successfully to: " . DB::connection()->getDatabaseName();
           
            $movies = Movie::all();
            $dbStatus .= " | Movies count: " . $movies->count();
        } catch (\Exception $e) {
            $dbStatus = "Could not connect to the database. Error: " . $e->getMessage();
            $movies = collect(); // 空のコレクションを作成
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
// public function store(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'title' => 'required|unique:movies,title',
//         'image_url' => 'required|url',
//         'published_year' => 'required|integer|min:1800|max:' . (date('Y') + 1),
//         'description' => 'required',
//         'is_showing' => 'required|boolean',
//     ]);
    
//     $movie = Movie::create($request->validated());
//     if ($validator->fails()) {
//         return redirect()->route('admin.movies.create')
//             ->withErrors($validator)
//             ->withInput()
//             ->with('error', '入力内容に問題があります。再度確認してください。');
//     }

//         $movie = new Movie($request->except('is_showing'));
//         $movie->is_showing = $request->has('is_showing');
//         $movie->save();

//         return redirect()->route('admin.movies.index')->with('success', '映画が正常に登録されました。');
//     }

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

}