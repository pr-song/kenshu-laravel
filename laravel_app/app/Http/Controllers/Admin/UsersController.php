<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AssignRoleFormRequest;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('not.admin.authenticated')->only('destroy');
    }
    public function index():View
    {
        $users = User::with('roles')->get();

        return view('admin.users.index', compact('users'));
    }

    public function assignRole($id):View
    {
        $user = User::whereId($id)->firstOrFail();
        $roles = Role::all();
        $selected_roles = $user->roles()->pluck('name')->toArray();

        return view('admin.users.assign_role', compact('user', 'roles', 'selected_roles'));
    }

    public function updateRole(AssignRoleFormRequest $request, $id):RedirectResponse
    {
        $user = User::whereId($id)->firstOrFail();
        $user->syncRoles($request->get('roles'));

        return redirect(route('admin.users.assign_role', $user->id))->with('status', 'ユーザー'.$user->name.'の役割を変更しました！');
    }

    public function destroy(User $user):RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $user->articles()->delete();
            $user->delete();
            DB::commit();

            return back()->with('status', 'ユーザー削除されました！');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return back()->with('message', 'ユーザー削除失敗しました。もう一度試してください！');
        }
    }
}
