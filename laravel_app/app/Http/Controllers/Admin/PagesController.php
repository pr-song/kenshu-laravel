<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function dashboard():View
    {
        $number_of_users = User::count();
        $number_of_articles = Article::count();
        $number_of_tags = Tag::count();
        return view('admin.dashboard', compact('number_of_users', 'number_of_articles', 'number_of_tags'));
    }
}
