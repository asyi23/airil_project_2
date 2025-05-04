@extends('layouts.master')

@section('title')
    {{ $title }} User
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <style>
        .combined-input {
            display: flex;
            align-items: center;
        }

        .combined-left {
            flex: 1.5;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            width: 250px;
        }

        .combined-right {
            flex: 4;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .gap {
            width: 10px;
        }

        .custom-dropdown-container .select2-container {
            width: 100% !important;
        }

        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #img {
            margin: auto;
            padding-top: 100px;
            padding-bottom: 100px;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            max-width: 80%;
            animation-name: zoom;
            animation-duration: 0.5s;
        }

        #backgroundImg {
            margin: auto;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            width: 300px;
            animation-name: zoom;
            animation-duration: 0.5s;
        }

        #profileImg {
            margin: auto;
            padding-top: 100px;
            padding-bottom: 100px;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            max-width: 80%;
            animation-name: zoom;
            animation-duration: 0.5s;
        }

        @keyframes zoom {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .closebtn {
            position: absolute;
            top: 5px;
            right: 35px;
            color: white !important;
            font-size: 50px !important;
            font-weight: bold !important;
            cursor: pointer;
        }

        .closebtn:hover,
        .closebtn:focus {
            color: #cccccc !important;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            #img {
                width: 100%;
            }

            #backgroundImg {
                width: 100%;
            }

            #profileImg {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }} User</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">User</a>
                        </li>
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @enderror
    <div class="row">
        <div class="col-xl-9 col-lg-12 col-md-12">
            <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Type</h4>
                        <div class="row">
                            @if (!empty($company_name))
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company_id">Company <span class="text-danger">*</span></label>
                                        @foreach ($company_sel as $key => $val)
                                            @if ($key == $company_id)
                                                @php
                                                    $desired_company = $val;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        <input name="company_id" class="form-control " id="company_id" value="{{ $desired_company }}"readonly>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group custom-dropdown-container">
                                        <label for="company_id">Company<span class="text-danger">*</span></label>
                                        <select name="company_id" class="form-control select2" id="company_id">
                                            @foreach ($company_sel as $key => $val)
                                                <option value="{{ $key }}"
                                                    {{ $key == @$post->company_id ? 'selected' : '' }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="user_role_id">User Role</label>
                                    <select name="user_role_id" class="form-control select2" id="user_role_id">
                                        @foreach ($user_role as $key => $val)
                                            <option value="{{ $key }}"
                                                @if ($key == @$post->user_role_id) selected @elseif ($key === 4) selected @endif>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->roles->value('id')== 4)
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="company_branch_id">Company Branch</label><span class="text-danger">*</span>
                                        @foreach ($company_branch_id as $key => $val)
                                            @if ($key == $branch)
                                                @php
                                                    $desired_branch = $val;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        <input name="company_branch_id" class="form-control " id="company_branch_id" value="{{ $desired_branch }}"readonly>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="company_branch_id">Company Branch</label><span class="text-danger">*</span>
                                    <select name="company_branch_id" class="form-control select2"
                                        id="company_branch_id">
                                        @foreach ($company_branch_id as $key => $val)
                                            <option value="{{ $key }}"
                                                {{ $key == @$post->company_branch_id ? 'selected' : '' }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="custom-control custom-checkbox" id="new_branch">
                                    <input class="custom-control-input" type="checkbox" name="branchCheck"
                                        id="customCheckbox1" value="option1"
                                        @if ($branchCheck == 'checked') checked @endif>
                                    <label for="customCheckbox1" class="custom-control-label">Create New Branch</label>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- new branch detail if click --}}
                <div class="card" id="branchDetailsContainer" style="display: none;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">New Branch Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="branch_name">Branch Name<span class="text-danger">*</span></label>
                                    <input name="branch_name" type="text" maxlength="100" class="form-control"
                                        value="{{ @$post->branch_name }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="branch_register_number">Branch Registration Number</label>
                                    <input name="branch_register_number" type="text" maxlength="100"
                                        class="form-control" value="{{ @$post->branch_register_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="combined_input">Branch Mobile No.</label>
                                    <div class="combined-input">
                                        <select id="branch_country_dialcode" name="branch_country_dialcode"
                                            class="form-control combined-left select2" style="width: 122px;">
                                            @foreach ($countries as $countryAbb => $countryData)
                                                <option value="{{ $countryAbb }}"
                                                    data-dialcode="{{ $countryData['dialcode'] }}"
                                                    @if ($countryAbb == @$post->branch_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
                                                    {{ $countryData['country_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="gap"></div>
                                        <input id="branch_input-mask" oninput="validateInput(this)"
                                            name="branch_mobile"
                                            class="form-control input-mask text-left combined-right" maxlength="45"
                                            data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''"
                                            im-insert="true" style="text-align: right; "
                                            value="{{ @$post->branch_mobile }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="branch_status">Branch Status<span class="text-danger">*</span></label>
                                    {!! Form::select('branch_status', $company_status_sel, $post->branch_status ?? 'active', [
                                        'class' => 'form-control select2',
                                        'id' => 'branch_status',
                                        // 'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end of new branch detail if click --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Access</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_email">Email<span class="text-danger">*</span></label>
                                    <input name="user_email" type="email" maxlength="90" class="form-control"
                                        value="{{ @$post->user_email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password<span class="text-danger">*</span><span
                                            class="bx bxs-info-circle info-tooltip" data-toggle="tooltip"
                                            data-placement="top" title="Minimum 8 character"></span></label>
                                    <div id="password" class="input-group">
                                        <input name="password" type="password" class="form-control"
                                            id="password-input" value="">
                                        <div class="input-group-append">
                                            <span class="input-group-text  show-hide-password">
                                                <i class="bx bxs-show font-size-15"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password<span
                                            class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Minimum 8 character"></span>
                                    </label>
                                    <div id="confirm_password" class="input-group">
                                        <input name="confirm_password" type="password" class="form-control"
                                            id="confirm-password-input" value="">
                                        <div class="input-group-append">
                                            <span class="input-group-text  show-hide-confirm-password">
                                                <i class="bx bxs-show font-size-15"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Info</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_fullname">Full Name<span class="text-danger">*</span></label>
                                    <input name="user_fullname" type="text" maxlength="100" class="form-control"
                                        value="{{ @$post->user_fullname }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="username">Username<span class="text-danger">*</span></label>
                                    <input name="username" type="text" maxlength="100" class="form-control nospace"
                                        value="{{ @$post->username }}">
                                    <small class="text-secondary">*No Spacing, Special Character: _-.</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="combined_input">Mobile No.<span class="text-danger">*</span></label>
                                    <div class="combined-input">
                                        <select id="user_country_dialcode" name="user_country_dialcode"
                                            class="form-control combined-left select2">
                                            @foreach ($countries as $countryAbb => $countryData)
                                                <option value="{{ $countryAbb }}"
                                                    data-dialcode="{{ $countryData['dialcode'] }}"
                                                    @if ($countryAbb == @$post->user_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
                                                    {{ $countryData['country_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="gap"></div>
                                        <input id="user_input-mask" oninput="validateInput(this)" name="user_mobile"
                                            class="form-control input-mask text-left combined-right" maxlength="45"
                                            data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''"
                                            im-insert="true" style="text-align: right; "
                                            value="{{ @$post->user_mobile }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="user_position">User Position</label>
                                    <input name="user_position" type="text" maxlength="90" class="form-control"
                                        value="{{ @$post->user_position }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nric">NRIC</label>
                                    <input id="user_nric" name="user_nric" class="form-control input-mask text-left"
                                        data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''"
                                        im-insert="true" style="text-align: right;" value="{{ @$post->user_nric }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_dob">Date of Birth</label>
                                    <div class="input-group">
                                        <input name="user_dob" class="form-control input-mask" id="datepicker"
                                            data-provide="datepicker" data-date-format="yyyy-mm-dd"
                                            data-date-autoclose="true"data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy-mm-dd" value="{{ @$post->user_dob }}"
                                            placeholder="yyyy-mm-dd">
                                        <span class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="mdi mdi-calendar"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdow-container">
                                    <label for="user_gender">Gender</label>
                                    <select name="user_gender" class="form-control select2" id="user_gender">
                                        @foreach ($user_gender_sel as $key => $val)
                                            <option value="{{ $key }}"
                                                {{ $key == @$post->user_gender ? 'selected' : '' }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="user_nationality">Nationality</label>
                                <input name="user_nationality" type="text" class="form-control"
                                    value="{{ @$post->user_nationality ?? 'Malaysian' }}">
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Social Media Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="user_facebook_url">Facebook Page Link</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa-brands fa-facebook-f"></i></span></div><input
                                        name="user_facebook_url" type="url" class="form-control"
                                        value="{{ @$post->user_facebook_url }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="user_instagram_url">Instagram Post Link</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa-brands fa-instagram"></i></span></div><input
                                        name="user_instagram_url" type="url" class="form-control"
                                        value="{{ @$post->user_instagram_url }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Address Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_address">Address 1</label>
                                    <input name="user_address" type="text" maxlength="90" class="form-control"
                                        value="{{ @$post->user_address }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_address2">Address 2</label>
                                    <input name="user_address2" type="text" maxlength="90" class="form-control"
                                        value="{{ @$post->user_address2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_postcode">Postcode</label>
                                    <input name="user_postcode" maxlength="45"
                                        class="form-control input-mask text-left"
                                        data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''"
                                        im-insert="true" style="text-align: right;"
                                        value="{{ @$post->user_postcode }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_city">City</label>
                                    <input name="user_city" type="text" class="form-control"
                                        value="{{ @$post->user_city }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group cnustom-dropdow-container">
                                    <label for="user_state">State</label>
                                    <select name="user_state_id" class="form-control select2" id="user_state_id">
                                        @foreach ($user_state_sel as $key => $val)
                                            <option value="{{ $key }}"
                                                {{ $key == @$post->user_state_id ? 'selected' : '' }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Profile Picture</h4>
                    <div class="row">
                        <div id="imagePreviews" style="margin-bottom: 10px;margin-left:12px;"></div>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"
                                        style="width: 100%; margin-bottom:10px;" name="user_profile_picture"
                                        id="user_profile_picture" accept=".jpeg,.png,.jpg,.gif"
                                        onchange="updateImageCountAndPreviews(this)" multiple
                                        @error('user_profile_picture') is-invalid @enderror>
                                    <label class="custom-file-label" id="user_profile_picture"
                                        style=" overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;"
                                        for="exampleInputFile">Select Profile Picture</label>
                                </div>
                            </div>
                        </div>
                        @error('user_profile_picture')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Setting Template</h4>
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group custom-dropdown-container">
                                <label for="background">Background</label><br>
                                <img id="background_preview" src="" height="80" width="120"
                                    style=" object-fit: cover;margin-bottom:10px; cursor: pointer;"
                                    class="background-clickable">
                                <select name="background" class="form-control select2" id="background">
                                    @foreach ($background_sel as $background_id => $background_name)
                                        <option value="{{ $background_id }}"
                                            {{ $background_id == @$post->background ? 'selected' : ($background_id == 1 ? 'selected' : '') }}>
                                            {{ $background_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group custom-dropdown-container">
                                <label for="banner">Banner</label><br>
                                <img id="banner_preview" src="" height="80" width="120"
                                    class="banner-clickable"
                                    style=" object-fit: cover;margin-bottom:10px; cursor: pointer;background-color: rgb(215, 215, 215)"
                                    class="background-clickable">
                                <select name="banner" class="form-control select2" id="banner">
                                    @foreach ($banner_sel as $banner_id => $banner_name)
                                        <option value="{{ $banner_id }}"
                                            {{ $banner_id == @$post->banner ? 'selected' : ($banner_id == 3 ? 'selected' : '') }}>
                                            {{ $banner_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group  d-flex flex-column align-items-start">
                                <label for="color_selection">Color</label>
                                <div class="default-colors d-flex flex-wrap " style="display: flex;">
                                    <label
                                        style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#18B2BB"
                                            {{ @$post->user_template_colour == '#18B2BB' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 30px; height: 30px; background-color: #18B2BB; border: 2px solid #ccc; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label
                                        style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#7378C8"
                                            {{ @$post->user_template_colour == '#7378C8' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 30px; height: 30px; background-color: #7378C8; border: 2px solid #ccc; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label
                                        style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#FF1E96"
                                            {{ @$post->user_template_colour == '#FF1E96' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 30px; height: 30px; background-color: #FF1E96; border: 2px solid #ccc; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label
                                        style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#FFC800"
                                            {{ @$post->user_template_colour == '#FFC800' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 30px; height: 30px; background-color: #FFC800; border: 2px solid #ccc; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label style="display: flex; align-items: center;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" id="radio"
                                            value=""
                                            {{ !in_array(@$post->user_template_colour, ['#FF1E96', '#FFC800', '#7378C8', '#18B2BB']) ? 'checked' : '' }}>
                                        <input type="color" name="colour_picker" id="colour_picker"
                                            value="#012AEB"
                                            style="margin-left:3px;">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('user_listing') }}" class="btn btn-secondary"
                                type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- Modal -->
    <div id="bannerModal" class="modal">
        <span class="closebtn" style="color: white">&times;</span>
        <img src="" alt="" id="img">
    </div>
    <div id="backgroundModal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="backgroundImg">
    </div>
    <div id="profileModal" class="modal">
        <span class="closebtn" id="closeModal1" style="color: white">&times;</span>
        <img src="" alt="" id="profileImg">
    </div>

    @if ($enableModal)
        <script>
            var enableModal = true;
        </script>
    @else
        <script>
            var enableModal = false;
        </script>
    @endif
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="text-align: center">
                    <img src="https://www.linkpicture.com/q/alert-icon-1562.png" style="width: 40%" alt="">
                </div>
                <form action="{{ route('user_edit', ['id' => @$alreadyExist->user_id ?? '0']) }}" method="get">
                    @csrf
                    <div class="modal-body" style="text-align: center">
                        <h5>The phone number and email already exist. The account details : <br><br>

                            <span>Full Name : <span
                                    style="color: red">{{ @$alreadyExist->user_fullname }}</span><br></span>
                            <span>Username : <span style="color: red">{{ @$alreadyExist->username }}</span><br></span>
                            <span>Email : <span style="color: red">{{ @$alreadyExist->user_email }}</span><br></span>



                            <br><br>Do you want to use this account ?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="ProductModal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="img">
    </div>
    <div class="modal fade" id="upload_error" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel"aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="text-align: center;margin-top:30px">
                    <img src="{{URL::asset("assets/images/error.png")}}" style="width: 27%" alt="">
                </div>
                <div style="text-align: center;font-size:20px;margin-top:30px">
                    File size exceeds the 10 MB limit.
                </div>
                <div style="text-align: center;margin-bottom:20px;margin-top:20px;">
                    <button type="button" style="width:60px" class="btn btn-secondary"
                        data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/summernote-image-attributes.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>
    {{-- Google API --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            var companySelect = $("#company_id");
            var branchSelect = $("#company_branch_id");
            var newBranch = $("#new_branch");

            function updateBranchDropdown() {
                if (companySelect.val() === "") {
                    branchSelect.prop("disabled", true);
                    branchSelect.val("");
                    newBranch.hide();
                } else {
                    branchSelect.prop("disabled", false);
                    newBranch.show();
                }
            }

            companySelect.on("change", updateBranchDropdown);

            updateBranchDropdown();
        });
    </script>
    <script>
        $(document).ready(function() {
            function fetchCompanyBranches(companyId, selectedBranchId) {
                var companyBranchSelect = $('#company_branch_id');
                companyBranchSelect.empty();

                $.ajax({
                    url: "{{ route('ajax_get_company_branch') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        company_id: companyId
                    },
                    success: function(data) {
                        // Append the options from the AJAX response
                        $.each(data, function(key, value) {
                            var option = $('<option>', {
                                value: key,
                                text: value
                            });

                            if (key == selectedBranchId) {
                                option.attr('selected', 'selected');
                            }

                            companyBranchSelect.append(option);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }


            // Event listener for the company dropdown change
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                var companyBranchSelect = $('#company_branch_id');

                if (companyId) {
                    // Enable and fetch company branches
                    companyBranchSelect.prop('disabled', false);
                    fetchCompanyBranches(companyId);
                } else {
                    // Disable the company branch dropdown and set its option to the default
                    companyBranchSelect.prop('disabled', true);
                    companyBranchSelect.empty().append($('<option>', {
                        value: '',
                        text: 'Please select company branch',
                    }));
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            var dropdown = document.getElementById("company_branch_id");
            var company_input = document.getElementById("company_id");

            @if ($branchCheck == 'checked')
                $('#branchDetailsContainer').show();
                makeInputRequired(true);
                dropdown.disabled = true;

            @endif

            $('#customCheckbox1').change(function() {
                if (this.checked) {
                    $('#branchDetailsContainer').show();
                    makeInputRequired(true);
                    dropdown.disabled = true;

                } else {
                    $('#branchDetailsContainer').hide();
                    makeInputRequired(false);
                    dropdown.disabled = false;

                }
            });

            function makeInputRequired(required) {
                // You can customize this list of input field names to match your requirements.
                var inputFieldNames = [
                    'branch_name',
                    'branch_status',
                ];

                inputFieldNames.forEach(function(fieldName) {
                    var inputElement = $('[name="' + fieldName + '"]');
                    if (required) {
                        inputElement.prop('required', true);
                    } else {
                        inputElement.prop('required', false);
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#user_country_dialcode').select2({
                templateResult: formatCountryOption,
                templateSelection: formatSelectionOption,
                dropdownAutoWidth: true,
            });

            $('#branch_country_dialcode').select2({
                templateResult: formatCountryOption,
                templateSelection: formatSelectionOption,
                dropdownAutoWidth: true,
            });

            if (enableModal) {
                $('#delete').modal('show');
            }

        });

        function formatCountryOption(option) {
            if (!option.id) {
                return option.text;
            }

            var countryCode = option.id.toLowerCase();
            var countryName = option.text;
            var dialCode = $(option.element).data('dialcode');

            var $option = $(
                '<span><img src="{{ URL::asset('assets/images/flags/') }}/' + countryCode +
                '.svg" class="img-flag" width="20" height="20" /> ' +
                countryName + ' (+' + dialCode + ')</span>'
            );

            return $option;
        }

        function formatSelectionOption(option) {
            if (!option.id) {
                return option.text;
            }

            var countryCode = option.id.toLowerCase();
            var dialCode = $(option.element).data('dialcode');

            var $option = $(
                '<span><img src="{{ URL::asset('assets/images/flags/') }}/' + countryCode +
                '.svg" class="img-flag" width="20" height="20" /> (+' + dialCode + ')</span>'
            );

            return $option;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#company_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#company_branch_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_role_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_gender').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_role_id').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_state_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#background').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#banner').select2();
        });
    </script>
    <script>
        $(document).ready(function(e) {
            $('#user_nric').on('change', function() {
                var user_nric = this.value;
                var dob = user_nric.substring(0, 6);
                //arrange date from ic number
                var y = dob.substr(0, 2);
                var m = dob.substr(2, 2);
                var d = dob.substr(4, 4);

                var dateraw = y + '-' + m + '-' + d;

                var year = parseInt(y) > 20 ? '19' + y : '20' + y;
                var month = parseInt(m) > 12 ? '0' + m.substring(0, 1) : (m == '00' ? '01' : m);
                var day = d;
                if (month == 2 && parseInt(d) > 31) {
                    var lastday = function(y, m) {
                        return new Date(y, m, 0).getDate();
                    }
                    day = lastday(parseInt(year), 2);
                    console.log(day);
                } else if (parseInt(d) > 31) {
                    day = '0' + d.substring(0, 1);
                }

                var fulldate = year + '-' + month + '-' + day;
                $('#datepicker').val(fulldate);
            });
        });
    </script>
    <script>
        $(document).ready(function(e) {

            $('#type').select2({
                minimumResultsForSearch: Infinity
            });

            $('.repeater').repeater({
                defaultValues: {
                    // 'textarea-input': 'foo'
                },
                show: function show() {
                    $(this).slideDown();
                    $(this).find('.user-contact-no').inputmask({
                        'mask': '+6099999999999',
                        'removeMaskOnSubmit': 'true',
                        'autoUnmask': 'true',
                        'placeholder': ''
                    });
                },
                hide: function hide(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function ready(setIndexes) {}
            });

            var post = '{{ @$post->user_type_id }}';

            $('.number_only').bind('input paste', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $('#company_detail').show();
            if (post == 2) {
                $(".sa").hide();
                $(".broker").hide();
                $(".dealer").show();
            } else if (post == 3) {
                $(".dealer").hide();
                $(".broker").hide();
                $(".sa").show();
            } else if (post == 4) {
                $(".dealer").hide();
                $(".sa").hide();
                $(".broker").show();
            } else {
                $('#company_detail').hide();
                $(".dealer").hide();
                $(".sa").hide();
                $(".broker").hide();
            }

            $('#user_type').on('change', function() {
                $('#company_detail').show();
                if (this.value == 2) {
                    $(".sa").hide();
                    $(".broker").hide();
                    $(".dealer").show();
                } else if (this.value == 3) {
                    $(".dealer").hide();
                    $(".broker").hide();
                    $(".sa").show();
                } else if (this.value == 4) {
                    $(".dealer").hide();
                    $(".sa").hide();
                    $(".broker").show();
                } else {
                    $('#company_detail').hide();
                    $(".dealer").hide();
                    $(".sa").hide();
                    $(".broker").hide();
                }
            });

            $("#user_type").change();

            if ('{{ @$post->user_id }}') {
                $("#subscription_details").hide();
            }

            $(document).on('change', '.state', function() {
                var state_id = $(this).val();
                var state_type = this.id;

                if (state_type == 'company_state_id') {
                    city_type = '#company_city_id';
                } else if (state_type == 'invoice_state_id') {
                    city_type = '#invoice_city_id';
                } else {
                    city_type = '#user_city';
                }

                $(city_type).html('');
                $(city_type).attr('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax_get_city_sel') }}",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(e) {
                        if (e.status) {
                            $(city_type).attr('disabled', false);
                            $(city_type).append('<option value="">Please select city</option>');
                            $.each(e.data, function(k, v) {
                                $(city_type).append('<option value=' + k + '>' + v +
                                    '</option>');
                            });
                        }
                    }
                });
            });

            $("#username").keypress(function(event) {
                var character = String.fromCharCode(event.keyCode);
                return isValid(character);
            });

            $('#add_contact').click(function() {
                console.log('dah klik tambah');

                $(".clone_contact").clone(true).insertAfter('#default_contact > div:last-child');
                $('#default_contact > .clone_contact').removeClass('clone_contact').removeAttr("style");
                return false;
            });

            $('#add_contact_ws').click(function() {
                console.log('dah klik tambah');

                $(".clone_contact_ws").clone(true).insertAfter('#default_contact_ws > div:last-child');
                $('#default_contact_ws > .clone_contact_ws').removeClass('clone_contact_ws').removeAttr(
                    "style");
                return false;
            });

            $(".remove").click(function() {
                $(this).parent().parent().remove();
            });

            $(".iframe").fancybox({
                maxWidth: 800,
                fitToView: true,
                width: '70%',
                height: '70%',
                autoSize: false,
                closeClick: false,
                openEffect: 'elastic',
                closeEffect: 'elastic',
                afterLoad: function() {
                    if (this.type == "iframe") {
                        $.extend(this, {
                            iframe: {
                                preload: false
                            }
                        })
                    }
                }
            });
        });

        $(function() {
            $('.nospace').on('keypress', function(e) {
                if (e.which == 32) {
                    return false;
                }
            });
        });

        function isValid(str) {
            return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
        }
    </script>
    <script>
        function updateLabelWithFileName(input) {
            const label = document.querySelector('label[id = "user_profile_picture"]');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = "Select Profile Picture";
            }
        }

        function updateImageCountAndPreviews(input) {
            const imagePreviews = document.getElementById("imagePreviews");
            const modal = document.getElementById("upload_error");
            const maxSize = 10 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                input.value = '';
                $(modal).modal('show');
            } else {
                imagePreviews.innerHTML = ""; // Clear existing previews
                updateLabelWithFileName(input);
                for (let i = 0; i < input.files.length; i++) {
                    const imageUrl = URL.createObjectURL(input.files[i]);
                    const image = document.createElement("img");
                    image.src = URL.createObjectURL(input.files[i]);
                    image.style.maxWidth = '100px';
                    image.style.maxHeight = '100px';
                    image.style.cursor = 'pointer';

                    image.addEventListener('click', function() {
                        showImagePreview(imageUrl);
                    });

                    imagePreviews.appendChild(image);
                }
            }
        }

        function showImagePreview(imageUrl) {
            const modal = document.getElementById("profileModal");
            const modalImage = document.getElementById("profileImg");

            modal.style.display = "flex";
            modalImage.src = imageUrl;

            const closeButton = document.querySelector("#closeModal1");
            closeButton.addEventListener("click", function() {
                modal.style.display = "none";
            });

            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        }
    </script>
    <script>
        const radio = document.getElementById('radio');
        const colour_picker = document.getElementById('colour_picker');
        radio.value = colour_picker.value;

        colour_picker.addEventListener('input', function() {
            radio.value = colour_picker.value;
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to update the background image preview
            function updateBackgroundPreview(backgroundId) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax_get_background_url') }}",
                    data: {
                        background_id: backgroundId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#background_preview').attr('src', response['data']);
                    },
                    error: function() {
                        console.log('Error fetching background URL');
                    }
                });
            }

            // Bind the change event to the #background select element
            $('#background').on('change', function() {
                var background_id = $(this).val();
                updateBackgroundPreview(background_id);
            });

            // Trigger the change event on page load to show the default image
            var defaultBackgroundId = $('#background').val(); // Get the default selected value
            updateBackgroundPreview(defaultBackgroundId);
        });
    </script>
    <script>
        $(document).ready(function() {
            function updateBannerPreview(banner_id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax_get_banner_url') }}",
                    data: {
                        banner_id: banner_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#banner_preview').attr('src', response['data']);
                    },
                    error: function() {
                        console.log('Error fetching banner URL');
                    }
                });
            }
            $('#banner').on('change', function() {
                var banner_id = $(this).val();
                updateBannerPreview(banner_id);
            });

            var defaultBannerId = $('#banner').val();
            updateBannerPreview(defaultBannerId);

        });
    </script>
    <script>
        var Backgroundmodal = document.getElementById("backgroundModal");
        var BackgroundmodalImg = document.getElementById("backgroundImg");

        var Backgroundimages = document.querySelectorAll(".background-clickable");

        Backgroundimages.forEach(function(img) {
            img.onclick = function() {
                Backgroundmodal.style.display = "flex";
                BackgroundmodalImg.src = this.src;
            }
        });

        var BackgroundCloseButton = document.getElementById("closeModal");
        BackgroundCloseButton.onclick = function() {
            Backgroundmodal.style.display = "none";
        }
    </script>
    <script>
        var modal = document.getElementById("bannerModal");
        var modalImg = document.getElementById("img");

        var images = document.querySelectorAll(".banner-clickable");

        images.forEach(function(img) {
            img.onclick = function() {
                modal.style.display = "flex";
                modalImg.src = this.src;
            }
        });

        var span = document.getElementsByClassName("closebtn")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
    <script>
        function validateInput(input) {
            var inputValue = input.value;
            if (inputValue.startsWith('60')) {
                input.value = inputValue.substring(2);
            }
        }
    </script>
    <script>
        $('#password .show-hide-password').on('click', function() {
            var input = $('#password-input');
            var icon = $('.show-hide-password i');

            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx bxs-show').addClass('bx bxs-hide');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx bxs-hide').addClass('bx bxs-show');
            }
        });

        $('#confirm_password .show-hide-confirm-password').on('click', function() {
            var input = $('#confirm-password-input');
            var icon = $('.show-hide-confirm-password i');
            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx bxs-show').addClass('bx bxs-hide');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx bxs-hide').addClass('bx bxs-show');
            }
        });
    </script>
@endsection
