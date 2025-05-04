<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Session;

class AdminRoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listing()
    {
        $roles = Role::query()->where('user_type_group','=','administrator')->get();
        $user_role_count = array();
        foreach ($roles as $role) {
            $user_role_count[$role->id] = User::role($role->name)->count();
        }
        return view('user_role/listing', [
            'roles' => $roles,
            'user_role_count' => $user_role_count,
            'type' => 'Admin',
        ]);
    }

    public function add(Request $request)
    {
        $validator = null;
        $post = null;
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tbl_user_role,name',
                'permissions' => 'required',
            ])->setAttributeNames([
                'name' => 'Role Name',
                'permissions' => 'Permission',
            ]);
            if (!$validator->fails()) {
                $role = Role::create([
                    'name' =>  $request->input('name'),
                    'user_type_group' => 'administrator'
                ]);
                $permissions = $request->input('permissions');
                $role->givePermissionTo($permissions);
                Session::flash('success_msg', 'Successfully updated ' . $request->input('name') . ' role.');
                return redirect()->route('admin_role_listing');
            }
            $post = (object) $request->all();
        }
        return view('user_role/form', [
            'submit' => route('admin_role_add'),
            'cancel' => route('admin_role_listing'),
            'title' => 'Add',
            'type' => 'Admin',
            'post' => $post,
            'permissions' => Permission::orderBy('group_name', 'asc')->get(),
        ])->withErrors($validator);
    }

    public function edit(Request $request, $role_id)
    {
        $validator = null;
        $post = $role =  Role::find($role_id);
        if (!$role) {
            Session::flash('fail_msg', 'Invalid Roles, Please try again later.');
            return redirect('/admin_role/listing');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => "required|unique:tbl_user_role,name,{$role_id}",
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
                return redirect()->route('admin_role_listing');
            }
            $post = (object) $request->all();

        }

        // dd($role->permissions()->pluck('name')->toArray());
        // dd(in_array($post->permissions);

        return view('user_role/form', [
            'submit' => route('admin_role_edit', $role_id),
            'cancel' => route('admin_role_listing'),
            'title' => 'Edit',
            'type' => 'Admin',
            'post' => $post,
            'permissions' => Permission::query()->orderBy('group_name')->orderBy('display_name')->get(),
            'role_permissions' => $role->permissions()->pluck('name')->toArray(),
        ])->withErrors($validator);
    }
}
