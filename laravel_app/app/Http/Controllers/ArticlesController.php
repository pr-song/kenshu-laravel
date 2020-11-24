<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Image;
use App\Http\Requests\ArticleFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class ArticlesController extends Controller
{
    /**
     * ログインしているユーザーだけ新記事作成出来る。
     */
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('home', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleFormRequest $request)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $id => $image) {
                if ($request->get('thumbnail') == $id) {
                    $thumbnail = time().$image->getClientOriginalName();
                }
            }
        }

        $user_id = Auth::user()->id;
        $article = new Article([
            'slug' => uniqid(),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'thumbnail' => isset($thumbnail)?$thumbnail:null,
            'user_id' => $user_id
        ]);

        $article->save();
        $article->tags()->sync($request->get('tags'));
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileName = time().$file->getClientOriginalName();
                $file->move(public_path().'/images/', $fileName);                  
                $data[] = ['path' => $fileName, 'article_id' => $article->id, 'created_at' => Carbon::now()];
            }
            
            Image::insert($data);
        }

        return redirect(route('articles.create'))->with('status', '記事作成しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $article = Article::whereSlug($slug)->firstOrFail();

            return view('articles.show', compact('article'));
        }
        catch(Exception $e) {
            return redirect(route('home'))->with('message', '記事見つかれません！');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
