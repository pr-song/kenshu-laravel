<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class PagesController extends Controller
{
    /**
     * ホームページ
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->paginate(9);

        return view('home', compact('articles'));
    }
}
