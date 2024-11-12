<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|url',
            'published_year' => 'required|integer|min:1800|max:' . (date('Y') + 1),
            'description' => 'required',
            'is_showing' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.movies.create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', '入力内容に問題があります。再度確認してください。');
        }

        Log::info('Request data:', $request->all());
        if ($validator->fails()) {
            Log::info('Validation errors:', $validator->errors()->toArray());
        }

        $movie = new Movie($request->except('is_showing'));
        $movie->is_showing = $request->has('is_showing');
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', '映画が正常に登録されました。');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('movies')->ignore($movie->id)],
            'image_url' => ['required', 'url'],
            'release_year' => ['required', 'integer', 'min:1800', 'max:' . (date('Y') + 1)],
            'description' => ['required', 'string'],
            'is_showing' => ['required', 'boolean'],
        ]);

        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', '映画情報が更新されました。');
    }





}