<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\View\View;

class ArticlesController extends Controller
{
    public function index():View
    {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.articles.index', compact('articles'));
    }
}
