<?php

namespace App\Http\Controllers;

use App\Models\Categoryorder;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categoryorder::all();
        return view('layouts.headerPrimary', ['category' => $categories]);
    }
}
