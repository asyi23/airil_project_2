<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Form;
use App\Models\FormDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DepartmentEquipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function listing(Request $request, $id)
    {
        $search = array();
        $department_equipment = DepartmentEquipment::where('department_equipment_id', $id)->first();
        if ($request->isMethod('post')) {
            $submit = $request->input('submit');

            switch ($submit) {
                case 'search':
                    session(['form_search' => [
                        'keywords' => $request->input('keywords'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('form_search');
                    break;
            }
        }
        $search = session('form_search') ? session('form_search') : $search;
        return view('form.listing', [
            'submit' => route('form_listing', $id),
            'submit_new' => route('form_add', $id),
            'title' => 'Add',
            'records' => Form::get_record($search, 15, $id),
            'department_equipment' => $department_equipment,
            'search' =>  $search,
            'id' => $id,

        ]);
    }

    public function form_detail_listing(Request $request, $id = 0)
    {
        $search = array();
        $record = FormDetail::get_record($search, 15, $id);
        $form = Form::where('form_id', $id)->first();
        if ($request->isMethod('post')) {
            $submit = $request->input('submit');

            switch ($submit) {
                case 'search':
                    session(['form_detail_search' => [
                        "start_date" =>  $request->input('start_date'),
                        'end_date' => $request->input('end_date'),
                        'keywords' => $request->input('keywords'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('form_detail_search');
                    break;
            }
        }
        $search = session('form_detail_search') ? session('form_detail_search') : $search;
        // dd(FormDetail::get_record($search, 15, $id));
        return view('form.detail_listing', [
            'submit' => route('form_detail_listing', $id),
            'title' => 'Add',
            'records' => FormDetail::get_record($search, 15, $id),
            'total_record' => FormDetail::get_record_quantity($search, 15, $id),
            'form' => $form,
            'search' =>  $search,
            'id' => $id,

        ]);
    }

    public function form_detail_add(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $form = Form::where('form_id', $id)->first();
        $department_equipment = DepartmentEquipment::where('department_equipment_id', $form->department_equipment_id)->first();
        $submit = route('form_detail_add', $id);

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                "form_detail_date" => "required",
                "form_detail_order_no" => "required",
                "form_detail_quantity" => "required",
                "form_detail_remark" => "nullable",
                "form_detail_end_date" => "required",
                "form_detail_oum" => "required",
            ])->setAttributeNames([
                "form_detail_date" => "Date",
                "form_detail_order_no" => "Order No",
                "form_detail_quantity" => "Quantity",
                "form_detail_remark" => "Remark",
                "form_detail_oum" => "OUM",
                "form_id" => "Form ID",
            ]);


            if (!$validator->fails()) {
                $form = FormDetail::create([
                    "form_detail_date" => $request->input('form_detail_date'),
                    "form_detail_order_no" =>  $request->input('form_detail_order_no'),
                    "form_detail_quantity" =>  $request->input('form_detail_quantity'),
                    "form_detail_done_by" =>  $request->input('form_detail_done_by'),
                    "form_detail_remark" =>  $request->input('form_detail_remark'),
                    "form_detail_oum" => $request->input('form_detail_oum'),
                    "form_detail_end_date" => $request->input('form_detail_end_date'),
                    "form_id" =>  $id,
                ]);
                Session::flash('success_msg', 'Successfully added ' . $form->form_name);

                return redirect()->route('form_detail_listing', $id);
            }
            $post = (object) $request->all();
        }
        return view('form/add_detail', [
            'title' => 'Add',
            'submit' => $submit,
            'form' => $form,
            'post' => $post,
            'id' => $id,
            'department_equipment' => $department_equipment,
        ])->withErrors($validator);
    }

    public function form_detail_edit(Request $request, $id = 0)
    {
        $validator = null;
        $post = null;

        $form_detail = FormDetail::where('form_detail_id', $id)->first();
        $form = Form::where('form_id', $form_detail->form_id)->first();
        $department_equipment = DepartmentEquipment::where('department_equipment_id', $form->department_equipment_id)->first();
        $submit = route('form_detail_edit', $id);

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                "form_detail_date" => "required",
                "form_detail_order_no" => "required",
                "form_detail_quantity" => "required",
                "form_detail_remark" => "nullable",
                "form_detail_oum" => "required",
                "form_detail_end_date" => "required",
            ])->setAttributeNames([
                "form_detail_date" => "Date",
                "form_detail_order_no" => "Order No",
                "form_detail_quantity" => "Quantity",
                "form_detail_remark" => "Remark",
                "form_detail_oum" => "OUM",
                "form_id" => "Form ID",
            ]);


            if (!$validator->fails()) {
                $form_detail->update([
                    "form_detail_date" => $request->input('form_detail_date'),
                    "form_detail_order_no" =>  $request->input('form_detail_order_no'),
                    "form_detail_end_date" =>  $request->input('form_detail_end_date'),
                    "form_detail_quantity" =>  $request->input('form_detail_quantity'),
                    "form_detail_done_by" =>  $request->input('form_detail_done_by'),
                    "form_detail_remark" =>  $request->input('form_detail_remark'),
                    "form_detail_oum" => $request->input('form_detail_oum'),
                    "form_id" =>  $form->form_id,
                ]);
                Session::flash('success_msg', 'Successfully edit ' . $form_detail->form_detail_order_no);

                return redirect()->route('form_detail_listing', $form->form_id);
            }
            $post = (object) $request->all();
        }
        return view('form/edit_detail', [
            'title' => 'Edit',
            'submit' => $submit,
            'form_detail' => $form_detail,
            'form' => $form,
            'post' => $post,
            'id' => $id,
            'department_equipment' => $department_equipment,
        ])->withErrors($validator);
    }

    public function add(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $department_equipment = DepartmentEquipment::where('department_equipment_id', $id)->first();
        $submit = route('form_add', $id);

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'form_name' => 'required',
                'department_equipment_id' => 'required',
            ])->setAttributeNames([
                'form_name' => 'Form Name',
                'department_equipment_id' => 'Department Equipment ID',
            ]);


            if (!$validator->fails()) {
                $form = Form::create([
                    'form_name' => $request->input('form_name'),
                    'department_equipment_id' => $id
                ]);
                Session::flash('success_msg', 'Successfully added ' . $form->form_name);

                return redirect()->route('form_listing', $id);
            }
            $post = (object) $request->all();
        }
        return view('form/add', [
            'title' => 'Add',
            'submit' => $submit,
            'department_equipment' => $department_equipment,
            'post' => $post,
            'id' => $id,
        ])->withErrors($validator);
    }

    public function edit(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $form = Form::where('form_id', $id)->first();
        $submit = route('form_add', $id);
        if (!$department_equipment) {
            Session::flash('fail_msg', 'Invalid Company Branch, Please try again later..');
            return redirect()->route('company_branch_listing', $id);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'form_name' => 'required',
            ])->setAttributeNames([
                'form_name' => 'Form Name',
            ]);

            if (!$validator->fails()) {
                $form->update([
                    'form_name' => $request->input('form_name'),
                ]);
                Session::flash('success_msg', 'Successfully edit ' . $form->form_name);

                return redirect()->route('form_listing', $form->department_equipment_id);
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

    public function delete(Request $request)
    {
        $user = Auth::user();
        $form = Form::find($request->input('form_id'));
        if (!$form) {
            Session::flash('fail_msg', 'Error, Please try again later..');
            return redirect('/');
        }

        $form->delete();

        Session::flash('success_msg', "Successfully delete " . $form->form_name);
        return redirect()->route('form_listing', $form->department_equipment_id);
    }

    public function delete_form_details(Request $request)
    {
        $owner = Auth::user();
        $form_detail = FormDetail::find($request->input('form_detail_id'));
        $form_id = $form_detail->form_id;
        if (!$form_detail) {
            Session::flash('fail_msg', 'Error, Please try again later..');
            return redirect('/');
        }

        $form_detail->delete();
        Session::flash('success_msg', "Successfully delete order no ." . $form_detail->form_detail_order_no);
        return redirect()->route('form_detail_listing', $form_id);
    }
    public function download_form_details(Request $request, $id, $start_date = null, $end_date = null)
    {
        $form_detail = FormDetail::where('form_id', $id)
            ->when(!empty($start_date) && !empty($end_date), function ($query) use ($end_date, $start_date) {
                $query->where(function ($q) use ($start_date, $end_date) {
                    $q->whereBetween('form_detail_date', [$start_date, $end_date]);
                });
            })
            ->get();
        $form = Form::where('form_id', $id)->first();
        $total_form_detail = $form_detail->sum('form_detail_quantity');
        $measurement = $form_detail->pluck('form_detail_oum')->first();
        $pdf = Pdf::loadView('form.pdf_detail', compact('form_detail', 'form', 'total_form_detail', 'measurement'));

        return $pdf->stream('form_details.pdf'); // 👈 View in browser
    }
}
