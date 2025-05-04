<?php

namespace App\Http\Controllers;

use console;
use Session;
use App\Models\User;
use App\Models\Company;
use App\Models\MediaTemp;
use App\Models\CompanyLog;
use App\Models\CompanyUser;
use App\Models\SettingState;
use Illuminate\Http\Request;
use App\Models\CompanyBranch;
use App\Models\SettingSocial;
use App\Models\SettingCountry;
use App\Models\SettingDialcode;
use App\Models\CompanyBranchSocial;
use App\Models\Department;
use App\Models\DepartmentEquipment;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Validator;

class CompanyBranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function listing(Request $request, $id)
    {
        $department = Department::where('department_id', $id)->first();
        $search = array();
        return view('company_branch.listing', [
            'id' => $id,
            'department' => $department,
            'records' => DepartmentEquipment::get_record($search, 15, $id),
        ]);
    }

    public function add(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $department = Department::where('department_id', $id)->first();
        $submit = route('company_branch_add', $id);

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'department_equipment_name' => 'required',
            ])->setAttributeNames([
                'department_equipment_name' => 'Department Equipment Name',
            ]);

            if (!$validator->fails()) {
                $department_equipment = DepartmentEquipment::create([
                    'department_equipment_name' => $request->input('department_equipment_name'),
                    'department_id' => $id
                ]);
                Session::flash('success_msg', 'Successfully added ' . $department_equipment->department_equipment_name);

                return redirect()->route('company_branch_listing', $id);
            }
            $post = (object) $request->all();
        }
        return view('company_branch/form', [
            'title' => 'Add',
            'submit' => $submit,
            'department' => $department,
            'post' => $post,
        ])->withErrors($validator);
    }
    public function edit(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $department_equipment = DepartmentEquipment::where('department_equipment_id', $id)->first();
        $submit = route('department_equipment_edit', $id);
        if (!$department_equipment) {
            Session::flash('fail_msg', 'Invalid Company Branch, Please try again later..');
            return redirect()->route('company_branch_listing', $id);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'department_equipment_name' => 'required',
            ])->setAttributeNames([
                'department_equipment_name' => 'Department Equipment Name',
            ]);

            if (!$validator->fails()) {
                $department_equipment->update([
                    'department_equipment_name' => $request->input('department_equipment_name'),
                ]);

                Session::flash('success_msg', 'Successfully edit ' . $department_equipment->department_equipment_name);

                return redirect()->route('company_branch_listing', $department_equipment->department_id);
            }
            $post = (object) $request->all();
        }
        return view('company_branch/edit_form', [
            'title' => 'Edit',
            'submit' => $submit,
            'is_edit' => true,
            'post' => $post,
            'department_equipment' => $department_equipment,
        ])->withErrors($validator);
    }

    public function department_equipment_delete(Request $request)
    {
        $user = Auth::user();
        $department_equipment = DepartmentEquipment::find($request->input('department_equipment_id'));
        $department_id = $department_equipment->department_id;
        if (!$department_equipment) {
            Session::flash('fail_msg', 'Error, Please try again later..');
            return redirect('/');
        }

        $department_equipment->delete();

        Session::flash('success_msg', "Successfully delete " . $department_equipment->department_equipment_name);
        return redirect()->route('company_branch_listing', $department_id);
    }
}
