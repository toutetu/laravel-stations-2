<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
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

        return view('movies.index', compact('movies'));
    }
}