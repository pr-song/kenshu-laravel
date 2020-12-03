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
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     * @return Illuminate\View\View;
     */
    public function index():View
    {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->paginate(9);

        return view('home', compact('articles'));
    }

    /**
     * 新記事作成のフォームを作成する
     * @return Illuminate\View\View;
     */
    public function create():View
    {
        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * 新記事を保存する
     * @param App\Http\Requests\ArticleFormRequest $request
     * @return Illuminate\Http\RedirectResponse;
     */
    public function store(ArticleFormRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try {
            // サムネイル画像の選択をチェックする /
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($request->thumbnail_image == $image->getClientOriginalName()) {
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

            return redirect(route('articles.my_articles'))->with('status', '記事作成しました！');
        }
        catch(Exception $e) {
            DB::rollBack();
            return back()->with('message', '記事作成失敗しました。もう一度試してください！');
        }
    }

    /**
     * 記事閲覧する
     * このファンクションの返り型はViewもRedirectResponseも可能なので、固定返り型を指定することは出来ません。
     * @param string $slug
     */
    public function show(string $slug)
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
     * @param string $slug
     * @return Illuminate\View\View;
     */
    public function edit(string $slug):View
    {
        $article = Article::whereSlug($slug)->firstOrFail();
        $tags = Tag::all();
        $selected_tags = $article->tags->pluck('id')->toArray();

        return view('articles.edit', compact('article', 'tags', 'selected_tags'));
    }

    /**
     * 記事を編集する
     * @param App\Http\Requests\ArticleFormRequest $request
     * @param string $slug
     * @return Illuminate\Http\RedirectResponse;
     */
    public function update(ArticleFormRequest $request, string $slug):RedirectResponse
    {
        DB::beginTransaction();
        try {
            $article = Article::whereSlug($slug)->firstOrFail();
            // サムネイル画像の選択をチェックする /
            $thumbnail = $request->thumbnail_image;
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($request->thumbnail_image == $image->getClientOriginalName() && $request->thumbnail_image != $article->thumbnail) {
                        $thumbnail = time().$image->getClientOriginalName();
                    }
                }
            }
            $article->title = $request->title;
            $article->content = $request->content;
            $article->thumbnail = $thumbnail;
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
     * @param string $slug
     * @return Illuminate\Http\RedirectResponse;
     */
    public function destroy(string $slug):RedirectResponse
    {
        DB::beginTransaction();
        try {
            $article = Article::whereSlug($slug)->firstOrFail();
            // ピボットテーブルから削除する
            $article->tags()->detach();
            // 記事の画像を削除する
            foreach ($article->images as $image) {
                $image_path = public_path("/images/".$image->path);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $article->images()->delete();
            $article->delete();
            DB::commit();

            return back()->with('status', '記事削除されました！');
        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', '記事削除が失敗しました。もう一度試してください！');
        }
    }

    /**
     * ログインしているユーザーの記事を取得する
     * @return Illuminate\View\View
     */
    public function myArticles():View
    {
        $articles = Auth::user()->articles()->orderBy('created_at', 'desc')->paginate(10);

        return view('articles.my_articles', compact('articles'));
    }
}
