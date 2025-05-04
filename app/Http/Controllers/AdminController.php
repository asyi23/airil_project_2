<?php

namespace App\Http\Controllers;

use Session;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Ads;
use App\Models\User;
use App\Models\AdsBump;
use App\Models\UserLog;
use App\Models\UserType;
use App\Models\EventDate;
use App\Models\AdsUpgrade;
use App\Models\SettingCity;
use App\Models\Transaction;
use App\Models\SettingState;
use App\Models\UserPlatform;
use Illuminate\Http\Request;
use App\Models\SettingBanner;
use App\Models\SettingCountry;
use Illuminate\Support\Carbon;
use App\Models\SettingDialcode;
use Illuminate\Validation\Rule;
use App\Models\SettingBackground;
use App\Models\UserCreditHistory;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MediaRepository;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanySubscriptionInvoice;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function dashboard(Request $request)
    {

        return view('dashboard', []);
    }



    public function listing(Request $request)
    {
        $search = array();
        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':
                    session(['user_search' => [
                        "freetext" =>  $request->input('freetext'),
                        "user_status" =>  $request->input('user_status'),
                        "user_type_id" =>  $request->input('user_type_id'),
                        "user_role_id" =>  $request->input('user_role_id'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('user_search');
                    break;
            }
        }

        $search = session('user_search') ? session('user_search') : $search;
        return view('admin/listing', [
            'submit' => route('admin_add'),
            'title' => 'Add',
            'users' =>  User::get_record($search, 15, [1, 6]),
            'search' =>  $search,
            'user_type_sel' => ['' => 'Please select User Type'] + UserType::get_admin_user_type(),
            'user_role_sel' => ['' => 'Please select admin role'] + UserType::get_user_role_sel('administrator'),
            'user_status_sel' => ['' => 'Please select status', 'active' => 'Active', 'suspend' => 'Suspend'],
        ]);
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
                'submit' => route('admin_change_password'),
                'title' => 'Change Password',
            ])->withErrors($validator);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            Session::flash('fail_msg', 'Current password is incorrect. Please try again.');

            return redirect()->route('admin_change_password');
        }


        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);
        $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');
        Session::flash('success_msg', 'Password successfully updated for ' . $user->user_email . ' user.');
        return redirect()->route('admin_change_password');
    }

    return view('admin.change_password', [
        'submit' => route('admin_change_password'),
        'title' => 'Change Password',
    ])->withErrors($validator);
}
    public function access_user_account ($user_id)
    {
        $superAdminId = auth()->id();
        $encryptedSuperAdminId = encrypt($superAdminId);
        session(['super_admin_id' => $encryptedSuperAdminId]);

        Auth::loginUsingId($user_id);

        return redirect()->route('dashboard');
    }

    public function edit_user_account($user_id)
    {
        return redirect()->route('user_edit',$user_id);
    }

    public function switch_back(){

        try {
            $encryptedSuperAdminId = session('super_admin_id');
            $superAdminId = decrypt($encryptedSuperAdminId);

            $admin = User::find($superAdminId);
            if ($admin == null) {
                abort(404);
            }
        } catch (Exception $e) {
            abort(404);
        } catch (Throwable $t) {
            abort(404);
        }

        Auth::logout();
        Auth::loginUsingId($superAdminId);

        session()->forget('super_admin_id');

        return redirect()->route('dashboard');
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

            $user_countryAbb = SettingCountry::where('country_abb',$request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id',$user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $validator = Validator::make(array_merge($request->all() , ['user_mobile' => $user_mobile] , ['user_type_id' => Auth::user()->user_type_id]), [
                'user_email' => "required|max:100|unique:tbl_user,user_email,{$user_id},user_id,is_deleted,0",
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_mobile' => "required|min:8|max:12|unique:tbl_user,user_mobile,{$user_id},user_id,is_deleted,0",
                'user_gender' => 'nullable',
                'user_nric' => "nullable|digits:12|unique:tbl_user,user_nric,{$user_id},user_id,is_deleted,0",
                'user_dob' => 'nullable',
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_city' => "nullable|max:100",
                'user_state_id' => "required",
                'user_nationality' => 'nullable|max:100',
                'user_type_id' => 'required',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ])->setAttributeNames([
                'username' => 'Username',
                'user_email' => 'Email',
                'user_fullname' => 'Fullname',
                'user_mobile' => 'Mobile Number',
                'user_gender' => 'Gender',
                'user_nric' => 'NRIC',
                'user_dob' => 'Date of Birth',
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_postcode' => 'Postcode',
                'user_city' => "City",
                'user_state_id' => "State",
                'user_nationality' => 'Nationality',
                'user_type_id' => 'User Type',
                'user_profile_picture' => 'Profile picture',
            ]);

            if (!$validator->fails()) {
                $user_type_id = $request->input('user_type_id');
                $update_detail = [
                    'user_email' => $request->input('user_email'),
                    'user_fullname' => $request->input('user_fullname'),
                    'dialcode_id'=> $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'user_gender' => $request->input('user_gender'),
                    'user_nric' => $request->input('user_nric'),
                    'user_dob' => $request->input('user_dob'),
                    'user_address' => $request->input('user_address'),
                    'user_address2' => $request->input('user_address2'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_city' => $request->input('user_city'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_type_id' => $user_type_id,
                    'user_ip' => $request->ip(),
                    'user_type_id' => $user->user_type_id,
                ];


                if ($request->hasFile('user_profile_picture')) {
                    if ($user->hasMedia('user_profile_picture')) {
                        $user->getFirstMedia('user_profile_picture')->delete();
                    }

                    (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_picture'));
                }
                $user->Update($update_detail);


                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');
                Session::flash('success_msg', 'Successfully updated ' . $request->input('user_email') . ' user.');
                return redirect()->route('admin_profile');
            }

            $post = (object) $request->all();
        }

        return view('admin.profile', [
            'post' => $post,
            'user'=> $user,
            'submit' => route('admin_profile'),
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

    public function add(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {

            $user_countryAbb = SettingCountry::where('country_abb',$request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id',$user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $validator = Validator::make(array_merge($request->all() , ['user_mobile' => $user_mobile] , ['user_type_id' => Auth::user()->user_type_id]), [
                'user_nric' => 'nullable|digits:12|unique:tbl_user,user_nric,null,user_id,is_deleted,0',
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_email' => 'required|max:100|unique:tbl_user,user_email,null,user_id,is_deleted,0',
                'user_mobile' => [
                    'required',
                    'digits_between:9,12',
                    'unique:tbl_user,user_mobile,null,user_id,is_deleted,0',
                ],
                'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
                'user_type_id' => 'required',
                'user_dob' => 'nullable',
                'user_nationality'=> 'nullable|max:100',
                'user_gender' => 'nullable',
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'user_state_id' => "nullable",
                'user_city' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',

            ])->setAttributeNames([
                'user_email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Confirm Passwpord',
                'user_fullname' => 'Fullname',
                'user_nric' => 'NRIC',
                'user_nationality' => 'Nationality',
                'user_gender' => 'Gender',
                'user_dob' => 'Date of Birth',
                'user_mobile' => 'Mobile Number',
                'user_whatsapp' => "Whatsapp",
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_state_id' => "State",
                'user_city' => "City",
                'user_postcode' => 'Postcode',
                'user_type_id' => 'User Type',
                'user_profile_picture' => 'Profile picture',
            ]);

            if (!$validator->fails()) {
                $user_role_id = $request->input('user_role_id');
                $user = User::Create([
                    'username' => $request->input('user_email'),
                    'user_nric' => $request->input('user_nric'),
                    'user_fullname'=> $request->input('user_fullname'),
                    'user_email'=> $request->input('user_email'),
                    'dialcode_id' => $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'password' => bcrypt($request->input('password')),
                    'user_type_id' => $request->input('user_type_id'),
                    'user_dob' => $request->input('user_dob'),
                    'user_gender' => $request->input('user_gender'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_address' => $request->input('user_address'),
                    'user_address2' => $request->input('user_address2'),
                    'user_city' => $request->input('user_city'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_logindate' => now(),
                    'email_verified_at' => now(),
                    'user_ip' => $request->ip(),
                    'user_type_id' => 1,
                ]);

                if ($user_role_id > 0) {
                    $role = Role::findById($user_role_id);
                    if ($role) {
                        $user->syncRoles($role->name);
                    }
                }
                if($request->hasFile('user_profile_picture')){
                    (new MediaRepository)->add_media_with_convert_filename($user,'user_profile_picture',$request->file('user_profile_picture'));
                }
                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'create');
                Session::flash('success_msg', 'Successfully added ' . $request->input('user_fullname'));
                return redirect()->route('admin_listing');
            }

            $post = (object) $request->all();
        }
        return view('admin/form', [
            'submit' => route('admin_add'),
            'action' => 'add',
            'title' => 'Add',
            'post' => $post,
            'user_state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'user_role_sel' => UserType::get_user_role_sel('administrator'),
            'user_gender_sel' => array('' => 'Please select gender', 'Male' => 'Male', 'Female' => 'Female'),
            'countries' => SettingDialcode::get_sel(),
        ])->withErrors($validator);
    }

    public function edit(Request $request, $user_id)
    {
        $validator = null;
        $user = User::find($user_id);
        $post = clone $user;
        if (!$user) {
            Session::flash('fail_msg', 'Invalid User, Please try again later.');
            return redirect('/admin/listing');
        }
        $user_role = optional($user->roles)->first();

        $country_id = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('country_id');
        $country_dialcode = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('dialcode');
        $countryAbb = SettingCountry::where('country_id', $country_id)->value('country_abb');

        $post->user_mobile = str_replace($country_dialcode, '', $post->user_mobile);

        if ($request->isMethod('post')) {

            $user_countryAbb = SettingCountry::where('country_abb',$request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id',$user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $validator = Validator::make(array_merge($request->all() , ['user_mobile' => $user_mobile] , ['user_type_id' => Auth::user()->user_type_id]), [
                'user_email' => "required|max:100|unique:tbl_user,user_email,{$user_id},user_id,is_deleted,0",
                'user_nric' => "nullable|digits:12|unique:tbl_user,user_nric,{$user_id},user_id,is_deleted,0",
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'user_mobile' => "required|min:8|max:12|unique:tbl_user,user_mobile,{$user_id},user_id,is_deleted,0",
                'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
                'user_type_id' => 'required',
                'user_dob' => 'nullable',
                'user_gender' => 'nullable',
                'user_nationality'=> 'nullable|max:100',
                'user_address' => "nullable|max:100",
                'user_address2' => "nullable|max:100",
                'state_id' => "nullable",
                'user_city' => "nullable|max:100",
                'user_postcode' => 'nullable|digits:5',
                'user_profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ])->setAttributeNames([
                'user_email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Confirm Passwpord',
                'user_fullname' => 'Fullname',
                'user_nric' => 'NRIC',
                'user_nationality' => 'Nationality',
                'user_gender' => 'Gender',
                'user_dob' => 'Date of Birth',
                'user_mobile' => 'Mobile Number',
                'user_alternative_mobile' => "Alternative Mobile No",
                'user_whatsapp' => "Whatsapp",
                'user_address' => "Address",
                'user_address2' => "Address",
                'user_state_id' => "State",
                'user_city' => "City",
                'user_postcode' => 'Postcode',
                'user_type_id' => 'User Type',
                'user_profile_picture' => 'Profile picture',

            ]);

            if (!$validator->fails()) {
                $user_type_id = $request->input('user_type_id');
                $user_role_id = $request->input('user_role_id');
                $update_detail = [
                    'username' => $request->input('user_email'),
                    'user_nric' => $request->input('user_nric'),
                    'user_fullname'=> $request->input('user_fullname'),
                    'user_email'=> $request->input('user_email'),
                    'dialcode_id'=> $user_dialcode_id,
                    'user_mobile' => $user_mobile,
                    'user_type_id'=> $request->input('user_type_id'),
                    'user_dob'=> $request->input('user_dob'),
                    'user_gender'=> $request->input('user_gender'),
                    'user_nationality' => $request->input('user_nationality'),
                    'user_address'=> $request->input('user_address'),
                    'user_address2'=> $request->input('user_address2'),
                    'user_city' => $request->input('user_city'),
                    'user_state_id' => $request->input('user_state_id'),
                    'user_postcode' => $request->input('user_postcode'),
                    'user_ip' => $request->ip(),
                    'user_type_id' => 1,
                ];
                if ($request->input('password') != 'xxxxxxxx') {
                    $update_detail['password'] = bcrypt($request->input('password'));
                }
                unset($user->password);
                $user->Update($update_detail);

                if ($user_role_id > 0) {
                    $role = Role::findById($user_role_id);
                    if ($role) {
                        $user->syncRoles($role->name);
                    }
                }
                if ($request->hasFile('user_profile_picture')) {
                    if ($user->hasMedia('user_profile_picture')) {
                        $user->getFirstMedia('user_profile_picture')->delete();
                    }

                    (new MediaRepository)->add_media_with_convert_filename($user, 'user_profile_picture', $request->file('user_profile_picture'));
                }
                $this->user_log($user->user_id, Carbon::now()->format('Y-m-d H:i:s'), $user->user_ip, 'edit');
                Session::flash('success_msg', 'Successfully updated ' . $request->input('user_email') . ' user.');
                return redirect()->route('admin_listing');
            }
            $post = (object) $request->all();
        }
        return view('admin/form', [
            'submit' => route('admin_edit', $user_id),
            'action' => 'edit',
            'title' => 'Edit',
            'post' => $post,
            'user'=>$user,
            'user_role' => $user_role,
            'user_state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'user_role_sel' => UserType::get_user_role_sel('administrator'),
            'user_gender_sel' => array('' => 'Please select gender', 'male' => 'Male', 'female' => 'Female'),
            'countries' => SettingDialcode::get_sel(),
            'country_abb' => $countryAbb,
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
        return redirect()->route('admin_listing');
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
                        return redirect()->route('admin_listing');
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
                        return redirect()->route('assign_permission', $user_id);
                        break;
                }
            }
            $post = (object) $request->all();
        }

        $roles = Role::get();
        return view('admin/assign_permission', [
            'submit' => route('assign_permission', $user_id),
            'title' => 'Assign Permission',
            'user' => $user,
            'user_role' => $user_role,
            'roles' => Role::where('user_type_group','administrator')->get(),
            'permissions' => Permission::orderBy('group_name', 'asc')->get(),
            'user_permission' => $user->getAllPermissions() ?  $user->getAllPermissions()->pluck('name')->toArray() : [],
            'role_permissions' => $role_permissions,
        ])->withErrors($validator);
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
