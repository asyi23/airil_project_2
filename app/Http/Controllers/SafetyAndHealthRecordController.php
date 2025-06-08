<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Form;
use App\Models\FormDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DepartmentEquipment;
use App\Models\SafetyAndHealth;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyAndHealthRecord;
use Illuminate\Support\Facades\Validator;

class SafetyAndHealthRecordController extends Controller
{
    public function listing(Request $request, $id)
    {
        $search = array();
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
        } else {
            // If it's a GET request, clear the search session
            session()->forget('form_search');
        }
        $search = session('form_search') ? session('form_search') : $search;
        return view('safety_and_health.listing_record', [
            'submit' => route('saftey_and_health_record_listing', $id),
            'submit_new' => route('saftey_and_health_record_add', $id),
            'title' => 'Add',
            'records' => SafetyAndHealthRecord::get_record($search, 15, $id),
            'search' =>  $search,
            'id' => $id,

        ]);
    }

    public function add(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $submit = route('saftey_and_health_record_add', $id);

        $safety_and_health = SafetyAndHealth::find($id);
        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'safety_and_health_record_name' => 'required',
            ])->setAttributeNames([
                'safety_and_health_record_name' => 'Safety and Health Record Name',
            ]);


            if (!$validator->fails()) {
                $safety_and_health_record = SafetyAndHealthRecord::create([
                    'safety_and_health_record_name' => $request->input('safety_and_health_record_name'),
                    'safety_and_health_id' => $id,
                ]);
                Session::flash('success_msg', 'Successfully added ' . $safety_and_health_record->safety_and_health_record_name);

                return redirect()->route('saftey_and_health_record_listing', $id);
            }
            $post = (object) $request->all();
        }
        return view('safety_and_health/add_record', [
            'title' => 'Add',
            'submit' => $submit,
            'post' => $post,
            'id' => $id,
            'safety_and_health' => $safety_and_health
        ])->withErrors($validator);
    }

    public function edit(Request $request, $id)
    {
        $validator = null;
        $post = null;
        $safety_and_health_record = SafetyAndHealthRecord::where('safety_and_health_record_id', $id)->first();
        $submit = route('saftey_and_health_record_edit', $id);
        if (!$safety_and_health_record) {
            Session::flash('fail_msg', 'Invalid Safety and health record, Please try again later..');
            return redirect()->route('saftey_and_health_record_listing', $safety_and_health_record->safety_and_health_id);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'safety_and_health_record_name' => 'required',
            ])->setAttributeNames([
                'safety_and_health_record_name' => 'Safety and Health record name',
            ]);

            if (!$validator->fails()) {
                $safety_and_health_record->update([
                    'safety_and_health_record_name' => $request->input('safety_and_health_record_name'),
                ]);
                Session::flash('success_msg', 'Successfully edit ' . $safety_and_health_record->safety_and_health_record_name);

                return redirect()->route('saftey_and_health_record_listing', $safety_and_health_record->safety_and_health_id);
            }
            $post = (object) $request->all();
        }

        return view('safety_and_health/edit_record', [
            'title' => 'Edit',
            'submit' => $submit,
            'is_edit' => true,
            'post' => $post,
            'safety_and_health_record' => $safety_and_health_record,
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $safety_and_health_record = SafetyAndHealthRecord::find($request->input('safety_and_health_record_id'));
        if (!$safety_and_health_record) {
            Session::flash('fail_msg', 'Error, Please try again later..');
            return redirect()->route('saftey_and_health_record_listing', $safety_and_health_record->safety_and_health_id);
        }

        $safety_and_health_record->delete();

        Session::flash('success_msg', "Successfully delete " . $safety_and_health_record->safety_and_health_record_name);
        return redirect()->route('saftey_and_health_record_listing', $safety_and_health_record->safety_and_health_id);
    }
}
