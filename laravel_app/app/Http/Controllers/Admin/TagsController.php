<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagFormRequest;
use App\Models\Tag;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index():View
    {
        $tags = Tag::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.tags.index', compact('tags'));
    }

    public function create():View
    {
        return view('admin.tags.create');
    }

    public function store(TagFormRequest $request):RedirectResponse
    {
        DB::beginTransaction();
        try 
        {
            $tag = new Tag([
                'name' => $request->name
            ]);
            $tag->save();
            DB::commit();
    
            return redirect(route('admin.tags.index'))->with('status', 'タグ作成しました！');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->with('message', 'タグ作成失敗しました。もう一度試してください！');
        }
    }

    public function destroy(Tag $tag):RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $tag->articles()->detach();
            $tag->delete();
            DB::commit();

            return back()->with('status', 'タグ削除されました！');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return back()->with('message', 'タグ削除が失敗しました。もう一度試してください！');
        }
    }
}
