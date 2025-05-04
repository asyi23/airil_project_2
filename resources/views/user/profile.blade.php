@extends('layouts.master')

@section('title')
    User {{ $title }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/cropperjs/cropperjs.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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

        #bannerImg {
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
        #backgroundImg{
            margin: auto;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            width: 300px;
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
        #bannerImg {
            width: 100%;
        }
        #backgroundImg{
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
                <h4 class="mb-0 font-size-18">User {{ $title }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">User</a>
                        </li>
                        <li class="breadcrumb-item active">Profile</li>
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
        <div class="{{$column}}">
            <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Details</h4>
                        <div class="text-center" style="display: flex;align-items:center;justify-content:center;">
                            <div class="company-profile-rounded-box m-0">
                                <div class="company-profile-outer"
                                    style="background-image: url({{ $user->getMedia('user_profile_picture')->last()? $user->getMedia('user_profile_picture')->last()->getUrl(): '' }});background-repeat: no-repeat;
                                    background-size: cover;background-position: center;">
                                    {{-- <div class="company-profile-outer" style="background-image: url(https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D&w=1000&q=80)" > --}}
                                    <div class="company-profile-inner file-wrapper">
                                        <input name="company_logo" id="company_logo" class="company-logo"
                                            type="file" accept=".jpeg,.png,.jpg">
                                        <label><i class="fa fa-camera"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <ul class="list-group list-group-flush font-size-15 text-dark" style="display: flex;align-items:center;justify-content:center;">
                                <li class="list-group-item border-0 pt-0">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><input  class="font-size-13" id="textToCopy"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="{{env('APP_USER_URL')}}{{$post->username}}"
                                                value="{{env('APP_USER_URL')}}{{$post->username}}"
                                                style="border: none; width: 100%;   overflow: hidden;
                                                white-space: nowrap;
                                                text-overflow: ellipsis;
                                                max-width: 100%;" readonly>
                                        </li>
                                        <li>
                                            <a id="copyButton" data-toggle="tooltip" data-placement="bottom" style="cursor: pointer"><i class="fa-solid fa-copy font-size-13 text-info"></i></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input name="username" type="text" class="form-control"
                                        value="{{ @$post->username }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input name="user_email" type="email" class="form-control"
                                        value="{{ @$post->user_email}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_fullname">Full Name</label>
                                    <input name="user_fullname" type="text" class="form-control"
                                        value="{{ @$post->user_fullname }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="combined_input">Mobile No.<span class="text-danger">*</span></label>
                                    <div class="combined-input">
                                        <select id="user_country_dialcode" name="user_country_dialcode" class="form-control combined-left select2">
                                            @foreach ($countries as $countryAbb => $countryData)
                                            <option value="{{ $countryAbb }}" @if($countryAbb == @$post->user_country_dialcode) selected  @elseif ($countryAbb == @$country_abb) selected @endif data-dialcode="{{ $countryData['dialcode'] }}">
                                                    {{ $countryData['country_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="gap"></div>
                                        <input id="user_input-mask" name="user_mobile" class="form-control input-mask text-left combined-right" maxlength="45" data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{@$post->user_mobile }}">
                                    </div>
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
                                    <label for="user_nationality">Nationality</label>
                                    <input name="user_nationality" type="text" class="form-control"
                                        value="{{ @$post->user_nationality ?? 'Malaysian' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container ">
                                    <label class="control-label">Gender</label>
                                    {!! Form::select('user_gender', $user_gender_sel, @$post->user_gender, ['class' => 'form-control select2', 'id'=>'user_gender']) !!}
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
                                        value="{{ @$post->user_facebook_url}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="user_instagram_url">Instagram Post Link</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa-brands fa-instagram"></i></span></div><input
                                        name="user_instagram_url" type="url" class="form-control"
                                        value="{{ @$post->user_instagram_url}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Address Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_address">Address 1</label>
                                    <input name="user_address" type="text" class="form-control"
                                        value="{{ @$post->user_address}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_address2">Address 2</label>
                                    <input name="user_address2" type="text" class="form-control"
                                        value="{{ @$post->user_address2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_postcode">Postcode</label>
                                    <input name="user_postcode" class="form-control input-mask text-left"
                                        data-inputmask="'mask': '99999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''"
                                        im-insert="true" style="text-align: right;"
                                        value="{{ @$post->user_postcode}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group custom-dropdown-container">
                                    <label for="user_state_id">State</label>
                                    {!! Form::select('user_state_id', @$user_state_sel, @$post->user_state_id ?? ['' => 'Please select state'], [
                                        'class' => 'form-control select2',
                                        'id' => 'user_state_id',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_city">City</label>
                                    <input name="user_city" type="text" class="form-control"
                                        value="{{ @$post->user_city }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Setting Template</h4>
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <label for="background">Background</label>
                            <div class="form-group custom-dropdown-container">
                                <img id="background_preview" src="" height="80" width="120" style=" object-fit: cover;margin-bottom:10px; cursor: pointer;" class="background-clickable">
                                {!! Form::select('user_template_background_id', $background_sel, @$post->user_template_background_id ?? 1, ['class' => 'form-control select2', 'id' => 'user_template_background_id']) !!}
                            </div>
                        </div>
                        <br>
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <label for="banner">Banner</label>
                            <div class="form-group custom-dropdown-container">
                                <img id="banner_preview" src="" height="80" width="120" style=" object-fit: cover;margin-bottom:10px; cursor: pointer;background-color: rgb(215, 215, 215)" class="banner-clickable" >
                                {!! Form::select('user_template_banner_id', @$banner_sel, @$post->user_template_banner_id ?? 3, ['class' => 'form-control select2', 'id' => 'user_template_banner_id']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group d-flex flex-column align-items-start">
                                <label for="color_selection">Color</label>
                                <div class="default-colors d-flex flex-wrap" style="display: flex;">
                                    <label style="display: flex; align-items: center;margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#18B2BB"
                                            {{ @$post->user_template_colour == '#18B2BB' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 25px; height: 25px; background-color: #18B2BB; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#7378C8"
                                            {{ @$post->user_template_colour == '#7378C8' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 25px; height: 25px; background-color: #7378C8; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label style="display: flex; align-items: center;margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#FF1E96"
                                            {{ @$post->user_template_colour == '#FF1E96' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 25px; height: 25px; background-color: #FF1E96; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label style="display: flex; align-items: center; margin-right: 10px;margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" value="#FFC800"
                                            {{ @$post->user_template_colour == '#FFC800' ? 'checked' : '' }}>
                                        <div class="color-box"
                                            style="width: 25px; height: 25px; background-color: #FFC800; border-radius: 50%; margin-left: 3px;">
                                        </div>
                                    </label>
                                    <label style="display: flex; align-items: center; margin-bottom:10px">
                                        <input type="radio" name="user_template_colour" id="radio" value=""
                                            {{ !in_array(@$post->user_template_colour, ['#FF1E96', '#FFC800', '#7378C8', '#18B2BB']) ? 'checked' : '' }}>
                                        @if ($post->user_template_colour == null)
                                            <input type="color" name="colour_picker" id="colour_picker"
                                            style="border: none"
                                            value="{{ !in_array(@$post->user_template_colour, ['#FF1E96', '#FFC800', '#7378C8', '#18B2BB']) ? '#012AEB' : '' }}">
                                        @else
                                            <input type="color" name="colour_picker" id="colour_picker"
                                                style="border: none"
                                                value="{{ !in_array(@$post->user_template_colour, ['#FF1E96', '#FFC800', '#7378C8', '#18B2BB']) ? @$post->user_template_colour : '' }}">
                                        @endif
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
                            {{-- <a href="{{ route('admin_listing') }}" class="btn btn-secondary"
                                type="button">Cancel</a> --}}
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- User profile photo modal -->
    <div class="modal fade" id="user_profile_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Logo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img class="img-preview" id="image_preview" src="">
                        <div class="row mt-2">
                            <div class="col-6">
                                <span class="bx bx-minus-circle"></span>
                            </div>
                            <div class="col-6 text-right">
                                <span class="bx bx-plus-circle"></span>
                            </div>
                            <div class="col-12">
                                <input type="range" min="0" value="0" max="1" step="0.0001"
                                    id="company_profile_data_zoom">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-0">
                    <button type="button" class="btn btn-secondary cancel" data-dismiss="modal"
                        id="company-logo-cancel">Cancel</button>
                    <button type="button" class="btn btn-company save" id="crop">Save</button>

                </div>
            </div>
        </div>
    </div>
    <div id="bannerModal" class="modal">
        <span class="closebtn" id="closeModal1" style="color: white">&times;</span>
        <img src="" alt="" id="bannerImg">
    </div>
    <div id="backgroundModal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="backgroundImg">
    </div>
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
    <script src="{{ URL::asset('assets/libs/cropperjs/cropperjs.min.js') }}"></script>

    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    <script>
        const radio = document.getElementById('radio');
        const colour_picker = document.getElementById('colour_picker');
        radio.value = colour_picker.value;

        colour_picker.addEventListener('input', function() {
            radio.value = colour_picker.value;
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#user_country_dialcode').select2({
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
            $('#user_state_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_template_background_id').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_template_banner_id').select2();
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

            //profile photo
            var $modal = $('#user_profile_modal');
            var image = document.getElementById('image_preview');
            var cropper;
            var company_logo_original;
            $('.company-logo').on('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    image.src = url;
                    $modal.modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $modal.modal('show');
                };

                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    company_logo_original = file = files[0];

                    var type = file.type.split('/')[1];
                    var size = file.size;
                    if (type != 'jpeg' && type != 'png' && type != 'jpg' && type != 'gif') {
                        Swal.fire({
                            title: 'Can\'t read files',
                            text: 'Your photos couldn\'t be uploaded. Photos should be saved as JPG, PNG, GIF',
                            type: 'error',
                            confirmButtonText: 'Close'
                        });
                        $('.company-logo').val('');
                        return false;
                    }
                    if (size > 10485760) { // 10MB
                        Swal.fire({
                            title: 'Can\'t read files',
                            text: 'Your photos couldn\'t be uploaded. Photos should be smaller than 5 MB',
                            type: 'error',
                            confirmButtonText: 'Close'
                        });
                        $('.company-logo').val('');
                        return false;
                    }

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    ready: function ready(e) {
                        cropper.zoomTo(0);
                        var imageData = cropper.getImageData();
                        var minSliderZoom = imageData.width / imageData.naturalWidth;
                        var maxSliderZoom = 1; // default max
                        if (minSliderZoom > maxSliderZoom) {
                            var new_max = (Math.round(minSliderZoom * 10) / 10) - Math.floor(
                                minSliderZoom);
                            maxSliderZoom = new_max > 0.5 ? (Math.round(minSliderZoom * 10) /
                                10) + (1 - new_max) : (Math.round(minSliderZoom * 10) /
                                10) + (0.5 - new_max);
                        }
                        $("#company_profile_data_zoom").attr("max", maxSliderZoom);
                        $("#company_profile_data_zoom").attr("min", minSliderZoom);
                        $("#company_profile_data_zoom").val(minSliderZoom);
                    },
                    crop(event) {

                    },
                    aspectRatio: 1,
                    cropBoxResizable: false,
                    viewMode: 1,
                    dragMode: 1,
                    highlight: true,
                    dragMode: 'move',
                    modal: true,
                    responsive: true,
                    restore: true,
                    checkCrossOrigin: true,
                    checkOrientation: true,
                    autoCrop: true,

                    movable: true,
                    scalable: true,
                    guides: true,
                    background: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    toggleDragModeOnDblclick: false,
                    zoomOnTouch: false,
                    zoomOnWheel: false,
                    preview: '.preview',
                });

            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
                $('.company-logo').val('');
            });

            $('#crop').click(function() {
                $(this).prop('disabled', true); // disable save button
                $('#company-logo-cancel').prop('disabled', true); // disable cancel button
                canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });

                canvas.toBlob(function(blob) {

                    var formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('user_profile_photo_crop', blob, company_logo_original.name);
                    formData.append('collection_name', 'company_logo');
                    formData.append('user_profile_photo_original', company_logo_original);

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('ajax_upload_profile_image') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(e) {
                            if (e.status) {
                                $modal.modal('hide');
                                $('.company-profile-outer').css({
                                    'background-image': 'url(' + e.data[
                                        'user_profile_photo_crop'] + ')'
                                });
                                $('.company-logo').val('');
                                console.log(e.data['user_profile_photo_crop'])
                            } else {
                                console.log('fail')
                            }
                            $('#crop').prop('disabled', false);
                            $('#company-logo-cancel').prop('disabled', false);
                        }
                    });
                });
            });

            $('#company_profile_data_zoom').on('input', function() {
                // if (cropper.canvasData.naturalWidth < 600 || cropper.canvasData.naturalHeight < 400) {
                //     event.preventDefault();
                // } else {
                var currentValue = $('#company_profile_data_zoom').val();
                var zoomValue = parseFloat(currentValue);
                cropper.zoomTo(zoomValue.toFixed(4));
                // }
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
        document.getElementById('user_profile_picture').addEventListener('change', function(event) {
            var fileInput = event.target;
            var imagePreview = document.getElementById('imagePreview');
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                imagePreview.setAttribute('src', ''); // Clear preview if no file selected
            }
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
            $('#user_template_background_id').on('change', function() {
                var background_id = $(this).val();
                updateBackgroundPreview(background_id);
            });

            // Trigger the change event on page load to show the default image
            var defaultBackgroundId = $('#user_template_background_id').val(); // Get the default selected value
            updateBackgroundPreview(defaultBackgroundId);
        });
    </script>
    <script>
        $(document).ready(function() {
            function updateBannerPreview(banner_id) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_banner_url')}}",
                    data: {
                        banner_id: banner_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        $('#banner_preview').attr('src', response['data']);
                    },
                    error: function() {
                        console.log('Error fetching banner URL');
                    }
                });
            }
            $('#user_template_banner_id').on('change', function() {
                var banner_id = $(this).val();
                updateBannerPreview(banner_id);
            });

            var defaultBannerId = $('#user_template_banner_id').val();
            updateBannerPreview(defaultBannerId);

        });
    </script>
    <script>
        var Backgroundmodal = document.getElementById("backgroundModal");
        var BackgroundmodalImg = document.getElementById("backgroundImg");

        var Backgroundimages = document.querySelectorAll(".background-clickable");

        Backgroundimages.forEach(function(img) {
            img.onclick = function(){
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
        var Bannermodal = document.getElementById("bannerModal");
        var BannermodalImg = document.getElementById("bannerImg");

        var Bannerimages = document.querySelectorAll(".banner-clickable");

        Bannerimages.forEach(function(img) {
            img.onclick = function(){
                Bannermodal.style.display = "flex";
                BannermodalImg.src = this.src;
            }
        });

        var BannerCloseButton = document.getElementById("closeModal1");
        BannerCloseButton.onclick = function() {
            Bannermodal.style.display = "none";
        }
    </script>
    <script>
        // Function to copy text to clipboard
        function copyTextToClipboard() {
            const textToCopy = document.getElementById('textToCopy');
            textToCopy.select();
            document.execCommand('copy');

            // Change the tooltip text to "Copied"
            $('#copyButton').attr('data-original-title', 'Copied').tooltip('show');
            $('#textToCopy').tooltip('hide');

            // Hide the tooltip after a short delay (optional)
            setTimeout(function() {
                $('#copyButton').tooltip('hide');
            }, 10000);
        }

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Add a click event listener to the copy button
        const copyButton = document.getElementById('copyButton');
        copyButton.addEventListener('click', copyTextToClipboard);
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
