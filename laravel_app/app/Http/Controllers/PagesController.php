<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class PagesController extends Controller
{
    public function index() {
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('home', compact('articles'));
    }
}
