<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Form;
use App\Models\FormDetail;
use Illuminate\Http\Request;
use App\Models\SafetyAndHealth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DepartmentEquipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SafetyAndHealthController extends Controller
{
    public function listing(Request $request)
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
        return view('safety_and_health.listing', [
            'submit' => route('saftey_and_health_listing'),
            'records' => SafetyAndHealth::get_record($search, 15),

        ]);
    }
    
}
