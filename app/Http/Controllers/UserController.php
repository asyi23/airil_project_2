<?php

namespace App\Http\Controllers;

use console;
use Session;
use App\Models\Ads;
use App\Models\User;
use App\Models\Company;
use App\Models\UserLog;
use App\Models\UserType;
use App\Models\CompanyUser;
use App\Models\SettingCity;
use App\Models\UserContact;
use App\Models\SettingState;
use Illuminate\Http\Request;
use App\Models\CompanyBranch;
use App\Models\SettingBanner;
use App\Models\SettingCountry;
use Illuminate\Support\Carbon;
use App\Models\SettingDialcode;
use Illuminate\Validation\Rule;
use App\Models\SettingBackground;
use App\Models\UserRemoveHistory;
use Spatie\Permission\Models\Role;
use App\Models\SettingSubscription;
use Illuminate\Support\Facades\Log;
use App\Models\UserPreferredContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MediaRepository;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['register']);
    }

    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function register(Request $request, $branch_id, $encrypt_code)
    {
        try {
            $databranchid = decrypt($encrypt_code);
            $Databranchid = preg_replace('/[^0-9]/', '', $databranchid);

            $branch = CompanyBranch::find($Databranchid);
            if ($branch == null) {
                abort(404);
            }
        } catch (Exception $e) {
            abort(404);
        } catch (\Throwable $t) {
            abort(404);
        }
        $company = Company::where('company_id', $branch->company_id)->first();
        $useremail = null;
        $enableModal = false;
        $validator = null;
        $post = null;
        $user_type_sel = UserType::get_user_type_sel();
        unset($user_type_sel[1], $user_type_sel[2]);


        if ($request->isMethod('post')) {
            $user_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id', $user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');


            $usermobile = User::where('user_mobile', $user_mobile)->first();

            if ($usermobile !== null && $usermobile->user_email === $request->input('user_email')) {
                $useremail = $usermobile->user_email;
                $enableModal = true;
            }


            $validator = Validator::make(
                [
                    'username' => $request->input('username'),
                    'user_fullname' => $request->input('user_fullname'),
                    'user_email' => $request->input('user_email'),
                    'user_mobile' => $user_mobile,
                    'password' => $request->input('password'),
                    'confirm_password' => $request->input('confirm_password'),
                ],
                [
                    'username' => [
                        'required',
                        'regex:/^[a-zA-Z0-9.\s_\-]+$/u',
                        'max:100',
                        'unique:tbl_user,username,null,user_id,is_deleted,0'
                    ],
                    'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                    'user_email' => 'required|max:100|unique:tbl_user,user_email,null,user_id,is_deleted,0',
                    'user_mobile' => [
                        'required',
                        'digits_between:9,12',
                        'unique:tbl_user,user_mobile,null,user_id,is_deleted,0'
                    ],
                    'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'required|min:8|max:100',
                ]
            )->setAttributeNames([
                'user_fullname' => 'Full Name',
                'username' => 'Username',
                'user_email' => 'Email',
                'user_mobile' => 'Mobile Number',
                'password' => 'Password',
                'confirm_password' => 'Confirm Password',
            ]);


            if (!$validator->fails()) {

                $users = User::where('user_mobile', $user_mobile)->first();

                if ($users != null) {
                    $company = CompanyUser::Create([
                        'user_id' => $users->user_id,
                        'company_id' => $company->company_id,
                        'company_branch_id' => $branch_id
                    ]);
                } else {
                    $user = User::Create([
                        'user_fullname' => $request->input('user_fullname'),
                        'username' => $request->input('username'),
                        'user_email' => $request->input('user_email'),
                        'dialcode_id' => $user_dialcode_id,
                        'user_mobile' => $user_mobile,
                        'password' => bcrypt($request->input('password')),
                        'email_verified_at' => now(),
                        'user_ip' => $request->ip(),
                        'user_type_id' => 2,

                    ]);

                    $company = CompanyUser::Create([
                        'user_id' => $user->user_id,
                        'company_id' => $company->company_id,
                        'company_branch_id' => $branch_id
                    ]);

                    $role = Role::findById(4);
                    if ($role) {
                        $user->syncRoles($role->name);
                    }

                    Auth::login($user);
                    $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'create');

                    return redirect()->route('user_profile');
                }
            }


            $post = (object) $request->all();
        }
        $encryptedData = encrypt('Register' . $branch_id);
        $appUrl = env('APP_URL');


        return view('user.register_user', [
            'email' => $useremail,
            'post' => $post,
            'countries' => SettingDialcode::get_sel(),
            'enableModal' => $enableModal,
            'branch_id' => $branch_id,
            'branch' => $branch,
            'encrypt_code' => $encryptedData,
            'appUrl' => $appUrl,
            'company'=>$company,
        ])->withErrors($validator);
    }

    public function user_listing(Request $request)
    {
        $search = array();
        $user_type = UserType::get_user_type_sel();
        $user_role = UserType::get_user_role_sel('user');
        $user = Auth::user();
        $group_type = $user->user_type->user_type_group;
        $company_id = $user->join_company->company->company_id ?? null;
        $branch_id = $user->join_company->company_branch_id ?? null;


        unset($user_type[1]);
        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':
                    session(['user_search' => [
                        "freetext" =>  $request->input('freetext'),
                        "user_status" =>  $request->input('user_status'),
                        "company_id" =>  $request->input('company_id'),
                        "user_role_id" =>  $request->input('user_role_id'),
                        'branch_id' => $request->input('branch_id'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('user_search');
                    break;
            }
        }
        $company_branch[''] = 'Please select company branch';
        $search = session('user_search') ? session('user_search') : $search;
        return view('user/listing', [
            'submit' => route('user_listing'),
            'submit_new' => route('user_add'),
            'title' => 'Add',
            'type' => 'User',
            'users' =>  User::get_record($search, 15, [2, 3], $group_type, $company_id, $branch_id),
            'search' =>  $search,
            'user_url' => ENV('APP_USER_URL'),
            'user_role' => ['' => 'Please select user role'] + $user_role,
            'company_sel' => ['' => 'Please select company'] + Company::company_dropdown(),
            'user_type_sel' => $user_type,
            'user_status_sel' => ['' => 'Please select status', 'active' => 'Active', 'suspend' => 'Suspend'],
            'group_type' => $group_type,
            'company_branch_id' => $company_branch,
            'branch' => ['' => 'Please select branch'] + CompanyBranch::branch_dropdown($company_id),

        ]);
    }

    public function ajax_upload_profile_image(Request $request)
    {
        $user_id = (Auth::user()->user_id);
        $user = User::find($user_id);

        $user->clearMediaCollection('user_profile_picture');

        // Store the new cropped image using Spatie's media library
        $profilePhoto = (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_photo_original'));

        return response()->json([
            'status' => true,
            'data' => [
                'user_profile_photo_crop' => $profilePhoto->getUrl(),
            ],
        ]);
    }

    public function profile(Request $request)
    {
        $user_id = (Auth::user()->user_id);

        $validator = null;
        $user =  User::find($user_id);
        $post = clone $user;

        if (!$user) {
            Session::flash('fail_msg', 'Invalid User, Please try again later.');
            return redirect('/user/listing');
        }

        $user_type_sel = UserType::get_user_type_sel();
        unset($user_type_sel[1], $user_type_sel[2]);

        $column = 'col-xl-9 col-lg-12 col-md-12';
        if ($user->user_type_id == '1') {
            $column = 'col-12';
        }

        $country_id = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('country_id');
        $country_dialcode = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('dialcode');
        $countryAbb = SettingCountry::where('country_id', $country_id)->value('country_abb');

        $post->user_mobile = str_replace($country_dialcode, '', $post->user_mobile);

        if ($request->isMethod('post')) {

            $user_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id', $user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $validator = Validator::make($request->all() + ['user_type_id' => Auth::user()->user_type_id], [
                'username' => [
                    'required',
                    'regex:/^[a-zA-Z0-9.\s_\-]+$/u',
                    'max:100',
                    "unique:tbl_user,username,{$user_id},user_id,is_deleted,0"
                ],
                'user_email' => "required|max:100|unique:tbl_user,user_email,{$user_id},user_id,is_deleted,0",
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_mobile' => "required|phone_number|min:8|max:12|unique:tbl_user,user_mobile,{$user_id},user_id,is_deleted,0",
                'user_gender' => 'nullable',
                'user_nric' => "nullable|digits:12|unique:tbl_user,user_nric,{$user_id},user_id,is_deleted,0",
                'user_dob' => 'nullable',
                'user_position' => 'nullable|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_city' => "nullable|max:100",
                'user_state_id' => "nullable",
                'user_nationality' => 'nullable|max:100',
                'user_type_id' => 'required',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'user_template_background_id' => "nullable",
                'user_template_banner_id' => "nullable",
                'user_template_colour' => "nullable",
                'user_facebook_url' => "nullable",
                'user_instagram_url' => "nullable",
            ])->setAttributeNames([
                'username' => 'Username',
                'user_email' => 'Email',
                'user_fullname' => 'Fullname',
                'user_mobile' => 'Mobile Number',
                'user_gender' => 'Gender',
                'user_nric' => 'NRIC',
                'user_dob' => 'Date of Birth',
                'user_position' => 'User Position',
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_postcode' => 'Postcode',
                'user_city' => "City",
                'user_state_id' => "State",
                'user_nationality' => 'Nationality',
                'user_type_id' => 'User Type',
                'user_profile_picture' => 'Profile picture',
                'user_template_background_id' => "Background",
                'user_template_banner_id' => "Banner",
                'user_template_colour' => "Colour",
                'user_facebook_url' => "Facebook Page URL",
                'user_instagram_url' => "Instagram Post URL",
            ]);

            if (!$validator->fails()) {
                $user_type_id = $request->input('user_type_id');
                $update_detail = [
                    'username' => $request->input('username'),
                    'user_email' => $request->input('user_email'),
                    'user_fullname' => $request->input('user_fullname'),
                    'dialcode_id' => $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'user_gender' => $request->input('user_gender'),
                    'user_nric' => $request->input('user_nric'),
                    'user_dob' => $request->input('user_dob'),
                    'user_position' => $request->input('user_position'),
                    'user_address' => $request->input('user_address'),
                    'user_address2' => $request->input('user_address2'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_city' => $request->input('user_city'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_type_id' => $user_type_id,
                    'user_ip' => $request->ip(),
                    'user_template_background_id' => $request->input('user_template_background_id'),
                    'user_template_banner_id' => $request->input('user_template_banner_id'),
                    'user_template_colour' => $request->input('user_template_colour'),
                    'user_facebook_url' => $request->input('user_facebook_url'),
                    'user_instagram_url' => $request->input('user_instagram_url'),
                    'user_type_id' => $user->user_type_id,
                ];


                if ($request->hasFile('user_profile_picture')) {
                    if ($user->hasMedia('user_profile_picture')) {
                        $user->getFirstMedia('user_profile_picture')->delete();
                    }

                    (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_picture'));
                }

                $allowedColors = ['#18B2BB', '#7378C8', '#FF1E96', '#FF1E96', '#FFC800'];

                if (!in_array($request->input('colour_radio'), $allowedColors)) {
                    $update_detail['user_template_colour'] = $request->input('user_template_colour');
                }



                $user->Update($update_detail);


                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');
                Session::flash('success_msg', 'Successfully updated ' . $request->input('user_email') . ' user.');
                return redirect()->route('user_profile');
            }

            $post = (object) $request->all();
        }

        return view('user.profile', [
            'post' => $post,
            'user' => $user,
            'submit' => route('user_profile'),
            'title' => 'Profile',
            'user_state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'user_gender_sel' => array('' => 'Please select gender', 'male' => 'Male', 'female' => 'Female'),
            'user_city_sel' => @$$user->user_state ? ['' => 'Please select city'] + SettingCity::get_sel($$user->user_state) : ['' => 'Please select city'],
            'background_sel' => ['' => 'Please select background'] + SettingBackground::background_dropdown(),
            'banner_sel' => ['' => 'Please select banner'] + SettingBanner::banner_dropdown(),
            'column' => $column,
            'countries' => SettingDialcode::get_sel(),
            'country_abb' => $countryAbb,
        ])->withErrors($validator);
    }

    public function change_password(Request $request)
    {
        $user = Auth::user();
        $validator = null;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
            ])->setAttributeNames([
                'old_password' => 'Current Password',
                'new_password' => 'New Password',
                'confirm_password' => 'Confirm Password',
            ]);

            if ($validator->fails()) {
                return view('user.change_password', [
                    'submit' => route('user_change_password'),
                    'title' => 'Change Password',
                ])->withErrors($validator);
            }

            if (!Hash::check($request->old_password, $user->password)) {
                Session::flash('fail_msg', 'Current password is incorrect. Please try again.');

                return redirect()->route('user_change_password');
            }


            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');
            Session::flash('success_msg', 'Password successfully updated for ' . $user->user_email . ' user.');
            return redirect()->route('user_change_password');
        }

        return view('user.change_password', [
            'submit' => route('user_change_password'),
            'title' => 'Change Password',
        ])->withErrors($validator);
    }

    public function add(Request $request)
    {
        $enableModal = false;
        $validator = null;
        $post = null;
        $user_role = UserType::get_user_role_sel('user');
        $users = Auth::user();
        if($users->user_type->user_type_group == 'user'){
            $company_name = $users->join_company->company->company_name ?? null;
            $company_id = $users->join_company->company->company_id ?? null;
            $branch_id = $users->join_company->company_branch->company_branch_id ?? null;
        }
        $user_countryAbb = null;
        $branchCheck = null;


        if ($request->isMethod('post')) {

            $user_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id', $user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $branch_mobile = null;
            if ($request->has('branchCheck')) {
                $branchCheck = 'checked';
                if($request->input('branch_mobile')){
                    $branch_countryAbb = SettingCountry::where('country_abb', $request->input('branch_country_dialcode'))->first();
                    $branch_dialcode_id = SettingDialcode::where('country_id', $branch_countryAbb->country_id)->value('dialcode_id');
                    $branch_mobile = $branch_countryAbb->country_dialcode . $request->input('branch_mobile');
                }
            }

            $usermobile = User::where('user_mobile', $user_mobile)->first();
            if (Auth::user()->user_type->user_type_group == 'administrator') {
                if ($usermobile !== null && $usermobile->user_email === $request->input('user_email')) {
                    $useremail = $usermobile->user_email;
                    $enableModal = true;
                }
            }
            if(Auth::user()->roles->value('id') == 4){
                $companybranch_id = $users->join_company->company_branch_id;
            }else{
                $companybranch_id = $request->input('company_branch_id');
            }

            $validator = Validator::make(array_merge($request->all(), ['user_mobile' => $user_mobile],['company_branch_id'=> $companybranch_id], ['user_type_id' => Auth::user()->user_type_id]), [
                'user_nric' => 'nullable|digits:12|unique:tbl_user,user_nric,null,user_id,is_deleted,0',
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'username' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._-]+$/u',
                    'max:100',
                    'unique:tbl_user,username,null,user_id,is_deleted,0'
                ],
                'user_email' => 'required|max:100|unique:tbl_user,user_email,null,user_id,is_deleted,0',
                'user_mobile' => [
                    'required',
                    'digits_between:9,12',
                    'unique:tbl_user,user_mobile,null,user_id,is_deleted,0'
                ],
                'user_position' => 'nullable|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
                'user_type_id' => 'required',
                'user_dob' => 'nullable',
                'user_gender' => 'nullable',
                'user_facebook_url' => "nullable",
                'user_instagram_url' => "nullable",
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'user_state_id' => "nullable",
                'user_city' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_nationality' => 'nullable|max:100',
                'company_id' => 'required_if:user_type_id,1',
                'company_branch_id' =>$branchCheck == 'checked' ? 'nullable':'required',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'user_template_background_id' => "nullable",
                'user_template_banner_id' => "nullable",
                'user_template_colour' => "nullable",
                'user_facebook_url' => "nullable|max:100",
                'user_instagram_url' => "nullable|max:100",

                // if branch checked
                'branch_name' => $branchCheck == 'checked' ? 'required|max:100|unique:tbl_company_branch,company_branch_name,null,company_branch_id,is_deleted,0' : 'nullable',
                'branch_register_number' => 'nullable|max:225',
                'branch_mobile' => 'nullable|digits_between:9,12',
                'branch_status' => $branchCheck == 'checked' ? 'required' : 'nullable',
            ])->setAttributeNames([
                'user_nric' => 'NRIC',
                'user_fullname' => 'Fullname',
                'username' => 'Username',
                'user_email' => 'Email',
                'user_mobile' => 'Mobile Number',
                'user_position' => 'User Position',
                'password' => 'Password',
                'confirm_password' => 'Confirm Password',
                'user_type_id' => 'User Type',
                'user_dob' => 'Date of Birth',
                'user_gender' => 'Gender',
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_state_id' => "State",
                'user_city' => "City",
                'user_postcode' => 'Postcode',
                'user_nationality' => 'Nationality',
                'company_id' => 'Company',
                'company_branch_id' => 'Company Branch',
                'user_profile_picture' => 'Profile picture',
                'user_template_background_id' => "Background",
                'user_template_banner_id' => "Banner",
                'user_template_colour' => "Colour",
                'user_facebook_url' => "Facebook Page URL",
                'user_instagram_url' => "Instagram Post URL",
                'branch_name' => "Branch Name",
                'branch_register_number' => "Branch Register Number",
                'branch_mobile' => "Branch Mobile",
                'branch_status' => "Branch Status",
            ]);

            if (!$validator->fails()) {

                $user_type_id = $request->input('user_type_id');
                $user = User::Create([
                    'user_nric' => $request->input('user_nric'),
                    'user_fullname' => $request->input('user_fullname'),
                    'username' => $request->input('username'),
                    'user_email' => $request->input('user_email'),
                    'dialcode_id' => $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'user_position' => $request->input('user_position'),
                    'password' => bcrypt($request->input('password')),
                    'user_dob' => $request->input('user_dob'),
                    'user_gender' => $request->input('user_gender'),
                    'user_address' => $request->input('user_address'),
                    'user_address2' => $request->input('user_address2'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_city' => $request->input('user_city'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_logindate' => now(),
                    'email_verified_at' => now(),
                    'user_ip' => $request->ip(),
                    'user_template_background_id' => $request->input('background'),
                    'user_template_banner_id' => $request->input('banner'),
                    'user_template_colour' => $request->input('user_template_colour'),
                    'user_facebook_url' => $request->input('user_facebook_url'),
                    'user_instagram_url' => $request->input('user_instagram_url'),
                    'user_type_id' => 2,
                ]);

                if ($request->has('branchCheck')) {

                    $companyBranch = CompanyBranch::Create([
                        'company_branch_name' => $request->input('branch_name'),
                        'company_branch_register_number' => $request->input('branch_register_number'),
                        'company_branch_phone' => $branch_mobile ?? '',
                        'company_branch_status' => $request->input('branch_status'),
                        'company_id' => $users->join_company->company_id ?? $request->input('company_id'),
                        'dialcode_id' => $branch_dialcode_id ?? 130,
                    ]);

                    $companyBranchID = $companyBranch->company_branch_id;
                }else{
                    $companyBranchID = $companybranch_id;
                }


                $company = CompanyUser::Create([
                    'user_id' => $user->user_id,
                    'company_id' => $users->join_company->company_id ?? $request->input('company_id'),
                    'company_branch_id' => $companyBranchID,
                ]);


                if ($request->input('user_role_id') > 0) {
                    $role = Role::findById($request->input('user_role_id'));
                    if ($role) {
                        $user->syncRoles($role->name);
                    }
                }

                if ($request->hasFile('user_profile_picture')) {
                    (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_picture'));
                }

                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'create');

                Session::flash('success_msg', 'Successfully added ' . $request->input('user_fullname'));
                return redirect()->route('user_listing');
            }

            $post = (object) $request->all();
        }

        return view('user/user_form', [
            'submit' => route('user_add'),
            'title' => 'Add',
            'cancel' => route('user_listing'),
            'post' => $post,
            'user_role' => $user_role,
            'company_branch_id' => ['' => 'Please select company branch'] + CompanyBranch::get_branch(@$company_id) ,
            'user_state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'company_sel' => ['' => 'Please select company'] + Company::company_dropdown(),
            'user_gender_sel' => array('' => 'Please select gender', 'Male' => 'Male', 'Female' => 'Female'),
            'background_sel' => ['' => 'Please select background'] + SettingBackground::background_dropdown(),
            'banner_sel' => ['' => 'Please select banner'] + SettingBanner::banner_dropdown(),
            'countries' => SettingDialcode::get_sel(),
            'countriesBranch' => SettingDialcode::get_sel(),
            'company_name' => @$company_name,
            'enableModal' => $enableModal,
            'country_abb' => $user_countryAbb,
            'country_abbBranch' => $user_countryAbb,
            'alreadyExist' => @$usermobile,
            'state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'country_dropdown' => ['' => 'Please select country'] + SettingCountry::country_dropdown(),
            'company_status_sel' => ['' => 'Please select status', 'active' => 'Active', 'pending' => 'Pending'],
            'branchCheck' => $branchCheck,
            'company_id'=> @$company_id,
            'branch' => @$branch_id
        ])->withErrors($validator);
    }


    public function edit(Request $request, $user_id)
    {
        $validator = null;
        $user =  User::find($user_id);
        $post = clone $user;
        $user_role = UserType::get_user_role_sel('user');
        $branchCheck = null;

        if (!$user) {
            Session::flash('fail_msg', 'Invalid User, Please try again later.');
            return redirect('/user/listing');
        }

        $company_branch_id_edit = CompanyUser::where('user_id', $user->user_id)->where('is_deleted', 0)->first() ;

        $user_type_sel = UserType::get_user_type_sel();
        unset($user_type_sel[1], $user_type_sel[2]);
        $country_id = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('country_id');
        $country_dialcode = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('dialcode');
        $countryAbb = SettingCountry::where('country_id', $country_id)->value('country_abb');

        $post->user_mobile = str_replace($country_dialcode, '', $post->user_mobile);

        if ($request->isMethod('post')) {
            $user_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id', $user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            if ($request->has('branchCheck')) {
                $branchCheck = 'checked';
                if($request->input('branch_mobile')){
                    $branch_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
                    $branch_dialcode_id = SettingDialcode::where('country_id', $branch_countryAbb->country_id)->value('dialcode_id');
                    $branch_mobile = $branch_countryAbb->country_dialcode . $request->input('user_mobile');
                }
            }
            if(Auth::user()->roles->value('id') == 4){
                $companybranch_id = $user->join_company->company_branch_id;
            }else{
                $companybranch_id = $request->input('company_branch_id');
            }
            $validator = Validator::make(array_merge($request->all(), ['user_mobile' => $user_mobile],['company_branch_id'=> $companybranch_id], ['user_type_id' => Auth::user()->user_type_id]), [
                'username' => [
                    'required',
                    'regex:/^[a-zA-Z0-9._-]+$/u',
                    'max:100',
                    Rule::unique('tbl_user', 'username')
                        ->whereNot('user_id', $user->user_id)
                        ->where('is_deleted', 0),
                ],
                'user_email' => "required|max:100|unique:tbl_user,user_email,{$user_id},user_id,is_deleted,0",
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
                'user_mobile' => "required|min:8|max:12|unique:tbl_user,user_mobile,{$user_id},user_id,is_deleted,0",
                'user_gender' => 'nullable',
                'user_nric' => "nullable|digits:12|unique:tbl_user,user_nric,{$user_id},user_id,is_deleted,0",
                'user_dob' => 'nullable',
                'user_position' => 'nullable|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_facebook_url' => "nullable|max:100",
                'user_instagram_url' => "nullable|max:100",
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_city' => "nullable|max:100",
                'user_state_id' => "nullable",
                'user_nationality' => 'nullable|max:100',
                'user_type_id' => 'required',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'user_template_background_id' => "nullable",
                'user_template_banner_id' => "nullable",
                'user_template_colour' => "nullable",
                'company_id' => 'required_if:user_type_id,1',
                'company_branch_id' => ['required', 'not_in:0'],
            ])->setAttributeNames([
                'username' => 'Username',
                'user_email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Confirm Password',
                'user_fullname' => 'Fullname',
                'user_mobile' => 'Mobile Number',
                'user_gender' => 'Gender',
                'user_nric' => 'NRIC',
                'user_dob' => 'Date of Birth',
                'user_position' => 'User Position',
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_postcode' => 'Postcode',
                'user_city' => "City",
                'user_state_id' => "State",
                'user_nationality' => 'Nationality',
                'user_type_id' => 'User Type',
                'user_profile_picture' => 'Profile picture',
                'user_template_background_id' => "Background",
                'user_template_banner_id' => "Banner",
                'user_template_colour' => "Colour",
                'user_facebook_url' => "Facebook Page URL",
                'user_instagram_url' => "Instagram Post URL",
                'company_id' => "Company",
                'company_branch_id' => 'Company Branch',
            ]);
            if (!$validator->fails()) {
                $user_type_id = $request->input('user_type_id');
                $update_detail = [
                    'username' => $request->input('username'),
                    'user_email' => $request->input('user_email'),
                    'user_fullname' => $request->input('user_fullname'),
                    'dialcode_id' => $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'user_gender' => $request->input('user_gender'),
                    'user_nric' => $request->input('user_nric'),
                    'user_dob' => $request->input('user_dob'),
                    'user_position' => $request->input('user_position'),
                    'user_address' => $request->input('user_address'),
                    'user_address2' => $request->input('user_address2'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_city' => $request->input('user_city'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_type_id' => $user->user_type_id,
                    'user_ip' => $request->ip(),
                    'user_template_background_id' => $request->input('user_template_background_id'),
                    'user_template_banner_id' => $request->input('user_template_banner_id'),
                    'user_template_colour' => $request->input('user_template_colour'),
                    'user_facebook_url' => $request->input('user_facebook_url'),
                    'user_instagram_url' => $request->input('user_instagram_url'),
                ];

                $newValues = [
                    'company_id' => $request->input('company_id') ?? $user->join_company->company_id,
                    'company_branch_id' => $companybranch_id,
                ];
                $company_user = CompanyUser::where('user_id', $user->user_id)->first();

                if($company_user){
                    $company_user->update($newValues);
                }else{
                    $company = CompanyUser::Create([
                        'user_id' => $user->user_id,
                        'company_id' => $request->input('company_id'),
                        'company_branch_id' => $companybranch_id,
                    ]);
                }

                if ($request->input('password') !== "xxxxxxxx") {
                    $update_detail['password'] = bcrypt($request->input('password'));
                } else {
                    unset($update_detail['password']);
                }

                if ($request->hasFile('user_profile_picture')) {
                    if ($user->hasMedia('user_profile_picture')) {
                        $user->getFirstMedia('user_profile_picture')->delete();
                    }

                    (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_picture'));
                }

                if ($request->input('user_role_id') > 0) {
                    $role = Role::findById($request->input('user_role_id'));
                    if ($role) {
                        $user->syncRoles([$role->name]);
                    }
                }
                $user->Update($update_detail);

                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');

                Session::flash('success_msg', 'Successfully updated ' . $request->input('user_email') . ' user.');
                return redirect()->route('user_listing');
            }
            $post = (object) $request->all();
        }

        return view('user/form', [
            'submit' => route('user_edit', $user_id),
            'cancel' => route('user_listing'),
            'title' => 'Edit',
            'is_edit' => true,
            'post' => $post,
            'user' => $user,
            'user_document' => $user,
            'user_role' => $user_role,
            'user_state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'company_sel' => ['' => 'Please select company'] + Company::company_dropdown(),
            'user_type_sel' => $user_type_sel,
            'user_gender_sel' => array('' => 'Please select gender', 'male' => 'Male', 'female' => 'Female'),
            'background_sel' => ['' => 'Please select background'] + SettingBackground::background_dropdown(),
            'banner_sel' => ['' => 'Please select banner'] + SettingBanner::banner_dropdown(),
            'countries' => SettingDialcode::get_sel(),
            'country_abb' => $countryAbb,
            'company_branch_id' => ['' => 'Please select company branch'] + CompanyBranch::get_branch(@$company_id) ,
            'state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'country_dropdown' => ['' => 'Please select country'] + SettingCountry::country_dropdown(),
            'company_status_sel' => ['' => 'Please select status', 'active' => 'Active', 'pending' => 'Pending'],
            // 'country_abbBranch' => $user_countryAbb,
            'branchCheck' => $branchCheck,
            'company_branch_id_edit' => @$company_branch_id_edit->company_branch_id,
        ])->withErrors($validator);
    }

    public function status(Request $request)
    {
        $action = $request->input('action');
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $data['user_status'] = $action;
        $user->update($data);
        $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, $action);
        Session::flash('success_msg', "Successfully {$action} {$user->user_email} user.");
        if ($user->user_type->user_type_slug === 'user') {
            return redirect()->route('user_listing');
        }
    }
    public function assign_permission(Request $request, $user_id)
    {
        $validator = null;
        $post = $user =  User::find($user_id);
        if (!$user) {
            Session::flash('fail_msg', 'Invalid User, Please try again later.');
            return redirect('/');
        }
        $user_role = optional($user->roles)->first();
        $role_permissions = $user_role ? Role::findById($user_role->id)->permissions()->pluck('name')->toArray() : [];
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required',
            ])->setAttributeNames([
                'role_id' => 'User Role',
            ]);

            if (!$validator->fails()) {
                $submit_type = $request->input('submit');
                $role_id = $request->input('role_id');
                switch ($submit_type) {
                    case 'update':
                        $assign_permission = array();
                        if ($request->input('permissions') && $role_permissions) {
                            foreach ($request->input('permissions') as $permission) {
                                if (!in_array($permission, $role_permissions)) {
                                    $assign_permission[] = $permission;
                                }
                            }
                        }
                        $user->syncPermissions($assign_permission);
                        Session::flash('success_msg', 'Successfully updated ' . $user->user_email . ' permission.');
                        return redirect()->route('user_listing');
                        break;
                    case 'reset':
                        $role = Role::findById($role_id);
                        $user->syncRoles($role->name);
                        if ($request->input('permissions')) {
                            foreach ($request->input('permissions') as $permission) {
                                $user->revokePermissionTo($permission);
                            }
                        }
                        Session::flash('success_msg', 'Successfully reset ' . $user->user_email . ' permission.');
                        return redirect()->route('user_assign_permission', $user_id);
                        break;
                }
            }
            $post = (object) $request->all();
        }

        $roles = Role::get();
        return view('user/assign_permission', [
            'submit' => route('user_assign_permission', $user_id),
            'title' => 'Assign Permission',
            'user' => $user,
            'user_role' => $user_role,
            'roles' => Role::where('user_type_group','user')->get(),
            'permissions' => Permission::orderBy('group_name', 'asc')->get(),
            'user_permission' => $user->getAllPermissions() ?  $user->getAllPermissions()->pluck('name')->toArray() : [],
            'role_permissions' => $role_permissions,
        ])->withErrors($validator);
    }

    public function ajax_get_background_url(Request $request)
    {
        $data = null;
        $status = false;

        $background_id = $request->input('background_id');
        $background = SettingBackground::find($background_id);

        if ($background) {
            $data = $background->getFirstMediaUrl('background_image');
            $status = true;
        }

        return response()->json(['data' => $data, 'status' => $status]);
    }

    public function ajax_get_banner_url(Request $request)
    {
        $data = null;
        $status = false;

        $banner_id = $request->input('banner_id');
        $banner = SettingBanner::find($banner_id);

        if ($banner) {
            $data = $banner->getFirstMediaUrl('banner_image');
            $status = true;
        }

        return response()->json(['data' => $data, 'status' => $status, 'banner_id' => $banner_id]);
    }
    private function user_log(int $user_id = null, $user_log_cdate = null, string $user_log_ip = null, string $user_log_action = null)
    {
        UserLog::create([
            'user_id' => $user_id,
            'user_log_cdate' => $user_log_cdate,
            'user_log_ip' => $user_log_ip,
            'user_log_action' => $user_log_action,
        ]);
    }
}
