<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * ホームページ
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->paginate(9);

        return view('home', compact('articles'));
    }
}
