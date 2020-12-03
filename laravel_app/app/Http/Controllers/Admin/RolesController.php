<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RolesController extends Controller
{
    public function create():View
    {
        return view('admin.roles.create');
    }

    public function store(RoleFormRequest $request):RedirectResponse
    {
        Role::create(['name' => $request->get('name')]);

        return redirect(route('admin.roles.index'))->with('status', '新しい役割作成しました！');
    }

    public function index():View
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }
}
