<?php

namespace App\Http\Controllers;

use Session;
use DateTime;
use App\Models\Ads;
use App\Models\User;
use App\Models\AdsType;
use App\Models\Company;
use App\Models\Setting;
use App\Models\UserLog;
use Spatie\Image\Image;
use App\Models\CarBrand;
use App\Models\UserRole;
use App\Models\UserType;
use App\Models\MediaTemp;
use App\Jobs\ConvertVideo;
use App\Models\CompanyAds;
use App\Models\CompanyLog;
use App\Models\SettingAds;
use App\Models\CompanyUser;
use App\Models\SettingCity;
use App\Models\SettingState;
use Illuminate\Http\Request;
use App\Models\AdsClassified;
use App\Models\CompanyBranch;
use App\Models\CompanySocial;
use App\Models\SettingSector;
use App\Models\SettingSocial;
use App\Models\CompanyGallery;
use App\Models\SettingCountry;
use Illuminate\Support\Carbon;
use App\Models\SettingDialcode;
use Illuminate\Validation\Rule;
use App\Models\CompanyAssignLog;
use App\Models\SettingAdsCompany;
use App\Models\SettingDealerType;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Models\SettingCoverageArea;
use App\Models\SettingSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MediaRepository;
use App\Models\CompanySettingDocument;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function listing(Request $request, $id = 0)
    {
        $search = array();
        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':
                    session(['company_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'company_id' => $request->input('company_id'),
                        'company_status' => $request->input('company_status'),
                        'sector_id' => $request->input('sector_id'),

                    ]]);
                    break;
                case 'reset':
                    session()->forget('company_search');
                    break;
            }
        }
        $search = session('company_search') ? session('company_search') : $search;
        return view('company.listing', [
            'submit' => route('company_listing'),
            'submit_new' => route('company_add'),
            'title' => 'Add',
            'records' => Department::get_record($search, 15),
            'search' =>  $search,
        ]);
    }
    public function profile(Request $request)
    {
        $users = Auth::user();
        $company_id = $users->join_company->company->company_id ?? null;
        $post = Company::find($company_id);
        $post->business_hours = json_decode($post->company_business_hour, true);
        $year = date("Y", strtotime($post->company_created));
        $sector = SettingSector::where('sector_id', $post->sector_id)->value('sector_name');
        $carbrand = CarBrand::where('car_brand_id', $post->car_brand_id)->value('car_brand_name');
        $state = SettingState::where('state_id', $post->company_state_id)->value('state_name');
        $country = SettingCountry::where('country_id', $post->company_country_id)->value('country_name');

        $appUrl = env('APP_URL');

        return view('company.profile', [
            'submit' => route('company_profile'),
            'title' => 'Profile',
            'company_id' => $company_id,
            'post' => $post,
            'year' => $year,
            'sector' => $sector,
            'carbrand' => $carbrand,
            'state' => $state,
            'country' => $country,
            'appUrl' => $appUrl,

        ]);
    }

    public function add(Request $request)
    {
        $validator = null;
        $post = null;
        $owner = Auth::user();
        $user_role = UserType::get_user_role_sel('user');

        if ($request->isMethod('post')) {

            if ($request->input('company_phone')) {
                $company_countryAbb = SettingCountry::where('country_abb', $request->input('company_country_dialcode'))->first();
                $company_dialcode_id = SettingDialcode::where('country_id', $company_countryAbb->country_id)->value('dialcode_id');
                $company_phone = $company_countryAbb->country_dialcode . $request->input('company_phone');
            }
            if ($request->input('branch_mobile')) {
                $branch_countryAbb = SettingCountry::where('country_abb', $request->input('branch_country_dialcode'))->first();
                $branch_dialcode_id = SettingDialcode::where('country_id', $branch_countryAbb->country_id)->value('dialcode_id');
                $branch_mobile = $branch_countryAbb->country_dialcode . $request->input('branch_mobile');
            }
            $user_countryAbb = SettingCountry::where('country_abb', $request->input('user_country_dialcode'))->first();
            $user_dialcode_id = SettingDialcode::where('country_id', $user_countryAbb->country_id)->value('dialcode_id');
            $user_mobile = $user_countryAbb->country_dialcode . $request->input('user_mobile');

            $validator = Validator::make(array_merge($request->all(), ['user_mobile' => $user_mobile], ['user_type_id' => Auth::user()->user_type_id]), [
                //company detail
                'company_name' => 'required|max:100|unique:tbl_company,company_name,null,company_id,is_deleted,0',
                'company_register_number' => "nullable|max:255",
                'company_country_dialcode' => "required",
                'company_phone' => "nullable|numeric|digits_between:9,12",
                'company_status' => 'required',
                'company_email' => "nullable|email|max:100",
                'company_website' => "nullable|max:255",
                'company_address' => 'nullable|max:255',
                'company_address2' => 'nullable|max:255',
                'company_postcode' => 'nullable|max:45',
                'company_state_id' => 'nullable',
                'company_country_id' => 'nullable',
                'company_city_name' => 'nullable|max:100',
                'company_description' => 'nullable',
                'sector_id' => 'required',
                'car_brand_id' => 'required_if:sector_id,1',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'company_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'company_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'promotion_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'catalog_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'general_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'pricelist_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'brochure_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'pricelist_media' => 'nullable|mimes:pdf|max:51200',
                'brochure_media' => 'nullable|mimes:pdf|max:51200',
                //branch detail
                'branch_name' =>  'required|max:100|unique:tbl_company_branch,company_branch_name,null,company_branch_id,is_deleted,0',
                'branch_register_number' =>  'nullable|max:225',
                'branch_mobile' => 'nullable',
                'branch_status' =>  'required',
                //owner detail
                'user_nric' => 'nullable|digits:12|unique:tbl_user,user_nric,null,user_id,is_deleted,0',
                'user_fullname' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'username' => [
                    'required',
                    'regex:/^[a-zA-Z0-9.\s_\-]+$/u',
                    'max:100',
                    'unique:tbl_user,username,null,user_id,is_deleted,0'
                ],
                'user_email' => 'required|max:100|unique:tbl_user,user_email,null,user_id,is_deleted,0',
                'user_country_dialcode' => 'required',
                'user_mobile' => [
                    'required',
                    'digits_between:9,12',
                    'unique:tbl_user,user_mobile,null,user_id,is_deleted,0'
                ],
                'password' => 'min:8|max:100|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8|max:100',
                'user_dob' => 'nullable',
                'user_gender' => 'nullable',
                'user_position' => 'nullable|max:100',
            ])->setAttributeNames([
                //company detail
                'company_name' => 'Company Name',
                'company_register_number' => 'Company Registration Number',
                'company_country_dialcode' => 'Company Country Code',
                'company_phone' => 'Company Phone',
                'company_status' => 'Company Status',
                'company_email' => 'Company Email',
                'company_website' => 'Company Website',
                'company_type_id' => 'Company Type',
                'company_address' => 'Company Address',
                'company_postcode' => 'Company Postcode',
                'company_state_id' => 'Company State',
                'company_city_id' => 'Company City',
                'company_country_id' => 'Company Country',
                'company_description' => 'Company Description',
                'car_brand_id' => 'Car Brand',
                'sector_id' => 'Sector',
                'company_thumbnail' => 'Company Thumbnail',
                'company_logo' => 'Company Logo',
                'company_banner' => 'Company Banner',
                'company_thumbnail' => 'Company Thumbnail',
                'promotion_thumbnail' => 'Promotion Thumbnail',
                'catalog_thumbnail' => 'Catalog Thumbnail',
                'general_thumbnail' => 'General Thumbnail',
                'pricelist_thumbnail' => 'Pricelist Thumbnail',
                'brochure_thumbnail' => 'Brochure Thumbnail',
                'pricelist_media' => 'Pricelist Media',
                'brochure_media' => 'Brochure Media',
                //branch detail
                'branch_name' => "Branch Name",
                'branch_register_number' => "Branch Register Number",
                'branch_mobile' => "Branch Mobile",
                'branch_status' => "Branch Status",
                //owner detail
                'user_email' => 'Owner Email',
                'password' => 'Owner Password',
                'confirm_password' => 'Owner Confirm Password',
                'user_fullname' => 'Owner Full Name',
                'user_nric' => 'Owner NRIC',
                'user_nationality' => 'Owner Nationality',
                'user_gender' => 'Owner Gender',
                'user_dob' => 'Owner Date of Birth',
                'user_country_dialcode' => 'Owner Country Code',
                'user_mobile' => 'Owner Mobile Number',
                'user_position' => 'Owner Position',
                'user_type_id' => 'Owner User Type',
            ]);
            if (!$validator->fails()) {

                $company = Company::Create([
                    'company_name' => $request->input('company_name'),
                    'company_register_number' => $request->input('company_register_number'),
                    'dialcode_id' => $company_dialcode_id ?? 130,
                    'company_phone' => $company_phone ?? '',
                    'company_status' => $request->input('company_status'),
                    'company_email' => $request->input('company_email'),
                    'company_website' => $request->input('company_website'),
                    'company_address' => $request->input('company_address'),
                    'company_address2' => @$request->input('company_address2'),
                    'company_postcode' => $request->input('company_postcode'),
                    'company_state_id' => $request->input('company_state_id'),
                    'company_city_name' => $request->input('company_city_name'),
                    'company_country_id' => $request->input('company_country_id'),
                    'company_description' => $request->input('company_description'),
                    'sector_id' => $request->input('sector_id'),
                    'car_brand_id' => $request->input('car_brand_id'),
                ]);

                //Company Media File
                if ($request->hasFile('company_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'company_thumbnail', $request->file('company_thumbnail'));
                }
                if ($request->hasFile('company_logo')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'company_logo', $request->file('company_logo'));
                }
                if ($request->hasFile('company_banner')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'company_banner', $request->file('company_banner'));
                }
                if ($request->hasFile('promotion_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'promotion_thumbnail', $request->file('promotion_thumbnail'));
                }
                if ($request->hasFile('catalog_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'catalog_thumbnail', $request->file('catalog_thumbnail'));
                }
                if ($request->hasFile('general_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'general_thumbnail', $request->file('general_thumbnail'));
                }
                if ($request->hasFile('pricelist_media')) {
                    (new MediaRepository)->add_media($company, 'pricelist_media', $request->file('pricelist_media'));
                }

                if ($request->hasFile('brochure_media')) {
                    (new MediaRepository)->add_media($company, 'brochure_media', $request->file('brochure_media'));
                }
                if ($request->hasFile('brochure_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'brochure_thumbnail', $request->file('brochure_thumbnail'));
                }
                if ($request->hasFile('pricelist_thumbnail')) {
                    (new MediaRepository)->add_media_with_convert_filename($company, 'pricelist_thumbnail', $request->file('pricelist_thumbnail'));
                }

                if ($company) {
                    $branch = CompanyBranch::Create([
                        'company_branch_name' => $request->input('branch_name'),
                        'company_branch_register_number' => $request->input('branch_register_number'),
                        'company_branch_phone' => $branch_mobile ?? '',
                        'company_branch_status' => $request->input('branch_status'),
                        'company_id' => $company->company_id,
                        'dialcode_id' => $branch_dialcode_id ?? 130,
                    ]);
                }
                if ($company) {
                    $user = User::Create([
                        'username' => $request->input('username'),
                        'user_nric' => $request->input('user_nric'),
                        'user_fullname' => $request->input('user_fullname'),
                        'user_email' => $request->input('user_email'),
                        'user_mobile' => $user_mobile,
                        'password' => bcrypt($request->input('password')),
                        'user_type_id' => $request->input('user_type_id'),
                        'user_dob' => $request->input('user_dob'),
                        'user_gender' => $request->input('user_gender'),
                        'user_position' => $request->input('user_position'),
                        'user_logindate' => now(),
                        'email_verified_at' => now(),
                        'user_ip' => $request->ip(),
                        'user_type_id' => 2,
                        'dialcode_id' => $user_dialcode_id
                    ]);

                    if ($user) {
                        $company_user = CompanyUser::Create([
                            'user_id' => $user->user_id,
                            'company_id' => $company->company_id,
                            'company_branch_id' => $branch->company_branch_id
                        ]);
                    }
                    if ($request->input('user_role_id') > 0) {
                        $role = Role::findById($request->input('user_role_id'));
                        if ($role) {
                            $user->syncRoles($role->name);
                        }
                    }
                }
                $this->company_log($company->company_id, $owner->user_id, 'create');
                $this->user_log($user->user_id, Carbon::now(), $user->user_ip, 'create');


                Session::flash('success_msg', 'Successfully added ' . $company->company_name);
                return redirect()->route('company_listing');
            }
            $post = (object) $request->all();
            // dd($post);
        }
        return view('company/form', [
            'title' => 'Add',
            'submit' => route('company_add'),
            'cancel' => route('company_listing'),
            'user_role' => $user_role,
            'state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'sector_sel' => ['' => 'Please select sector'] + SettingSector::get_sel(),
            'user_gender_sel' => array('' => 'Please select gender', 'Male' => 'Male', 'Female' => 'Female'),
            'car_brand_dropdown' => ['' => 'Please select car brand'] + CarBrand::car_brand_dropdown(),
            'country_dropdown' => ['' => 'Please select country'] + SettingCountry::country_dropdown(),
            'company_status_sel' => ['active' => 'Active', 'pending' => 'Pending'],
            'post' => $post,
            'countries' => SettingDialcode::get_sel(),
        ])->withErrors($validator);
    }

    public function edit(Request $request, $company_id)
    {
        $owner = Auth::user();
        $validator = null;
        $company = Company::find($company_id);
        if (Auth::user()->user_type->user_type_slug == 'admin') {
            $submit = route('company_edit', $company_id);
        } else {
            $submit = route('company_profile_edit', $company_id);
        }

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/company/listing');
        }
        $post = clone $company;
        $country_id = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('country_id');
        $country_dialcode = SettingDialcode::where('dialcode_id', $post->dialcode_id)->value('dialcode');
        $countryAbb = SettingCountry::where('country_id', $country_id)->value('country_abb');

        $post->company_phone = str_replace($country_dialcode, '', $post->company_phone);
        if ($request->isMethod('post')) {
            if ($request->input('company_phone')) {
                $company_countryAbb = SettingCountry::where('country_abb', $request->input('company_country_dialcode'))->first();
                $company_dialcode_id = SettingDialcode::where('country_id', $company_countryAbb->country_id)->value('dialcode_id');
                $company_phone = $company_countryAbb->country_dialcode . $request->input('company_phone');
            }


            $validator = Validator::make(array_merge($request->all(), ['user_type_id' => Auth::user()->user_type_id]), [
                'company_name' => "required|max:100|unique:tbl_company,company_name,{$company_id},company_id,is_deleted,0",
                'company_register_number' => "nullable|max:255",
                'company_country_dialcode' => "required",
                'company_phone' => "nullable|numeric|digits_between:9,12",
                'company_status' => 'required_if:user_type_id,1',
                'company_email' => "nullable|email|max:100",
                'company_website' => "nullable|max:255",
                'company_address' => 'nullable|max:255',
                'company_address2' => 'nullable|max:255',
                'company_postcode' => 'nullable|max:45',
                'company_state_id' => 'nullable',
                'company_city_name' => 'nullable|max:100',
                'company_latitude' => 'nullable',
                'company_longitude' => 'nullable',
                'company_description' => 'nullable',
                'business_hours' =>  [
                    'nullable',
                    'array'
                ],
                'business_hours.*.start_time' => 'required',
                'business_hours.*.end_time' => 'required',
                'sector_id' => 'required',
                'car_brand_id' => 'required_if:sector_id,1',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'company_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'company_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'promotion_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'catalog_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'general_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'pricelist_media' => 'nullable|mimes:pdf|max:51200',
                'brochure_media' => 'nullable|mimes:pdf|max:51200',
                'pricelist_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'brochure_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ])->setAttributeNames([
                //company detail
                'company_name' => 'Company Name',
                'company_register_number' => 'Company Registration Number',
                'company_country_dialcode' => 'Company Country Code',
                'company_phone' => 'Company Phone',
                'company_status' => 'Company Status',
                'company_email' => 'Company Email',
                'company_website' => 'Company Website',
                'company_type_id' => 'Company Type',
                'company_address' => 'Company Address',
                'company_postcode' => 'Company Postcode',
                'company_state_id' => 'Company State',
                'company_city_id' => 'Company City',
                'company_latitude' => 'Company Latitude',
                'company_longitude' => 'company Longitude',
                'company_description' => 'Company Description',
                'business_hours' => 'Business Hours',
                'business_hours.*.start_time' => 'Business Hours Start Time',
                'business_hours.*.end_time' => 'Business Hours End Time',
                'car_brand_id' => 'Car Brand',
                'sector_id' => 'Sector',
                'company_thumbnail' => 'Company Thumbnail',
                'company_logo' => 'Company Logo',
                'company_banner' => 'Company Banner',
                'promotion_thumbnail' => 'Promotion Thumbnail',
                'company_thumbnail' => 'Company Thumbnail',
                'catalog thumbnail' => 'Catalog Thumbnail',
                'general_thumbnail' => 'General Thumbnail',
                'pricelist_media' => 'Pricelist Media',
                'brochure_media' => 'Brochure Media',
                'pricelist_thumbnail' => 'Pricelist Thumbnail',
                'brochure_thumbnail' => 'Brochure Thumbnail',

            ]);
            if (!$validator->fails()) {
                $company->update([
                    'company_name' => $request->input('company_name'),
                    'company_register_number' => $request->input('company_register_number'),
                    'dialcode_id' => $company_dialcode_id ?? 130,
                    'company_phone' => $company_phone ?? '',
                    'company_status' => $request->input('company_status') ?? $company->company_status,
                    'company_email' => $request->input('company_email'),
                    'company_website' => $request->input('company_website'),
                    'company_address' => $request->input('company_address'),
                    'company_address2' => @$request->input('company_address2'),
                    'company_postcode' => $request->input('company_postcode'),
                    'company_state_id' => $request->input('company_state_id'),
                    'company_city_name' => $request->input('company_city_name'),
                    'company_country_id' => $request->input('company_country_id'),
                    'company_description' => $request->input('company_description'),
                    'sector_id' => $request->input('sector_id'),
                    'car_brand_id' => $request->input('car_brand_id'),
                ]);
                //Company Media File
                if ($request->hasFile('company_thumbnail')) {
                    $company->clearMediaCollection('company_thumbnail');
                    $media = (new MediaRepository)->add_media_with_convert_filename($company, 'company_thumbnail', $request->file('company_thumbnail'));
                }
                if ($request->hasFile('company_logo')) {
                    $company->clearMediaCollection('company_logo');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'company_logo', $request->file('company_logo'));
                }
                if ($request->hasFile('company_banner')) {
                    $company->clearMediaCollection('company_banner');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'company_banner', $request->file('company_banner'));
                }
                if ($request->hasFile('promotion_thumbnail')) {
                    $company->clearMediaCollection('promotion_thumbnail');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'promotion_thumbnail', $request->file('promotion_thumbnail'));
                }
                if ($request->hasFile('catalog_thumbnail')) {
                    $company->clearMediaCollection('catalog_thumbnail');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'catalog_thumbnail', $request->file('catalog_thumbnail'));
                }
                if ($request->hasFile('general_thumbnail')) {
                    $company->clearMediaCollection('general_thumbnail');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'general_thumbnail', $request->file('general_thumbnail'));
                }
                if ($request->hasFile('pricelist_media')) {
                    $company->clearMediaCollection('pricelist_media');
                    (new MediaRepository)->add_media($company, 'pricelist_media', $request->file('pricelist_media'));
                }
                if ($request->hasFile('brochure_media')) {
                    $company->clearMediaCollection('brochure_media');
                    (new MediaRepository)->add_media($company, 'brochure_media', $request->file('brochure_media'));
                }

                if ($request->hasFile('brochure_thumbnail')) {
                    $company->clearMediaCollection('brochure_thumbnail');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'brochure_thumbnail', $request->file('brochure_thumbnail'));
                }

                if ($request->hasFile('pricelist_thumbnail')) {
                    $company->clearMediaCollection('pricelist_thumbnail');
                    (new MediaRepository)->add_media_with_convert_filename($company, 'pricelist_thumbnail', $request->file('pricelist_thumbnail'));
                }

                $this->company_log($company->company_id, $owner->user_id, 'update');
                Session::flash('success_msg', 'Successfully updated company.');
                if (Auth::user()->user_type->user_type_slug == 'admin') {
                    return redirect()->route('company_listing');
                } else {
                    return redirect()->route('company_profile');
                }
            }

            $post = (object) $request->all();
        }
        return view('company/edit_form', [
            'title' => 'Edit',
            'submit' => $submit,
            'is_edit' => true,
            'state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'sector_sel' => ['' => 'Please select sector'] + SettingSector::get_sel(),
            'user_gender_sel' => array('' => 'Please select gender', 'Male' => 'Male', 'Female' => 'Female'),
            'car_brand_dropdown' => ['' => 'Please select car brand'] + CarBrand::car_brand_dropdown(),
            'user_role_sel' => UserRole::get_sel(),
            'company_status_sel' => ['active' => 'Active', 'pending' => 'Pending'],
            'country_dropdown' => ['' => 'Please select country'] + SettingCountry::country_dropdown(),
            'company' => $company,
            'action' => 'edit',
            'post' => $post,
            'countries' => SettingDialcode::get_sel(),
            'country_abb' => $countryAbb,
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $owner = Auth::user();
        $company = Company::find($request->input('company_id'));
        $company_user = CompanyUser::where('company_id', $company->company_id);
        if (!$company) {
            Session::flash('fail_msg', 'Error, Please try again later..');
            return redirect('/');
        }
        $validator = Validator::make($request->all(), [
            'company_remark' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('fail_msg', 'Delete Unsuccessfully, Please fill in the company_remark');
            return redirect()->route('company_listing');;
        } else {
            $company->update([
                'company_remark' => $request->input('company_remark'),
                'company_owner_id' => null,
                'is_deleted' => 1
            ]);
            $company_user->delete();

            $this->company_log($company->company_id, $owner->user_id, 'delete');

            Session::flash('success_msg', "Successfully delete company.");
            return redirect()->route('company_listing');
        }
    }

    public function status(Request $request)
    {
        $action = $request->input('action');
        $company_id = $request->input('company_id');
        $company = Company::find($company_id);

        if ($action == 'suspend') {
            $validator = Validator::make($request->all(), [
                'company_remark' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                Session::flash('fail_msg', 'Suspend Unsuccessfully, Please fill in the company_remark');
                return redirect()->route('company_listing');;
            } else {
                $company->update([
                    'company_remark' => $request->input('company_remark'),
                    'company_status' =>  $action
                ]);
                Session::flash('success_msg', "Successfully {$action} {$company->company_name}.");
                return redirect()->route('company_listing');
            }
        } elseif ($action == 'activate') {
            $company->update([
                'company_status' => 'active',
                'company_remark' => '',
            ]);
            Session::flash('success_msg', "Successfully {$action} {$company->company_name}.");
            return redirect()->route('company_listing');
        }
    }
    public function remove_upload(Request $request)
    {
        $company_id = $request->input('company_id');
        $file_name = $request->input('file_name');

        $company = Company::find($company_id);
        if ($company->hasMedia($file_name)) {
            $company->getFirstMedia($file_name)->delete();
        }

        return redirect()->route('company_edit', $company_id);
    }


    public function view($company_id)
    {
        $company = Company::findOrFail($company_id);

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }


        return view('company_view/gallery', [
            'submit' => route('company_listing'),
            'submit_new' => route('company_add'),
            'title' => 'Add',
            'gallery_add_image' => route('gallery_add_image'),
            'days_name' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'company' => $company,
        ]);
    }

    public function view_about_us(Request $request, $company_id)
    {
        $post = $company = Company::find_company_by_id($company_id);

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }

        $validator = null;
        $post = clone $company;
        $company->company_social_media = json_decode($company->company_social_media, true);
        $post->company_phone = substr($company->company_phone, 2);

        if ($request->isMethod('post')) {

            $day = array_values($request->input('operation_days') ?? []);
            $data = $this->convert_business_hours_to_json($request);
            $coordinates = $this->convert_map_coordinates_to_json($request->input('lat'), $request->input('lng'));

            // $social_media = json_encode($request->input('social_media'));

            $social_medias = $request->input('social_media');
            if ($social_medias) {
                foreach ($social_medias as $key => $url) {
                    $new = preg_replace("(^https?://)", "", $url);
                    $social_medias[$key] = $new;
                }
            }

            $validator = Validator::make($request->all(), [
                'company_phone' => "required|numeric|phone_number|digits_between:8,12|unique:tbl_company,company_phone,{$company_id},company_id|regex:/([0-9])[0-9]{7}/",
                'company_email' => "required|email|unique:tbl_company,company_email,{$company_id},company_id",
                'company_website' => "nullable|unique:tbl_company,company_website,{$company_id},company_id",
                'company_address' => 'required|max:150',
                'company_postcode' => 'required|numeric',
                'company_state_id' => 'required',
                'company_city_id' => 'required',
                'company_description' => 'nullable',
                'social_media.*' => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'post_medias' => 'image|mimes:jpeg,png,jpg|max:20480',
            ])->setAttributeNames([
                'company_phone' => "Phone",
                'company_email' => "Email",
                'company_website' => "Website",
                'company_address' => "Address",
                'company_postcode' => "Postcode",
                'company_state_id' => "State",
                'company_city_id' => "City",
                'company_description' => 'Description',
                'social_media.Facebook' => 'Social Media Facebook.',
                'social_media.Instagram' => 'Social Media Instagram',
                'social_media.Twitter' => 'Social Media Twitter',
                'social_media.Pinterest' => 'Social Media Pinterest',
                'social_media.Tumblr' => 'Social Media Tumblr :attribute',
                'post_medias' => 'Banner',
            ]);

            if (!$validator->fails()) {
                $company->update([
                    'company_phone' => '60' . $request->input('company_phone'),
                    'company_email' => $request->input('company_email'),
                    'company_website' => $request->input('company_website'),
                    'company_address' => $request->input('company_address'),
                    'company_postcode' => $request->input('company_postcode'),
                    'company_state_id' => $request->input('company_state_id'),
                    'company_city_id' => $request->input('company_city_id'),
                    'company_state' => $request->input('company_state_id') ? SettingState::where('setting_state_id', $request->input('company_state_id'))->first()->setting_state_name : '',
                    'company_city' => $request->input('company_city_id') ? SettingCity::where('setting_city_id', $request->input('company_city_id'))->first()->setting_city_name : '',
                    'company_description' => $request->input('company_description') ?? '',
                    'company_business_hours' => $data,
                    'company_map_coordinates' => $coordinates,
                    'company_social_media' => $social_medias,
                ]);

                if ($company->company_completed_status) {
                } elseif ($day && $company->company_description && $company->hasMedia('user_profile_photo_crop') && $company->hasMedia('company_media_banner')) {
                    $company->update([
                        'company_completed_status' => 1
                    ]);
                }
                Session::flash('success_msg', 'Successfully updated dealer.');
                return redirect()->back();
            };
            $post = (object) $request->all();
            $post->company_id = $company_id;
            $post->city = $company->city;
            $post->state = $company->state;
            $post->is_error = true;
            // $post->company_social_media = $company->company_social_media;
        }

        return view('company_view/about_us', [
            'submit' => route('company_view_about_us', $company_id),
            'submit_new' => route('company_add'),
            'active' => 'about_us',
            'title' => 'Add',
            'post' => $post,
            'company_business_hours' => json_decode($company->company_business_hours, true),
            'business_hours_sel' => Company::get_business_hours_list(0, 86400, 60 * 15, 'h:i a'),
            'company_map_coordinates' => json_decode($company->company_map_coordinates),
            'state_sel' => ['' => 'Please select state'] + SettingState::get_sel(),
            'company_city_sel' => @$company->company_state_id ? ['' => 'Please select city'] + SettingCity::get_sel($company->company_state_id) : ['' => 'Please select city'],
            'gallery_add_banner' => route('gallery_add_banner'),
            'days_name' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'media_social_list' => Company::get_media_social_list(),
            'company' => $company,
        ])->withErrors($validator);
    }

    public function view_our_team($company_id)
    {
        $company = Company::findOrFail($company_id);
        $company->company_social_media = json_decode($company->company_social_media, true);
        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }


        return view('company_view/our_team', [
            'submit' => route('company_listing'),
            'add_new_team' => route('company_add_team', $company_id),
            'submit_new' => route('company_add'),
            'active' => 'our_team',
            'title' => 'Add',
            'gallery_add_image' => route('gallery_add_image'),
            'days_name' => Company::get_all_days_name(),
            'company' => $company,
        ]);
    }

    public function view_gallery($company_id)
    {
        $company = Company::findOrFail($company_id);
        $company->company_social_media = json_decode($company->company_social_media, true);
        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }

        return view('company_view/gallery', [
            'submit' => route('company_listing'),
            'submit_new' => route('company_add'),
            'active' => 'gallery',
            'title' => 'Add',
            'gallery_add_image' => route('gallery_add_image'),
            'gallery_add_banner' => route('gallery_add_banner'),
            'days_name' => Company::get_all_days_name(),
            'company' => $company,
            'gallery_images' => CompanyGallery::get_by_company_and_type($company_id, 'image'),
        ]);
    }

    public function view_video($company_id)
    {

        $company = Company::findOrFail($company_id);
        $company->company_social_media = json_decode($company->company_social_media, true);
        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }

        return view('company_view/video', [
            'submit' => '',
            'submit_new' => '',
            'active' => 'videos',
            'title' => 'Add',
            'add_video' => route('add_video'),
            'days_name' => Company::get_all_days_name(),
            'company' => $company,
            'gallery_videos' => CompanyGallery::get_by_company_and_type($company_id, 'video'),
            // 'company_gallery_type' => CustomMedia::get_company_gallery_type($company_id),
        ]);
    }

    public function gallery_add_image(Request $request)
    {
        $validator = null;
        $company = Company::findOrFail($request->input('company_id'));

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'post_medias.*' => 'image|mimes:jpeg,png,jpg|max:20480',
        ])->setAttributeNames([
            'post_medias.*' => 'Gallery Images',
        ]);

        if (!$validator->fails()) {
            if ($request->file('post_medias')) {
                foreach ($request->file('post_medias') as $key => $post_media) {
                    Image::load($post_media)->optimize()->save();
                    $image = $company->addMedia($post_media)->toMediaCollection('company_media_gallery');

                    CompanyGallery::create([
                        'company_gallery_priority' => '0',
                        'company_gallery_status' => '0',
                        'company_gallery_created' => now(),
                        'company_gallery_updated' => now(),
                        'company_gallery_title' => $image->file_name,
                        'company_id' => $company->company_id,
                        'media_id' => $image->id,
                        'company_gallery_type' => 'image'
                    ]);
                }
                Session::flash('success_msg', 'Successfully added gallery image.');
            }
            return redirect()->back();
        };
        return redirect()->back()->withErrors($validator);
    }

    public function add_video(Request $request)
    {
        $validator = null;
        $company = Company::findOrFail($request->input('company_id'));

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }
        $validator = Validator::make($request->all(), [
            'post_medias.*' => 'nullable|mimetypes:video/x-flv,video/mp4,video/mp2t,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/x-matroska|max:51200',
            'video_url' => [
                'nullable',
                function ($shortUrlRegex, $longUrlRegex, $fail) use ($request) {
                    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
                    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
                    if (preg_match($longUrlRegex, $request->input('video_url'), $matches)) {
                        $youtube_id = $matches[count($matches) - 1];
                        return 'https://www.youtube.com/embed/' . $youtube_id;
                    }

                    if (preg_match($shortUrlRegex, $request->input('video_url'), $matches)) {
                        $youtube_id = $matches[count($matches) - 1];
                        return 'https://www.youtube.com/embed/' . $youtube_id;
                    } else {
                        return $fail(__('This is not YouTube url link. Please enter a valid YouTube url link.'));
                    }
                }
            ]
        ], [
            'post_medias.*.max' => 'The Videos size may not be greater than 50MB.',
            'post_medias.*.mimetypes' => 'The Videos must be a file of type Mp4, Flv, 3gp, Quicktime, Avi, Wmv, Webm, Mkv.'
        ])->setAttributeNames([
            'post_medias.*' => 'Videos',
            'video_url' => 'Video URL',
        ]);
        if (!$validator->fails()) {
            if ($request->file('post_medias')) {
                foreach ($request->file('post_medias') as $key => $post_media) {
                    $video = $company->addMedia($post_media)->withCustomProperties(['convert_progress' => 'pending'])->toMediaCollection('company_media_gallery');
                    ConvertVideo::dispatch($video);

                    CompanyGallery::create([
                        'company_gallery_priority' => $key + 1,
                        'company_gallery_status' => '0',
                        'company_gallery_created' => now(),
                        'company_gallery_updated' => now(),
                        'company_gallery_title' => $video->file_name,
                        'company_gallery_type' => 'video',
                        'company_id' => $company->company_id,
                        'media_id' => $video->id,
                        'video_url' => ''
                    ]);
                }
                Session::flash('success_msg', 'Successfully added video');
            }
            if ($request->input('video_url')) {
                CompanyGallery::create([
                    'company_gallery_priority' => '0',
                    'company_gallery_status' => '0',
                    'company_gallery_created' => now(),
                    'company_gallery_updated' => now(),
                    'company_gallery_title' => $request->input('video_url'),
                    'company_gallery_type' => 'video',
                    'company_id' => $company->company_id,
                    'media_id' => '0',
                    'video_url' => $request->input('video_url')
                ]);
            }
            Session::flash('success_msg', 'Successfully added video.');
            return redirect()->back();
        }
        return redirect()->back()->withErrors($validator);
    }

    public function delete_video($media_id)
    {
        // $company = Company::findOrFail($company_id);
        // $companygallery = CompanyGallery::get_companygallery_by_media_id($media_id);

        // if (!$company) {
        //     Session::flash('fail_msg', 'Invalid Company, Please try again later..');
        //     return redirect('/');
        // }


        $companygallery = CompanyGallery::get_by_company_gallery_id($media_id);
        // dd($companygallery);
        if (!$companygallery) {
            Session::flash('fail_msg', 'Invalid Video, Please try again later..');
            return redirect('/');
        }

        // $company->deleteMedia($media_id);
        $companygallery->delete();

        Session::flash('success_msg', 'Successfully deleted gallery video.');
        return redirect()->back();
    }

    public function gallery_add_banner(Request $request)
    {
        $validator = null;
        $company = Company::findOrFail($request->input('company_id'));

        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'post_medias' => 'image|mimes:jpeg,png,jpg|max:20480',
        ])->setAttributeNames([
            'post_medias' => 'Banner',
        ]);

        if (!$validator->fails()) {
            if ($request->file('post_medias')) {
                $company->addMultipleMediaFromRequest(['post_medias'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('company_media_banner');
                    });
                Session::flash('success_msg', 'Successfully added banner.');
            }
            return redirect()->back();
        };

        return redirect()->back()->withErrors($validator);
    }

    public function delete_company_gallery_image($media_id)
    {
        // $company = Company::findOrFail($company_id);
        // $companygallery = CompanyGallery::get_companygallery_by_media_id($media_id);

        // if (!$company) {
        //     Session::flash('fail_msg', 'Invalid Company, Please try again later..');
        //     return redirect('/');
        // }

        // if (!$companygallery) {
        //     Session::flash('fail_msg', 'Invalid Gallery Photo, Please try again later..');
        //     return redirect('/');
        // }

        // $company->deleteMedia($media_id);
        // $companygallery->delete();

        // Session::flash('success_msg', 'Successfully deleted gallery image.');
        // return redirect()->back();
        // dd($media_id);

        $companygallery = CompanyGallery::get_by_company_gallery_id($media_id);
        if (!$companygallery) {
            Session::flash('fail_msg', 'Invalid Gallery Photo, Please try again later..');
            return redirect('/');
        }
        $companygallery->delete();

        Session::flash('success_msg', 'Successfully deleted gallery image.');
        return redirect()->back();
    }

    public function company_edit_business_hours(Request $request)
    {
        $all_days_name = Company::get_all_days_name();
        $company = Company::find($request->company_id);

        $data = collect();

        foreach ($all_days_name as $key => $day) {
            $operation_status = $request->input('operation_' . $day);
            $data->put(
                $day,
                [
                    'operation' => $operation_status,
                    'operation_start' => $request->input('start_' . $day),
                    'operation_end' => $request->input('end_' . $day),
                ]
            );
        }
        $collection = collect([
            'data' => $data
        ]);

        $company->update([
            'company_business_hours' => $collection->toJson()
        ]);

        return redirect()->back();
    }

    public function convert_business_hours_to_json($request)
    {
        $data = collect();
        $operation_days = $request->input('operation_days');
        $all_days_name = Company::get_all_days_name();

        foreach ($all_days_name as $key => $day) {
            $operation_status = 'closed';
            if (@$operation_days[$day]) {
                $operation_status = 'open';
            }
            $data->put(
                $day,
                [
                    'operation' => $operation_status,
                    'operation_start' => $operation_status == 'open' ? $request->input('start_' . $day) : null,
                    'operation_end' => $operation_status == 'open' ? $request->input('end_' . $day) : null
                ]
            );
        }
        $collection = collect([
            'data' => $data
        ]);

        return $collection->toJson();
    }

    public function convert_map_coordinates_to_json($lat, $lng)
    {
        $data = collect([
            'lat' => $lat,
            'lng' => $lng
        ]);

        $collection = collect([
            'data' => $data
        ]);

        return $collection->toJson();
    }

    public function ajax_get_company_branch(Request $request)
    {
        $company_id = $request->input('company_id');

        $branchNames = CompanyBranch::where('company_id', $company_id)
            ->where('is_deleted', 0)
            ->pluck('company_branch_name', 'company_branch_id')
            ->toArray();
        if ($branchNames) {
            $branchNames = ["Please select company branch"] + $branchNames;
        }
        if (empty($branchNames)) {
            $branchNames = ["No Company Branch"];
        }


        return response()->json($branchNames);
    }


    public function ajax_upload_user_profile_photo(Request $request)
    {
        $data = [];
        $status = false;
        $msg = '';

        $user = User::find($request->input('user_id'));

        $filename = $user->user_id . '_' . time() . '.' . $request->file('user_profile_photo_crop')->clientExtension();
        $image = $user->addMedia($request->file('user_profile_photo_crop'))
            ->usingFileName($filename)
            ->toMediaCollection('user_profile_photo_crop');

        $filename_original = $user->user_id . '_' . time() . '.' . $request->file('user_profile_photo_original')->getClientOriginalExtension();
        $image_original = $user->addMedia($request->file('user_profile_photo_original'))
            ->usingFileName($filename_original)
            ->toMediaCollection('user_profile_photo');

        if ($image) {
            $status = true;

            $data = [
                'user_profile_photo_crop' => $image->getUrl(),
                'user_profile_photo' => $image_original->getUrl()
            ];
        }

        return response()->json(['data' => $data, 'status' => $status]);
    }

    public function ajax_upload_banner_cover_photo(Request $request)
    {
        $data = [];
        $status = false;

        $company = Company::find($request->input('company_id'));

        $company_banner_original = $request->file('company_banner_original');

        list($width, $height, $type, $attr) = getimagesize($company_banner_original);

        // $new_width = 1200;
        $new_width = 1830;
        $new_height = $height * $new_width / $width;

        // $banner_height = 400;
        // $banner_width = 1200;
        $banner_height = 688;
        $banner_width = 1830;
        $top = abs($request->input('top')) / 100 * $banner_height;

        $new_img_reso = [
            'width' => $new_width,
            'height' => $new_height
        ];

        $crop = [
            'width' =>  $banner_width, // container width
            'height' => $banner_height, // container height
            'x' => 0,
            'y' => $top
        ];

        $filename = $company->company_id . '_' . time() . '.' . $request->file('company_banner_original')->getClientOriginalExtension();

        $banner_image = $request->file('company_banner_original');
        Image::load($banner_image)->optimize()->save();

        $image = $company->addMedia($banner_image)
            ->usingFileName($filename)
            ->withCustomProperties([
                'crop' => $crop,
                'new_img_reso' => $new_img_reso,
                'height' => $request->input('top'),
            ])
            ->toMediaCollection('company_media_banner');

        if ($image) {
            $data = $image->getUrl('company_media_banner_crop');
            $status = true;
        }

        return response()->json(['data' => $data, 'status' => $status]);
    }

    public function assign_admin(Request $request, $company_id)
    {
        $validator = null;

        $post = $company = Company::findOrFail($company_id);
        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect('/');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ])->setAttributeNames([
                'user_id' => 'Admin Name',
            ]);

            if (!$validator->fails()) {

                $user = User::query()
                    ->where('user_id', $request->input('user_id'))->first();

                if (!$company->admin) {
                    $company_admin = 'Assign ' . $user->user_fullname . ' (#' . sprintf("%05d", $user->user_id) . ') as new admin.';
                } else {
                    $company_admin = 'Change admin from ' . $company->admin->user_fullname . ' (#' . sprintf("%05d", $company->admin->user_id) . ') to ' . $user->user_fullname . ' (#' . sprintf("%05d", $user->user_id) . ').';
                }

                $company->update([
                    'admin_user_id' =>   $request->input('user_id'),
                ]);

                CompanyAssignLog::create([
                    'company_assign_log_description' => $company_admin,
                    'admin_user_id' => Auth::id() ?? 0,
                    'company_id' => $company_id,
                ]);

                Session::flash('success_msg', 'Successfully assign admin.');
                return redirect()->route('company_listing');
            };
            $post = (object) $request->all();
        }

        return view('company/assign_admin', [
            'submit' => route('assign_admin', $company_id),
            'active' => null,
            'admin_sel' => User::get_all_user_sel(),
            'title' => 'Assign Admin',
            'company' => $company,
            'post' => $post,
        ])->withErrors($validator);
    }

    public function edit_company_credit_expiry(Request $request, $company_id)
    {
        $company = Company::find($company_id);
        if (!$company) {
            Session::flash('fail_msg', 'Invalid Company, Please try again later..');
            return redirect()->route('company_listing');
        }
        $validator = null;
        $post = clone $company;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'days' => 'required|integer',
            ], [
                'days.integer' => 'The Days must be a number'
            ])->setAttributeNames([
                'days' => 'Days',
            ]);

            if (!$validator->fails()) {
                $old = $company->company_credit_expired;
                $d = $company->company_credit_expired < now() ? now() : @$company->company_credit_expired;
                $date = new DateTime($d);
                $date->modify('+' . $request->input('days') . ' days');

                $company->update([
                    'company_credit_expired' => $date->format('Y-m-d')
                ]);

                CompanyLog::create([
                    'company_id' => $company->company_id,
                    'company_subscription_id' => $company->company_subscription_id,
                    'company_log_action' => 'Edit company credit expired',
                    'company_log_description' => 'Edit company credit expired from ' . $old . ' to ' . $company->company_credit_expired . ' (' . $request->input('days') . ' days) by ' . Auth::user()->user_fullname,
                ]);

                return redirect()->route('company_listing');
            }

            $post = (object) $request->all();
        }

        return view('company.credit_expiry', [
            'title' => 'Edit',
            'submit' => route('company_edit_credit_expiry', $company_id),
            'post' => $post,
            'company' => $company
        ])->withErrors($validator);
    }

    public function ajax_save_selected_company_id(Request $request): JsonResponse
    {
        $status =  false;
        $data = [];

        if ($request->has('action')) {

            $session_key = 'selected_company_id';

            switch ($request->input('action')) {
                case "update":
                    if ($request->has('checked') && $request->has('company_id')) {
                        $company_id = $request->input('company_id');
                        $checked = $request->input('checked') == "true";

                        $selected_company_id = session($session_key, []);

                        if ($checked) {
                            $selected_company_id = array_unique(array_merge($selected_company_id, $company_id), SORT_REGULAR);
                        } else {
                            $selected_company_id = array_diff($selected_company_id, $company_id);
                        }

                        session()->put($session_key, $selected_company_id);

                        $status =  true;
                        $data = [
                            'total_selected' =>  count($selected_company_id)
                        ];
                    }
                    break;

                case "reset":
                    session()->forget($session_key);
                    $status =  true;
                    $data = [
                        'total_selected' =>  0
                    ];
                    break;
            }
        }

        return response()->json($result = [
            'status' => $status,
            'data' => $data
        ]);
    }

    public function ajax_get_selected_company_modal($id = null)
    {
        if ($id) {
            $records = Company::where('company_id', $id)->get();
        } else {
            $records = Company::whereIn('company_id', session('selected_company_id', []))->get();
        }

        return view('company.selected_company', [
            'records' => $records,
            'admin_sel' => User::get_all_user_sel(),
            'title' => 'Assign Admin',
        ]);
    }

    public function ajax_submit_assign_admin(Request $request)
    {

        $status = false;
        $data = [];

        $validator = Validator::make(
            $request->all(),
            [
                'company_id' => [
                    'required',
                    'array',
                    Rule::exists(Company::class, 'company_id')
                        ->where('is_deleted', 0)
                ],
                'user_id' => [
                    'required',
                    Rule::exists(User::class, 'user_id')
                        ->where('user_type_id', 1)
                        ->where('is_deleted', 0)
                ]
            ]
        )->setAttributeNames([
            'company_id' => 'Company',
            'user_id' => 'Admin Name',
        ]);

        if (!$validator->fails()) {
            $company_collect = Company::query()
                ->with([
                    'admin',
                ])
                ->whereIn('company_id', $request->input('company_id'))
                ->get();

            $new_admin = User::query()
                ->where('user_id', '=', $request->input('user_id'))
                ->first();

            foreach ($company_collect as $company) {
                if ($company->admin_user_id != $new_admin->user_id) {
                    $company->update([
                        'admin_user_id' => $new_admin->user_id,
                    ]);

                    if ($company->admin) {
                        $company_admin = 'Change admin from ' . $company->admin->user_fullname . ' (#' . sprintf("%05d", $company->admin->user_id) . ') to ' . $new_admin->user_fullname . ' (#' . sprintf("%05d", $new_admin->user_id) . ').';
                    } else {
                        $company_admin = 'Assign ' . $new_admin->user_fullname . ' (#' . sprintf("%05d", $new_admin->user_id) . ') as new admin.';
                    }

                    CompanyAssignLog::query()
                        ->create([
                            'company_assign_log_description' => $company_admin,
                            'admin_user_id' => Auth::id() ?? 0,
                            'company_id' => $company->company_id,
                        ]);
                }
            }

            session()->forget('selected_company_id');
            Session::flash('success_msg', "Successfully assign admin.");
            $status = true;
        } else {
            $data = ['error' => $validator->errors()];
        }

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }

    public function ajax_get_company_state_by_name(Request $request)
    {
        $state = [];
        $state_name = $request->input('state_name');
        $state = SettingState::where('state_name', $state_name)->first();

        return $state;
    }

    public function ajax_get_company_country_by_name(Request $request)
    {
        $country = [];
        $country_name = $request->input('country_name');
        $country = SettingCountry::where('country_name', $country_name)->first();

        return $country;
    }
    private function company_log(int $company_id = null, int $user_id = null, string $company_log_action = null)
    {
        CompanyLog::create([
            'company_id' => $company_id,
            'user_id' => $user_id,
            'company_log_action' => $company_log_action
        ]);
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
    public function ajax_upload_company_note_image(Request $request)
    {
        $status = false;
        $temp = false;
        $validator = null;
        $url = null;
        $message = null;
        $id = null;

        $data = $request->toArray();
        $company_id = $data["id"];
        $image = $data["img"];

        $validator = Validator::make($data, [
            'img' => "image|mimes:jpeg,png,jpg|max:20480",
        ])->setAttributeNames([
            'img' => "Image",
        ]);

        if (!$validator->fails()) {
            $status = true;


            if ($company_id > 0) {
                $company = Company::find($company_id);
                $img = (new MediaRepository)->add_media_with_convert_filename($company, 'company_description_media', $image);
            } else {
                $temp = MediaTemp::find(1);
                $img = (new MediaRepository)->add_media_with_convert_filename($temp, 'company_description_media', $image);
                $temp = true;
            }
            $url = $img->getFullUrl();
            $id = $img->id;
            $file_name = $img->file_name;
        }

        $message = 'Only .jpeg, .png and .jpg file extensions are allowed with a max size of 20 MB';

        $data = [
            'url' => $url,
            'id' => $id,
            'temp' => $temp,
            'file_name' => $file_name,
        ];

        return response()->json(['status' => $status, 'data' => $data, 'message' => $message]);
    }
}
