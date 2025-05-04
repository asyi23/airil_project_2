@extends('layouts.master')

@section('title') {{ $title }} Company @endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

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
        @media only screen and (max-width: 700px){
        #img {
            width: 100%;
        }
        }
        .note-editor.note-frame .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-codable {
            color: #000000 !important;
        }

    </style>
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $title }} Company</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Company</a>
                    </li>
                    <li class="breadcrumb-item active">Form</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@enderror
<form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Company Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label for="sector_id">Company Sector<span class="text-danger">*</span></label>
                            {!! Form::select('sector_id', @$sector_sel, @$post->sector_id ?? '', [ 'class' => 'form-control sector select2', 'id' => 'sector_id','required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6" id="car_brand">
						<label for="car_brand_id">Car Brand<span class="text-danger">*</span></label>
						<select name="car_brand_id" class="form-control select2" id="car_brand_id" >
							@foreach($car_brand_dropdown as $key => $val)
								<option value="{{$key}}" {{ $key == @$post->car_brand_id ? 'selected' : '' }}>{{$val}}</option>
							@endforeach
						</select>
					</div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_name">Company Name<span class="text-danger">*</span></label>
                            <input name="company_name" type="text" maxlength="100" class="form-control" value="{{ @$post->company_name }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_register_number">Company Registration Number</label>
                            <input name="company_register_number" type="text" maxlength="100" class="form-control" value="{{ @$post->company_register_number }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="combined_input">Company Phone</label>
                            <div class="combined-input">
                                <select id="company_country_dialcode" name="company_country_dialcode" class="form-control combined-left select2">
                                    @foreach ($countries as $countryAbb => $countryData)
                                        <option value="{{ $countryAbb }}" data-dialcode="{{ $countryData['dialcode'] }}"  @if ($countryAbb == @$post->company_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
                                            {{ $countryData['country_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="gap"></div>
                                <input id="input-mask" oninput="validateInput2(this)" name="company_phone" maxlength="45" class="form-control input-mask text-left combined-right" data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" value="{{ @$post->company_phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label for="company_status">Company Status<span class="text-danger">*</span></label>
                            {!! Form::select('company_status', $company_status_sel, $post->company_status ?? 'active', ['class' => 'form-control select2', 'id' => 'company_status','required' => 'required' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_email">Company Email</label>
                            <input name="company_email" type="email" maxlength="45" class="form-control" value="{{ @$post->company_email }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_website">Company Website</label>
                            <input name="company_website" type="url" class="form-control" value="{{ @$post->company_website }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="company_description">Company Description</label>
                            <textarea name="company_description" id="summernote" type="text" class="form-control" maxlength="1000" rows="10">{{ @$post->company_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Company Address Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_address">Company Address 1</label>
                            <input name="company_address" type="text" maxlength="150" class="form-control" value="{{ @$post->company_address }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_address2">Company Address 2</label>
                            <input name="company_address2" type="text" maxlength="150" class="form-control" value="{{ @$post->company_address2 }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_postcode">Company Postcode</label>
                            <input name="company_postcode" class="form-control input-mask text-left" data-inputmask="'mask': '99999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{ @$post->company_postcode }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_city_name">Company City</label>
                            <input id="company_city_name" name="company_city_name" type="text" class="form-control" value="{{ @$post->company_city_name }}" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_state">Company State</label>
                            <input hidden name="company_state_name" id="company_state_name" type="text" class="form-control" value="testsing">
                            {!! Form::select('company_state_id', $state_sel, @$post->company_state_id, ['class' => 'form-control state select2','id' => 'company_state_id']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6" id="car_brand">
						<label for="company_country">Company Country</label>
                        <input hidden name="company_country_name" id="company_country_name" type="text" class="form-control" value="">
                        {!! Form::select('company_country_id', $country_dropdown, @$post->company_country_id, ['class' => 'form-control country select2','id' => 'company_country_id']) !!}
					</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"> Branch Details</h4>
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
                                            @if ($countryAbb == @$post->user_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
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
                                'required' => 'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Owner Access</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_email">Email<span class="text-danger">*</span></label>
                            <input name="user_email" type="email" class="form-control" value="{{ @$post->user_email }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                            <div id="password" class="input-group">
                                <input name="password" type="password" class="form-control" id="password-input" value="" required>
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
                            <label for="confirm_password">Confirm Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                            <div id="confirm_password" class="input-group">
                                <input name="confirm_password" type="password" class="form-control" id="confirm-password-input" value="" required>
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
                <h4 class="card-title mb-4">Owner Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_fullname">Full name<span class="text-danger">*</span></label>
                            <input name="user_fullname" id="user_fullname" type="text" maxlength="100" class="form-control" value="{{ @$post->user_fullname }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input name="username" type="text" maxlength="50" class="form-control input-font nospace" value="{{ @$post->username }}" required>
                            <small class="text-secondary">*No Spacing, Special Character:_-.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="combined_input">Mobile No.<span class="text-danger">*</span></label>
                            <div class="combined-input">
                                <select id="user_country_dialcode" name="user_country_dialcode" class="form-control combined-left select2">
                                    @foreach ($countries as $countryAbb => $countryData)
                                        <option value="{{ $countryAbb }}" data-dialcode="{{ $countryData['dialcode'] }}" @if ($countryAbb == @$post->user_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
                                            {{ $countryData['country_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="gap"></div>
                                <input id="user_input-mask" oninput="validateInput(this)" name="user_mobile" class="form-control input-mask text-left combined-right" maxlength="45" data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" value="{{ @$post->user_mobile }}" style="text-align: right;" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_nric">NRIC</label>
                            <input id="user_nric" name="user_nric" type="text" class="form-control input-mask text-left" im-insert="true" style="text-align: right;" value="{{ @$post->user_nric }}">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label for="user_position">User Position</label>
                            <input id="user_position" name="user_position" type="text" class="form-control input-mask text-left" im-insert="true" style="text-align: right;" value="{{ @$post->user_position }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label for="user_role_id">User Role</label>
                            <select name="user_role_id" class="form-control select2" id="user_role_id">
                                @foreach($user_role as $key => $val)
                                    <option value="{{$key}}"  @if ($key == @$post->user_role_id) selected @elseif ($key === 3) selected @endif>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="user_dob">Date of Birth</label>
                            <div class="input-group">
                                <input name="user_dob" class="form-control input-mask" id="datepicker" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" value="{{ @$post->user_dob }}" placeholder="yyyy-mm-dd">
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                        <label class="control-label">Gender</label>
                            {!! Form::select('user_gender', $user_gender_sel, @$post->user_gender, ['class' => 'form-control select2', 'id' => 'user_gender']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Company Images</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <label for="company_logo">Company Logo</label>
                        <div id="imagePreviews2" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;" name="company_logo" id="company_logo" accept=".jpeg,.png,.jpg,.gif"  data-label-id="company_logo_label"  data-image-previews-id="imagePreviews2" @error('company_logo') is-invalid @enderror>
                            <label class="custom-file-label" id="company_logo_label" style=" overflow: hidden; text-overflow: ellipsis;  white-space: nowrap;" for="company_logo">
                                Select Company Logo
                            </label>
                        </div>
                        @error('company_logo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <label for="company_banner">Company Banner</label>
                        <div id="imagePreviews3" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="company_banner" id="company_banner" accept=".jpeg,.png,.jpg,.gif" data-label-id="company_banner_label"  data-image-previews-id="imagePreviews3" @error('company_banner') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="company_banner_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Company Banner
                            </label>
                        </div>
                        @error('company_banner')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="pricelist_brochure">
            <div class="card-body">
                <h4 class="card-title mb-4">Pricelist & Brochure</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                    <div id="pricelist_media">
                        <label for="pricelist_media">Pricelist (Default)</label>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;"  name="pricelist_media" id="pricelist_media" accept=".pdf" onchange="updateLabelWithFileName(this, 'pricelist_media_label')" multiple @error('pricelist_media') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="pricelist_media_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Company Pricelist
                            </label>
                        </div>
                        <small class="text-secondary">*Accept PDF only</small>
                        @error('pricelist_media')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                    <div id="brochure_media">
                        <label for="brochure_media">Brochure (Default)</label>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;" name="brochure_media" id="brochure_media" accept=".pdf" onchange="updateLabelWithFileName(this, 'brochure_media_label')" multiple @error('brochure_media') is-invalid @enderror>
                            <label class="custom-file-label"
                            id="brochure_media_label"
                            style=" overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;"
                            for="exampleInputFile">Select Company Brochure
                        </label>
                        </div>
                        <small class="text-secondary">*Accept PDF only</small>
                        @error('brochure_media')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Uploads Custom Thumbnails</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <label for="company_thumbnail">Company Thumbnail</label>
                        <div id="imagePreviews4" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;" name="company_thumbnail" id="company_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="company_thumbnail_label"  data-image-previews-id="imagePreviews4" @error('company_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id = "company_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Company Thumbnail
                            </label>
                        </div>
                        @error('company_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12" id="promotion_thumbnail">
                        <label for="promotion_thumbnail">Promotion Thumbnail</label>
                        <div id="imagePreviews9" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="promotion_thumbnail" id="promotion_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="promotion_thumbnail_label"  data-image-previews-id="imagePreviews9" @error('promotion_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="promotion_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Promotion Thumbnail
                            </label>
                        </div>
                        @error('promotion_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12" id="catalog_thumbnail">
                        <label for="catalog_thumbnail">Catalog Thumbnail</label>
                        <div id="imagePreviews5" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="catalog_thumbnail" id="catalog_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="catalog_thumbnail_label"  data-image-previews-id="imagePreviews5" @error('catalog_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="catalog_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Catalog Thumbnail
                            </label>
                        </div>
                        @error('catalog_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12" id="general_thumbnail">
                        <label for="general_thumbnail">General Thumbnail</label>
                        <div id="imagePreviews6" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="general_thumbnail" id="general_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="general_thumbnail_label"  data-image-previews-id="imagePreviews6" @error('general_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="general_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select General Thumbnail
                            </label>
                        </div>
                        @error('general_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12" id="pricelist_thumbnail">
                        <label for="pricelist_thumbnail">Pricelist Thumbnail</label>
                        <div id="imagePreviews7" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="pricelist_thumbnail" id="pricelist_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="pricelist_thumbnail_label"  data-image-previews-id="imagePreviews7" @error('general_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="pricelist_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Pricelist Thumbnail
                            </label>
                        </div>
                        @error('pricelist_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12" id="brochure_thumbnail">
                        <label for="brochure_thumbnail">Brochure Thumbnail</label>
                        <div id="imagePreviews8" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input file-input" style="width: 100%; margin-bottom:10px;"  name="brochure_thumbnail" id="brochure_thumbnail" accept=".jpeg,.png,.jpg,.gif" data-label-id="brochure_thumbnail_label"  data-image-previews-id="imagePreviews8" @error('general_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="brochure_thumbnail_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Brochure Thumbnail
                            </label>
                        </div>
                        @error('brochure_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                <a href="{{ route('company_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
            </div>
        </div>
    </div>
</div>
</form>
{{-- Modal --}}
<div id="Modal" class="modal">
    <span class="closebtn" id="closeModal" style="color: white">&times;</span>
    <img src="" alt="" id="img">
</div>
<div class="modal fade" id="upload_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div style="text-align: center;margin-top:30px">
                <img src="{{URL::asset("assets/images/error.png")}}" style="width: 27%" alt="">
            </div>
            <div style="text-align: center;font-size:20px;margin-top:30px" id="fileSizeExceedMessage">
            </div>
            <div style="text-align: center;margin-bottom:20px;margin-top:20px;">
                <button type="button" style="width:60px" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>

<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/summernote-image-attributes.js') }}"></script>
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


<!-- form mask -->
<script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>


<!-- form mask init -->
<script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>
<script>
    $(function() {
        $('.nospace').on('keypress', function(e) {
            if (e.which == 32) {
                return false;
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#company_country_dialcode').select2({
            templateResult: formatCountryOption,
            templateSelection: formatSelectionOption,
            dropdownAutoWidth: true,
        });
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

    });
    function formatCountryOption(option) {
        if (!option.id) {
            return option.text;
        }

        var countryCode = option.id.toLowerCase();
        var countryName = option.text;
        var dialCode = $(option.element).data('dialcode');

        var $option = $(
            '<span><img src="{{ URL::asset('assets/images/flags/') }}/' + countryCode + '.svg" class="img-flag" width="20" height="20" /> ' +
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
            '<span><img src="{{ URL::asset('assets/images/flags/') }}/' + countryCode + '.svg" class="img-flag" width="20" height="20" /> (+' + dialCode + ')</span>'
        );

        return $option;
    }
</script>
<script>
    $(document).ready(function () {
        $('#sector_id').select2({
        minimumResultsForSearch: Infinity
    });
    });
    $(document).ready(function () {
        $('#company_status').select2({
        minimumResultsForSearch: Infinity
    });
    });
    $(document).ready(function () {
        $('#user_role_id').select2({
        minimumResultsForSearch: Infinity
    });
    });
    $(document).ready(function () {
        $('#user_gender').select2({
        minimumResultsForSearch: Infinity
    });
    });
</script>
<script>
    $(document).ready(function(e) {

        $('#sector_id').change(function(e) {

            if ($('#sector_id').val() == "1") {
                $('#car_brand').show();
                $('#catalog_thumbnail').show();
                $('#pricelist_brochure').show();
                $('#pricelist_thumbnail').show();
                $('#brochure_thumbnail').show();
            } else {
                $('#car_brand').hide();
                $('#catalog_thumbnail').hide();
                $('#pricelist_brochure').hide();
                $('#pricelist_thumbnail').hide();
                $('#brochure_thumbnail').hide();
            }

            if($('#sector_id').val() == "2"){
                $('#general_thumbnail').show();
            }else{
                $('#general_thumbnail').hide();
            }
        });

        $("#sector_id").change();


        $('#user_nric').on('change', function() {
            var user_nric = this.value;
            var dob =  user_nric.substring(0, 6);
            //arrange date from ic number
            var y = dob.substr(0, 2);
            var m = dob.substr(2, 2);
            var d = dob.substr(4,4);

            var dateraw = y+'-'+m+'-'+d;

            var year = parseInt(y) > 20 ? '19' + y : '20' + y;
            var month = parseInt(m) > 12 ? '0' + m.substring(0, 1) : ( m == '00' ? '01' : m );
            var day = d;
            if(month == 2 && parseInt(d) > 31){
                var lastday = function(y,m){
                    return  new Date(y, m, 0).getDate();
                }
                day = lastday(parseInt(year), 2);
                console.log(day);
            } else if(parseInt(d) > 31) {
                day = '0' + d.substring(0, 1);
            }

            var fulldate = year+'-'+month+'-'+day;
            $('#datepicker').val(fulldate);
        });

        //$("#user_role").hide();
        $('#user_type').on('change', function() {
            if (this.value == 1) {
                $("#user_role").show();
            } else {
                $("#user_role").hide();
            }
        });

        $('.state').on('change', function() {
            var state_id = $(this).val();
            var state_type = this.id;

            if(state_type=='company_state_id'){
                city_type = '#company_city_id';
            }else if(state_type=='invoice_state_id'){
                city_type = '#invoice_city_id';
            }

            $(city_type).html('');
            $(city_type).attr('disabled',true);
            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_city_sel')}}",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if(e.status){
                        $(city_type).attr('disabled',false);
                        $(city_type).append('<option value>Please select city</option>');
                        $.each(e.data, function(k, v) {
                            $(city_type).append('<option value='+k+'>'+v+'</option>');
                        });
                    }
                }
            });
        });
        $('#user_nric').on('change', function() {
            var user_nric = this.value;
            var dob =  user_nric.substring(0, 6);
            //arrange date from ic number
            var y = dob.substr(0, 2);
            var m = dob.substr(2, 2);
            var d = dob.substr(4,4);

            var dateraw = y+'-'+m+'-'+d;

            var year = parseInt(y) > 20 ? '19' + y : '20' + y;
            var month = parseInt(m) > 12 ? '0' + m.substring(0, 1) : ( m == '00' ? '01' : m );
            var day = d;
            if(month == 2 && parseInt(d) > 31){
                var lastday = function(y,m){
                    return  new Date(y, m, 0).getDate();
                }
                day = lastday(parseInt(year), 2);
                console.log(day);
            } else if(parseInt(d) > 31) {
                day = '0' + d.substring(0, 1);
            }

            var fulldate = year+'-'+month+'-'+day;
            $('#datepicker').val(fulldate);
        });
    });
</script>
<script>
    // Function to update label with file name and display images
    function updateLabelAndDisplayImages(input, labelId, imagePreviewsId) {
        const label = document.querySelector(`label[id="${labelId}"]`);
        const imagePreviews = document.getElementById(imagePreviewsId);
        const modal = document.getElementById("upload_error");
        const maxSize = 10 * 1024 * 1024;
        var messageContainer = $("#fileSizeExceedMessage");

        if (input.files[0].size > maxSize) {
            input.value = '';
            messageContainer.text("File size exceeds the 10 MB limit.");
            $(modal).modal('show');
        } else {
            imagePreviews.innerHTML = '';

            // Update the label with the selected file name
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = `Select ${label.textContent.split(' ')[1]}`;
            }

            for (let i = 0; i < input.files.length; i++) {
                const imageUrl = URL.createObjectURL(input.files[i]);
                const image = document.createElement('img');
                image.src = imageUrl;
                image.style.maxWidth = '150px';
                image.style.maxHeight = '90px';
                image.style.marginBottom = '5px';
                image.style.cursor = 'pointer';

                image.addEventListener('click', function () {
                    showImagePreview(imageUrl);
                });

                imagePreviews.appendChild(image);
            }
        }
    }

    // Attach the event listeners
    document.addEventListener("DOMContentLoaded", function () {
        const fileInputs = document.querySelectorAll('.file-input');

        fileInputs.forEach(function (input) {
            input.addEventListener('change', function () {
                const labelId = this.getAttribute('data-label-id');
                const imagePreviewsId = this.getAttribute('data-image-previews-id');
                updateLabelAndDisplayImages(this, labelId, imagePreviewsId);
            });
        });
    });
    // Open the modal and set the modalImg source
    function showImagePreview(imageUrl) {
        var modal = document.getElementById("Modal");
        var modalImg = document.getElementById("img");
        modal.style.display = "flex";
        modalImg.src = imageUrl;
    }
    function updateLabelWithFileName(input, labelId) {
        const label = document.getElementById(labelId);
        const modal = document.getElementById("upload_error");
        const maxSize = 50 * 1024 * 1024;
        var messageContainer = $("#fileSizeExceedMessage");

        if (input.files[0].size > maxSize) {
            input.value = '';
            messageContainer.text("File size exceeds the 50 MB limit.");
            $(modal).modal('show');
        }else{
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = `Select ${labelId === 'pricelist_media_label' ? 'Company Pricelist' : 'Company Brochure'}`;
            }
        }
    }

    // Close the modal when the close button is clicked
    document.getElementById("closeModal").addEventListener("click", function() {
        var modal = document.getElementById("Modal");
        modal.style.display = "none";
    });

        function get_company_state_by_name(state_name){
            $.ajax({
                url: "{{ route('ajax_get_company_state_by_name') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    state_name: state_name,
                },
                success: function(e) {
                    if (e) {
                        console.log(e);
                        $("#company_state_id").val(e.state_id).trigger('change');
                    }else{
                        $('#company_state_id').val('').trigger('change');
                    }
                }
            });
        }
        function get_company_country_by_name(country_name){
            $.ajax({
                url: "{{ route('ajax_get_company_country_by_name') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_name: country_name,
                },
                success: function(e) {
                    if (e) {
                        console.log(e);
                        $('#company_country_id').val(e.country_id).trigger('change');
                    }else{
                        $('#company_country_id').val('').trigger('change');
                    }
                }
            });
        }
</script>
<script>
    function validateInput(input) {
        var inputValue = input.value;
        if (inputValue.startsWith('60')) {
            input.value = inputValue.substring(2);
        }
    }

    function validateInput2(input) {
        var inputValue = input.value;
        if (inputValue.startsWith('60')) {
            input.value = inputValue.substring(2);
        }
    }
    function validateInput3(input) {
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
<script>
    var company_id = '{{@$post->company_id ?? " "}}';
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content')     }
    });
    $('#summernote').each(function (i) {
        $("#summernote").eq(i).summernote({
            height: 400,
            minHeight: null,
            maxHeight: null,
            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                figureClass: 'figureClass',
                figcaptionClass: 'captionClass',
                captionText: 'Caption Goes Here.',
            },
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageAttributes']],
                ],
            },
            maximumImageFileSize: 1024 * 1024 * 20,
            callbacks: {
                onImageUpload: function (files) {
                    Swal.fire({
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            $('.swal2-loading').html('<img class="w-100" src="' + '{{ URL::asset('assets/images/image_loading.gif') }}' + '" />');
                        },
                        animation: false,
                    });
                    var promises = [];
                    $.each(files, function (file) {
                        promises.push(sendFile(files[file], i));
                    });
                    $.when.apply(null, promises).done(function () {
                        Swal.close();
                    });
                },
                onImageUploadError: function (msg) {
                    alert('Invalid image');
                },
                onChange: function (contents, $editable) {
                    //remark: solve below problem, justify after image or hyperlink
                    var paragraph = $('.note-editable').find("p");

                    $.each(paragraph, function (index, text) {
                        if (text.firstElementChild == null) {
                            if (text.style.textAlign == '') {
                                text.style.textAlign = "justify";
                            }
                        }
                    });
                },
            },
        });
    });
    function sendFile(img, i) {
        var formData = new FormData();
        formData.append("img", img);
        formData.append("id", company_id);

        return $.ajax({
            type: 'POST',
            url: "{{route('ajax_upload_company_note_image')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.status) {
                    $('#summernote').eq(i).summernote('insertImage', res.data.url, function ($image) {
                        $image.attr('data-media-id', res.data.id);
                        $image.attr('alt', res.data.file_name);
                        $image.css('width', '50%');
                        if (res.data.temp) {
                            $image.attr('data-temp', true);
                        }
                    });
                } else {
                    alert(res.message);
                }
            },
        });
    }
</script>
@endsection

