<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserType;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Session;

class UserRoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listing()
    {
        $roles = Role::query()->where('user_type_group','user')->get();
        $user_role_count = array();
        foreach ($roles as $role) {
            $user_role_count[$role->id] = User::role($role->name)->count();
        }
        return view('user_role/listing', [
            'roles' => $roles,
            'user_role_count' => $user_role_count,
            'type' => 'User',
        ]);
    }

    public function add(Request $request)
    {
        $validator = null;
        $post = null;

        $user_type_sel = UserType::get_user_type_sel();
        unset($user_type_sel[1],$user_type_sel[4]);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:125|unique:tbl_user_role,name',
                'permissions' => 'required',
            ])->setAttributeNames([
                'name' => 'Role Name',
                'permissions' => 'Permission',
            ]);
            if (!$validator->fails()) {
                $role = Role::create([
                    'name' =>  $request->input('name'),
                    'user_type_group' => 'user'
                ]);
                $permissions = $request->input('permissions');
                $role->givePermissionTo($permissions);
                Session::flash('success_msg', 'Successfully updated ' . $request->input('name') . ' role.');
                return redirect()->route('user_role_listing');
            }
            $post = (object) $request->all();
        }
        return view('user_role/form', [
            'submit' => route('user_role_add'),
            'cancel' => route('user_role_listing'),
            'title' => 'Add',
            'type' => 'User',
            'post' => $post,
            'permissions' => Permission::orderBy('group_name', 'asc')->get(),
            'user_type_sel' => $user_type_sel,
        ])->withErrors($validator);
    }

    public function edit(Request $request, $role_id)
    {
        $validator = null;
        $post = $role =  Role::find($role_id);
        $user_type_sel = UserType::get_user_type_sel();
        unset($user_type_sel[1],$user_type_sel[4]);

        if (!$role) {
            Session::flash('fail_msg', 'Invalid Roles, Please try again later.');
            return redirect('/user_role/listing');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => "required|max:125|unique:tbl_user_role,name,{$role_id}",
                'permissions' => 'required'
            ])->setAttributeNames([
                'name' => 'Role Name',
                'permissions' => 'Permission',
            ]);
            if (!$validator->fails()) {
                $role->update([
                    'name' => $request->input('name')
                ]);
                $permissions = $request->input('permissions');
                $role->syncPermissions($permissions);
                Session::flash('success_msg', 'Successfully updated ' . $request->input('name') . ' role.');
                return redirect()->route('user_role_listing');
            }
            $post = (object) $request->all();

        }

        return view('user_role/form', [
            'submit' => route('user_role_edit', $role_id),
            'cancel' => route('user_role_listing'),
            'title' => 'Edit',
            'type' => 'User',
            'post' => $post,
            'user_type_sel' => $user_type_sel,
            'permissions' => Permission::query()->orderBy('group_name')->orderBy('display_name')->get(),
            'role_permissions' => $role->permissions()->pluck('name')->toArray(),
        ])->withErrors($validator);
    }
}
