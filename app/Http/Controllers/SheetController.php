<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index()
    {
        $sheets = Sheet::orderBy('row')->orderBy('column')->get();
        return view('sheets.index', compact('sheets'));
    }
}