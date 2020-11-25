<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Image;
use App\Http\Requests\ArticleFormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * ログインしているユーザーしか新記事作成出来ません。
     * 記事のオーナーしか編集、削除出来ません。
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->middleware('owner')->only('edit', 'update', 'destroy');
    }

    /**
     * 記事一覧を取得する
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('home', compact('articles'));
    }

    /**
     * 新記事作成のフォームを作成する
     */
    public function create()
    {
        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * 新記事を保存する
     */
    public function store(ArticleFormRequest $request)
    {
        DB::beginTransaction();
        try {
            // サムネイル画像の選択をチェックする /
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $id => $image) {
                    if ($request->thumbnail == $id) {
                        $thumbnail = time().$image->getClientOriginalName();
                    }
                }
            }

            $article = new Article([
                'slug' => uniqid(),
                'title' => $request->title,
                'content' => $request->content,
                'thumbnail' => isset($thumbnail)?$thumbnail:null,
                'user_id' => Auth::user()->id
            ]);
            $article->save();
            // ピボットテーブルに挿入する
            $article->tags()->sync($request->tags);
            
            // 画像をアップロードし、保存する
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $fileName = time().$file->getClientOriginalName();
                    $file->move(public_path().'/images/', $fileName);                  
                    $data[] = ['path' => $fileName, 'article_id' => $article->id, 'created_at' => Carbon::now()];
                }   
                Image::insert($data);
            }
            DB::commit();

            return redirect(route('articles.show', ['slug' => $article->slug]))->with('status', '記事作成しました！');
        }
        catch(Exception $e) {
            DB::rollBack();
            return back()->with('message', '記事作成失敗しました。もう一度試してください！');
        }
    }

    /**
     * 記事閲覧する
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
     * 記事編集のフォームを作成する
     */
    public function edit($slug)
    {
        $article = Article::whereSlug($slug)->firstOrFail();
        $tags = Tag::all();
        $selected_tags = $article->tags->pluck('id')->toArray();

        return view('articles.edit', compact('article', 'tags', 'selected_tags'));
    }

    /**
     * 記事を編集する
     */
    public function update(ArticleFormRequest $request, $slug)
    {
        DB::beginTransaction();
        try {
            $article = Article::whereSlug($slug)->firstOrFail();
            $article->title = $request->title;
            $article->content = $request->content;
            $article->thumbnail = $request->thumbnail_image;
            $article->save();
            $article->tags()->sync($request->tags);

            // 新し画像がアップロードされたら、保存する
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $fileName = time().$file->getClientOriginalName();
                    $file->move(public_path().'/images/', $fileName);                  
                    $data[] = ['path' => $fileName, 'article_id' => $article->id, 'created_at' => Carbon::now()];
                }   
                Image::insert($data);
            }
            DB::commit();

            return back()->with('status', '記事編集しました！');
        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', '記事編集失敗しました。もう一度試してください！');
        }
    }

    /**
     * 記事を削除する
     */
    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $article = Article::whereSlug($slug)->firstOrFail();
            // ピボットテーブルから削除する
            $article->tags()->detach();
            // 記事の画像を削除する
            $article->images()->delete();
            $article->delete();     
            DB::commit();

            return back()->with('status', '記事削除されました！');
        }
        catch(Exception $e) {
            DB::rollBack();
            return back()->with('message', '記事削除が失敗しました。もう一度試してください！');
        }
        
    }

    /**
     * ログインしているユーザーの記事を取得する
     */
    public function myarticles() {
        $articles = Auth::user()->articles()->orderBy('created_at', 'desc')->get();

        return view('articles.myarticles', compact('articles'));
    }
}
