@extends('layouts.master')

@section('title') {{ $title }} Ad @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.css')}}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-preview.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-edit.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-file-poster.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/doka.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.min.css')}}">
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }} Ad</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Ad</a>
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
        <form id="ads_form" method="POST" action="{{ $submit }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">User details</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_type_id">USER TYPE <span class="text-danger">*</span></label>
                                        {!! Form::select('user_type_id', $user_type_sel, @$post->user_type_id, ['class' => 'form-control', 'id' => 'user_type_id']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">USER <span class="text-danger">*</span></label>
                                        {!! Form::select('user_id', $user_id_sel, @$post->user_id, (@$post->user_type_id ? ['class' => 'form-control', 'id' => 'user_id'] : ['class' => 'form-control', 'id' => 'user_id', 'disabled']) ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <x-user-credit-balance :userId="@$post->user_id" userIdField="user_id"/>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Upgrade Your Ad</h4>
                            <div class="row setting-cars">
                                @foreach($setting_ads_list as $key => $setting_ads)
                                    <?php
                                    $price = $setting_ads->ads_setting_price > 0 ? number_format($setting_ads->ads_setting_price, 0) . ' Credit' : 'FREE';
                                    $old_price = $setting_ads->old_price ? '<span class="font-size-12" style="text-decoration: line-through;">' . number_format($setting_ads->old_price) . ' Credit</span>' : '';
                                    $validity = $setting_ads->ads_validity;
                                    ?>
                                    <div class="col-sm-4">
                                        <div
                                            class="card setting-cars-card {{ (@$post->setting_ads_id ? @$post->setting_ads_id == $setting_ads->setting_ads_id : $key == 0) ? 'active' : '' }}">
                                            @if($setting_ads->setting_ads_category_id == 5)
                                                <div
                                                    class="card-header premier-cars-setting-header">{{ $setting_ads->setting_ads_name }}</div>
                                            @else
                                                <div
                                                    class="card-header cars-setting-header">{{ $setting_ads->setting_ads_name }}</div>
                                            @endif
                                            <div class="card-body setting-cars-validity">
                                                <h3>{{ $validity }} days</h3>
                                            </div>
                                            <div class="card-footer bg-transparent border">
                                                <div class="setting-cars-price">
                                                    <span
                                                        class="font-size-18 font-weight-600 cars-text-theme-color">{{ $price }}</span>
                                                    &nbsp {!! $old_price !!}
                                                </div>
                                                <button type="button"
                                                        class="btn cars-btn-outline-theme-color mt-2 setting-cars-select {{ (@$post->setting_ads_id ? @$post->setting_ads_id == $setting_ads->setting_ads_id : $key == 0) ? 'active' : '' }}"
                                                        data-setting_ads_id="{{ $setting_ads->setting_ads_id }}"
                                                        data-setting_ads_category_id="{{ $setting_ads->setting_ads_category_id }}"></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="card-title mb-4">Car details</h4>
                                </div>
                                @if(@$ads->ads_status_id != 5 && @$ads->ads_status_id != 6)
                                    <div class="col-sm-9">
                                        <p class="find-car-text float-sm-right" data-toggle="modal"
                                           data-target="#myModal"> Can't Find Your Car?</p>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-12 car-info-title"
                                     @if(!@$post->car_request_check) style="display: none" @endif>
                                    <div class="form-group">
                                        <div class="input-group car-info-title-detail">
                                            <div class="input-group-prepend">
                                                <input type="button" value="Cancel Request"
                                                       class="btn cancel-car-request">
                                            </div>
                                            <input type="text" class="form-control" id="car-info-title"
                                                   value="{{ @$post->ads_title }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 car-info"
                                     @if(@$post->car_request_check) style="display: none" @endif>
                                    <div class="form-group ui-widget">
                                        <label for="quick-search" class="col-form-label">Search</label>
                                        <input class="form-control" type="search" placeholder="Eg: 2020 Toyota Yaris"
                                               id="cars-quick-search">
                                    </div>
                                    <div class="form-group">
                                        <label for="car_brand_id">BRAND <span class="text-danger">*</span></label>
                                        {!! Form::select('car_brand_id', $car_brand_sel, @$post->car_brand_id, ['class' => 'form-control', 'id' => 'car_brand_id']) !!}
                                    </div>
                                    <div class="form-group model_group"
                                         @if( !@$post->car_model_group_id ) style="display: none" @endif }}>
                                        <label for="car_model_group_id">MODEL GROUP <span
                                                class="text-danger">*</span></label>
                                        {!! Form::select('car_model_group_id', $car_model_group_sel, @$post->car_model_group_id, (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'car_model_group_id'] : ['class' => 'form-control', 'id' => 'car_model_group_id', 'disabled']) ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="car_model_id">MODEL <span class="text-danger">*</span></label>
                                        {!! Form::select('car_model_id', $car_model_sel, @$post->car_model_id, (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'car_model_id'] : ['class' => 'form-control', 'id' => 'car_model_id', 'disabled']) ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="car_manufacture_year">MANUFACTURING YEAR <span
                                                class="text-danger">*</span></label>
                                        {!! Form::select('car_manufacture_year', $car_manufacture_year_sel, @$post->car_manufacture_year, (@$post->car_model_id ? ['class' => 'form-control', 'id' => 'car_manufacture_year'] : ['class' => 'form-control', 'id' => 'car_manufacture_year', 'disabled']) ) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="car_variant_transmission">TRANSMISSION <span
                                                class="text-danger">*</span></label>
                                        {!! Form::select('car_variant_transmission', $car_variant_transmission_sel, @$post->car_variant_transmission, (@$post->car_manufacture_year ? ['class' => 'form-control', 'id' => 'car_variant_transmission'] : ['class' => 'form-control', 'id' => 'car_variant_transmission', 'disabled']) ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="car_variant_cc">ENGINE CAPACITY (CC) <span
                                                class="text-danger">*</span></label>
                                        {!! Form::select('car_variant_cc', $car_variant_cc_sel, @$post->car_variant_cc, (@$post->car_variant_transmission ? ['class' => 'form-control', 'id' => 'car_variant_cc'] : ['class' => 'form-control', 'id' => 'car_variant_cc', 'disabled']) ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="car_variant_id">VARIANT <span class="text-danger">*</span></label>
                                        {!! Form::select('car_variant_id', $car_variant_sel, @$post->car_variant_id, ((isset($post->car_variant_cc) && !is_null($post->car_variant_cc)) ? ['class' => 'form-control', 'id' => 'car_variant_id'] : ['class' => 'form-control', 'id' => 'car_variant_id', 'disabled']) ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Car Pictures <span class="text-danger">*</span></h4>
                            <div class="row">
                                <div class="col-sm-12 car-images-filepond">
                                    <input id="upload-car-images" class="filepond car-images" name="car_images[]"
                                           data-allow-reorder="true" type="file" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Car Registration Card</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <div id="registration_card_temp_container" class="mb-1" @if(!@$post->registration_card_temp_image) style="display: none;" @endif>
                                    <img id="registration_card_temp_image" src="{{ @$post->registration_card_temp_image ? $post->registration_card_temp_image->getUrl() : '' }}" width="200">
                                </div>
                                <input name="ads_registration_card" id="ads-registration_card" type="file" class="form-control-custom mb-2" accept="image/x-png,image/gif,image/jpeg">
                                <div id='loading_registration_card' class="loadingmessage" style='display:none'>
                                    <img src='{{ URL::asset('assets/images/loading.gif')}}'/>
                                </div>
                                <div class="custom-control company-custom-checkbox">
                                    <input type="checkbox" class="company-custom-control-input" name="is_registration_card" id="is_registration_card" value="1" {{ @$post->is_registration_card ? 'checked' : '' }}>
                                    <label class="company-custom-control-label" for="is_registration_card">Show Registration Card on listing</label>
                                </div>
                                <br />
                                <span class="text-danger">*</span> Car Registration Card is Compulsory for used car
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Car Registration Card</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input id="upload-car-registration-card" type="file"
                                           class="filepond filepond-image car-images" name="car_registration_card">

                                    <div class="custom-control company-custom-checkbox" id="field_ads_check_box">
                                        <input type="checkbox" class="company-custom-control-input"
                                               name="is_registration_card" id="is_registration_card"
                                               value="1" {{ @$post->is_registration_card ? 'checked' : '' }}>
                                        <label class="company-custom-control-label" for="is_registration_card">Show
                                            Registration Card on listing</label>
                                    </div>

                                    <div class="custom-control company-custom-checkbox" id="field_ads_check_box_disabled">
                                        <input type="checkbox" disabled checked class="company-custom-control-input"
                                               name="is_registration_card" id="is_registration_card"
                                               value="1" {{ @$post->is_registration_card ? 'checked' : '' }}>
                                        <label class="company-custom-control-label" for="is_registration_card">Show
                                            Registration Card on listing</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Car Video</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <input id="upload-car-video" type="file" class="filepond filepond-image car-images"
                                       name="car_video">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Car details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                {{-- <div class="car-info-title" style="display: none;">
                                    <div class="form-group">
                                        <div class="input-group car-info-title-detail">
                                            <div class="input-group-prepend">
                                                <input type="button" value="Cancel Request" class="btn cancel-car-request">
                                            </div>
                                            <input type="text" class="form-control" id="car-info-title" readonly>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="ads_type">CAR TYPE <span class="text-danger">*</span></label>
                                    <div class="row col-sm-12">
                                        @foreach($ads_type as $row)
                                            <div class="col-4 col-sm-4">
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="ads_type_id_{{ $row->ads_type_id }}" type="radio"
                                                           name="ads_type_id" class="admin-custom-control-input"
                                                           value="{{$row->ads_type_id}}" {{ @$post->ads_type_id == $row->ads_type_id ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label"
                                                           for="ads_type_id_{{ $row->ads_type_id }}">
                                                        {{ $row->ads_type_name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="assemble_type">ASSEMBLE TYPE</label>
                                    <div class="row col-sm-12">
                                        @foreach($assemble_type as $val)
                                            <div class="col-4 col-sm-4">
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="assemble_type_{{ $val }}" type="radio"
                                                           name="assemble_type" class="admin-custom-control-input"
                                                           value="{{ $val }}" {{ @$post->assemble_type == $val ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label"
                                                           for="assemble_type_{{ $val }}">
                                                        {{ strtoupper($val) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group" id="car_mileage"
                                     @if(@$post->ads_type_id == 3 || @$post->ads_type_id == 0) style="display:none" @endif>
                                    <label for="car_mileage_id">MILEAGE <span class="text-danger">*</span></label>
                                    {!! Form::select('car_mileage_id', $car_mileage_sel, @$post->car_mileage_id, ['class' => 'form-control', 'id' => 'car_mileage_id'] ) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="car_color_id">COLOR <span class="text-danger">*</span></label>
                                    <div class="row">
                                        @foreach($car_color as $row)
                                            <div class="col-3 col-md-1 pl-0 pr-0">
                                                <div id="{{ $row->car_color_id }}"
                                                     class="cars-color @if(@$post->car_color_id == $row->car_color_id) active @endif">
                                            <span class="car-color-border">
                                                <span
                                                    class="cars-color-code cars-color-{{ strtolower(@$row->car_color_slug) }}"
                                                    @if($row->car_color_code) style="background-color: {{ $row->car_color_code }}" @endif>
                                                </span>
                                            </span>
                                                    <p>{{ $row->car_color_name }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="vehicle_detail" style="display: none">
                                <div class="form-group" id="car_chassis_no">
                                    <label for="car_chassis_no">VEHICLE CHASSIS NUMBER <span class="text-danger">*</span></label>
                                    <input type="text" name="car_chassis_no" id="field_car_chassis_no" class="form-control"
                                           oninput="return this.value=this.value.replace(/[^0-9a-zA-Z]/g,'').toUpperCase()"
                                           value="{{ @$post->car_chassis_no }}" maxlength="40">
                                    <span>This will not be published</span>
                                </div>
                                <div class="form-group" id="car_plate_no" style="display:none">
                                    <label for="car_plate_no">PLATE NUMBER <span class="text-danger">*</span></label>
                                    <input type="text" name="car_plate_no" id="field_car_plate_no" class="form-control"
                                           oninput="this.value=this.value.replace(/[^0-9a-zA-Z]/g,'').toUpperCase();"
                                           value="{{ @$post->car_plate_no }}" maxlength="15">
                                    <span>This will not be published</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="car_reference_no">REFERENCE NUMBER</label>
                                    <input type="text" name="car_reference_no" class="form-control"
                                           value="{{ @$post->car_reference_no }}" maxlength="40">
                                    <span>This will not be published</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group" id="ads_warranty_month">
                                            <label for="ads_warranty_month">YEAR WARRANTY</label>
                                            {!! Form::select('ads_warranty_month', $year_warranty_sel, @$post->ads_warranty_month, ['class' => 'form-control', 'name' => 'ads_warranty_month'] ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-6" id="price_guide">
                                        <div class="form-group">
                                            <table class="table table-bordered" style="width: 100%">
                                                <tr align="center">
                                                    <td class="m-0 p-2">
                                                        <span>Average Price</span>
                                                        <h5 id="average_price"></h5>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="ads_price">SELLING PRICE <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input id="ads_price" name="ads_price" class="form-control text-left" type="text"
                                           value="{{ @$post->ads_price}}">
                                </div>
                            </div>
                            <div class="form-group col-sm-4" id="field_ads_discount">
                                <label for="ads_discount">DISCOUNT AMOUNT</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input id="ads_discount" class="form-control text-left" type="text"
                                           name="ads_discount"
                                           value="{{$post->ads_discount ?? (@$ads->setting_ads_category_id == 5 && @$ads->is_discount == 1 ? $ads->ads_price_before_discount-$ads->ads_price : '') ?? ''}}">
                                </div>
                            </div>
                            <div class="form-group col-sm-4" id="field_ads_nett_selling_price">
                                <label for="nett_price">NETT SELLING PRICE</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input id="nett_price" class="form-control text-left" name="nett_price" type="text"
                                           value="{{@$post->nett_price ?? @$ads->ads_price ?? 0.00}}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ads_title">TITLE</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input class="form-control input-group-text no-outline" id="ads-title"
                                                   name="ads_title" value="{{ @$post->ads_title }}" readonly>
                                        </div>
                                        <input id="ads_title2" type="text" class="form-control" name="ads_title2"
                                               value="{{ @$post->ads_title2 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12 cars-quick-desc">
                                <div class="col-sm-12">
                                    <div class="form-group mb-0">
                                        <label>SELLER POST <span class="text-danger">*</span></label>
                                        <p>Sell your car faster by letting buyers know what makes your car unique.</p>
                                        <textarea id="textarea" name="ads_description" class="form-control js-auto-size"
                                                  maxlength="5000" rows="10"
                                                  value="">{{ @$post->ads_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="">
                                        <!-- Small modal -->
                                        <button type="button" class="dropbtn waves-effect waves-light"
                                                data-toggle="modal" data-target="#exampleModalScrollable">Template
                                            Content
                                        </button>
                                        <div class="total-count-container float-right">
                                            <span class="total-count">0</span><span class="count-limit">/5000</span>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">
                                                        Template Content</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul id="user-template" class="cars-ul-car-color"
                                                        style="height: 210px ;overflow: auto;">
                                                        <h5>User Template Content</h5>
                                                        @if($user_template)
                                                            @foreach($user_template as $key => $val)
                                                                <li class="cars-quick-description-list">
                                                                    <a class="cars-quick-description-element"
                                                                       href="javascript:void(0)"
                                                                       data-template="{{ $val }}">{{ $key }}</a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                    <ul id="user-template" class="cars-ul-car-color"
                                                        style="height: 210px ;overflow: auto;">
                                                        <h5>Admin Template Content</h5>
                                                        @if($setting_ads_template)
                                                            @foreach($setting_ads_template as $key => $val)
                                                                <li class="cars-quick-description-list">
                                                                    <a class="cars-quick-description-element"
                                                                       href="javascript:void(0)"
                                                                       data-template="{{ $val }}">{{ $key }}</a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="setting_state_id">LOCATION (STATE) <span
                                                class="text-danger">*</span></label>
                                        {!! Form::select('setting_state_id', $setting_state_sel, @$post->setting_state_id, ['class' => 'form-control', 'id' => 'setting_state_id']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="setting_city_id">LOCATION (AREAS) <span class="text-danger">*</span></label>
                                        {!! Form::select('setting_city_id', $setting_city_sel, @$post->setting_city_id, ['class' => 'form-control', 'id' => 'setting_city_id']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Contact details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Mobile phone</label>
                                <div class="user-mobile">
                                @if(@$post->user_contact_no)
                                    @foreach($post->user_contact_no as $user_contact_no)
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="user_contact_no[]" value="{{ $user_contact_no }}" readonly>
                </div>
                @endforeach
                @else
                <div class="form-group">
                    <input type="text" class="form-control" name="user_mobile" value="{{ @$post->user_mobile }}" readonly>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <label>Whatsapp</label>
            <div class="user-whatsapp">
                @if(@$post->user_contact_no_ws)
                @foreach($post->user_contact_no_ws as $user_contact_no_ws)
                <div class="form-group">
                    <input type="text" class="form-control" name="user_contact_no_ws[]" value="{{ $user_contact_no_ws }}" readonly>
                </div>
                @endforeach
                @else
                <div class="form-group">
                    <input type="text" class="form-control" name="user_whatsapp" value="{{ @$post->user_whatsapp }}" readonly>
                </div>
                @endif
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="custom-control company-custom-checkbox">
                    <input type="checkbox" class="company-custom-control-input" name="is_hide_contact" id="is_hide_contact" value="1" {{ @$post->is_hide_contact ? 'checked' : '' }}>
                    <label class="company-custom-control-label" for="is_hide_contact">Hide the contact details in the ad</label>
                </div>
            </div>
        </div>
        </div>
        </div>--}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Highlight</h4>
                        <div class="row" id="show_highligh">
                            @foreach($setting_highlight as $key => $row)
                                <div class="column mar-bot">
                                    <div
                                        class="h-100 cars-highlight-card @if(@$post->ads_highlight_ids) {{ in_array($row->setting_highlight_id, explode(',', $post->ads_highlight_ids)) ? 'active' : '' }} @endif"
                                        data-highlight-id="{{ $row->setting_highlight_id }}">
                                        <div class="cars-highlight-card-main pb-0 d-flex flex-column">
                                            <div class="cars-highlight-rounded-box"
                                                 style="background-image: url(<?php echo optional($row->setting_highlight_icon)->getUrl() ?>)">
                                            </div>
                                            <div
                                                class="cars-highlight-title text-center">{{ $row->setting_highlight_name }}</div>
                                            <div class="cars-highlight-desc mt-auto m-1">
                                                <input
                                                    name="ads_highlight_description[{{ $row->setting_highlight_id }}]"
                                                    type="text"
                                                    class="form-control cars-highlight-desc-input font-size-11"
                                                    maxlength="15" placeholder="Max.15 charac.."
                                                    value="{{ @$post->ads_highlight_description[$row->setting_highlight_id]  }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Show Voucher</h4>
                        <div>
                            <input name="is_show_ads_voucher" type="checkbox" id="is_show_ads_voucher" value="1" switch="none" {{ (@$post->is_show_ads_voucher == 1) ? 'checked' : '' }} />
                            <label for="is_show_ads_voucher" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Click submit below to post your Ad</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" id="car_color_id" name="car_color_id"
                                           value="{{ @$post->car_color_id }}">
                                    <input type="hidden" id="ads_highlight_ids" name="ads_highlight_ids"
                                           value="{{ @$post->ads_highlight_ids }}">
                                    <input type="hidden" id="setting_ads_id" name="setting_ads_id"
                                           value="{{ @$post->setting_ads_id }}">
                                    <input type="hidden" id="setting_ads_category_id" value="0">
                                    @if(@$ads->ads_status_id != 5 && @$ads->ads_status_id != 6)
                                        <input type="hidden" id="car_request_id" name="car_request_id"
                                               value="{{ @$post->car_request_id }}">
                                    @endif
                                    @if(@$post->id)
                                        <input type="hidden" name="id" value="{{ @$post->id }}">
                                        <input type="hidden" name="encrypt" value="{{ @$post->encrypt }}">
                                    @endif
                                    <p>By posting your ad, you are agreeing to our terms of use and privacy policy.</p>
                                    <button type="submit" name="submit" value="submit"
                                            class="btn btn-company waves-effect waves-light mr-1 submit mb-2 mb-sm-0">
                                        Publish
                                    </button>
                                    @if(!@$ads || @$ads->ads_status_id == 1 || @$ads->ads_status_id == 4)
                                        <button type="submit" name="submit" value="preview"
                                                class="btn cars-yellow-bg-color waves-effect waves-light mr-1 submit mb-2 mb-sm-0">
                                            Save and Preview
                                        </button>
                                    @endif
                                    <a id="cancel" href="{{ route('ads_listing') }}"
                                       class="btn cars-btn-default mb-2 mb-sm-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <!-- find car modal -->
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myModalLabel">Tell us what car you are selling</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Your vehicle will be submitted for moderation and subject to approval.</p>
                            <div class="form-group">
                                <label for="request_car_brand_name">Brand</label>
                                <input type="text" class="form-control" id="request_car_brand_name">
                                <span id="car_brand_name-error" class="text-danger modal-validate"></span>

                            </div>
                            <div class="form-group">
                                <label for="request_car_model_name">Model</label>
                                <input type="text" class="form-control" id="request_car_model_name">
                            <!-- {!! Form::select('car_model_id', $car_model_sel, @$post->car_model_id,  (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'request_car_model_id'] : ['class' => 'form-control', 'id' => 'request_car_model_id', 'disabled'])  ) !!} -->
                                <span id="car_model_name-error" class="text-danger modal-validate"></span>
                            </div>
                            <div class="form-group">
                                <label for="car_request_year">Manufacturing Year </label>
                                <input id="car_request_year" name="car_request_year" class="form-control input-mask"
                                       data-inputmask="'mask': '9', 'repeat': 4, 'greedy' : false">
                                <span id="car_request_year-error" class="text-danger modal-validate"></span>
                            </div>
                            <div class="form-group">
                                <label for="car_request_transmission">Transmission </label>
                                <div class="col-12 btn-group btn-group-toggle mt-2 mt-xl-0 p-0" data-toggle="buttons">
                                    @foreach($car_request_transmission as $val)
                                        <label class="btn btn-find-car" for="car_request_transmission_{{ $val }}">
                                            <input id="car_request_transmission_{{ $val }}" type="radio"
                                                   name="car_request_transmission" class="car_request_transmission"
                                                   value="{{ $val }}" {{ @$post->car_request_transmission == $val ? 'checked' : '' }}>
                                            <span>{{ strtoupper($val) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <span id="car_request_transmission-error" class="text-danger modal-validate"></span>
                            </div>
                            <div class="form-group">
                                <label for="car_request_cc">Engine Capacity </label>
                                <input id="car_request_cc" name="car_request_cc" class="form-control input-mask"
                                       data-inputmask="'mask': '9', 'repeat': 4, 'greedy' : false">
                                <span id="car_request_cc-error"
                                      class="text-danger modal-validate car-request-error"></span>
                            </div>
                            <div class="form-group">
                                <label>Enter your vehicle variant, specification and details.</label>
                                <textarea id="car_request_description" name="car_request_description"
                                          class="form-control" maxlength="1000" rows="10" value=""></textarea>
                                <div class="total-count-container float-right">
                                    <span class="total-count-desc">0</span><span class="count-limit">/1000</span>
                                </div>
                                <span id="car_request_description-error"
                                      class="text-danger modal-validate car-request-error"></span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close
                            </button>
                            <button type="submit" id="" name="submit" value="submit"
                                    class="btn cars-btn-theme-color waves-effect waves-light submit_find_car">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    {{-- <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script> --}}
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/custom.js')}}"></script>
    <script src="{{ URL::asset('assets/js/jquery-ui.js')}}"></script>

    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-preview.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-resize.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-transform.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-crop.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-edit.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-poster.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-exif-orientation.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-validate-size.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond.js')}}"></script>
    <script src="{{ URL::asset('assets/js/doka.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/autosize.js')}}"></script>

    <!-- <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> -->

    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>

    <script src="{{ URL::asset('assets/js/jquery.fancybox.min.js')}}"></script>
    <script>
        $(document).ready(function (e) {
            // autosize(document.querySelectorAll('textarea'));


            $('#field_car_plate_no').val($('#field_car_plate_no').val().replace(/[^0-9a-zA-Z]/g,'').toUpperCase());
            $('#field_car_chassis_no').val($('#field_car_chassis_no').val().replace(/[^0-9a-zA-Z]/g,'').toUpperCase());

            check_car_type('{{ $post->ads_type_id ?? '' }}');

            if ($('#textarea').val()) {
                var scroll = $('#textarea').prop('scrollHeight');

                $('#textarea').css('height', 'auto');
                $('#textarea').css('height', scroll + 'px');

                var txtVal = $('#textarea').val();
                var count_description = countUtf8(txtVal);
                $(".total-count").html(count_description);

                // $(".total-count").html($('#textarea').val().length);
            }

            $('textarea').on('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';

                // $(".total-count").html(this.value.length);

                var txtVal = $('#textarea').val();
                var count_description = countUtf8(txtVal);

                $(".total-count").html(count_description);

            });

            $('#car_request_description').keyup(function () {
                // if(this.value.length > 1000){
                //     return false;
                // }

                // $(".total-count-desc").html(this.value.length);

                var txt_val = $('#car_request_description').val();
                var count_descrip = countUtf8(txt_val);

                $(".total-count-desc").html(count_descrip);
            });

            if ($('#car_variant_id').val() > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_price_guide')}}",
                    data: {
                        car_variant_id: $('#car_variant_id').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            if (e.data['avg'] > 0) {
                                $('#price_guide').show();
                                // $('#lowest_price').text('RM' + e.data['min']);
                                var avg = 'RM' + e.data['avg'];
                                $('#average_price').text('RM' + e.data['avg']);
                                $('#average_price').digits();
                                // $('#highest_price').text('RM' + e.data['max']);
                            }
                        }
                    }
                });
            }

            var ads_highlight_id = [];
            var ads_type_id = '{{ @$post->ads_type_id }}';
            $('#price_guide').hide();

            $('#user_type_id').on('change', function () {

                $('#user_id').html('<option value="">Please select User</option>');
                $('#user_id').attr('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user')}}",
                    data: {
                        user_type_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#user_id').html('<option value="">Please select User</option>');
                            $.each(sorting(e.data), function (key, value) {
                                if (value.key != '') {
                                    $('#user_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                }
                            });
                            $('#user_id').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#user_id').on('change', function () {

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user_template')}}",
                    data: {
                        user_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        $('#user-template').html('');
                        if (e.status == true) {
                            $.each(e.data, function (key, value) {
                                $('#user-template').append('<li class="cars-quick-description-list"><a class="cars-quick-description-element" href="javascript:void(0)" data-template="' + value + '">' + key + '</a></li>');
                            });
                        }
                    }
                });

                {
                    {
                        $.ajax({
                            type: 'POST',
                            url: "{{route('ajax_get_user_contact_details_by_user_id')}}",
                            data: {
                                user_id: $(this).val(),
                                _token: '{{csrf_token()}}'
                            },
                            success: function (e) {
                                if (e.status) {
                                    $('.user-mobile').html('');
                                    $('.user-whatsapp').html('');
                                    $.each(e.data['user_mobile'], function (key, val) {
                                        $('.user-mobile').append('<div class="form-group"><input type="text" class="form-control" name="user_contact_no[]" value="' + val + '" readonly /></div>');
                                    });
                                    $.each(e.data['user_whatsapp'], function (key, val) {
                                        $('.user-whatsapp').append('<div class="form-group"><input type="text" class="form-control" name="user_contact_no_ws[]" value="' + val + '" readonly /></div>');
                                    });
                                } else {
                                    $('.user-mobile').html('<div class="form-group"><input type="text" class="form-control" name="user_mobile" /></div>');
                                    $('.user-whatsapp').html('<div class="form-group"><input type="text" class="form-control" name="user_whatsapp" /></div>');
                                }
                            }
                        });
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_setting_dealer_type_ads')}}",
                    data: {
                        user_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status) {
                            $('.setting-cars').html('');
                            $.each(e.data, function (k, v) {
                                var price = v['ads_setting_price'] > 0 ? parseInt(v['ads_setting_price']) + ' Credit' : 'FREE';
                                var old_price = v['old_price'] ? '<span class="font-size-12" style="text-decoration: line-through;">' + parseInt(v['old_price']) + ' Credit</span>' : '';
                                var validity = v['ads_validity'];

                                if (k === 0) {
                                    $('#setting_ads_id').val(v['setting_ads_id']);
                                    $('#setting_ads_category_id').val(v['setting_ads_category_id']);
                                }

                                $('.setting-cars').append('<div class="col-sm-4">' +
                                    '<div class="card setting-cars-card ' + (k == 0 ? 'active' : '') + '">' +
                                    (
                                        (v['setting_ads_category_id'] == 5) ? '<div class="card-header premier-cars-setting-header">' + v['setting_ads_name'] + '</div>' : '<div class="card-header cars-setting-header">' + v['setting_ads_name'] + '</div>'
                                    ) +
                                    '<div class="card-body setting-cars-validity">' +
                                    '<h3>' + validity + ' days</h3>' +
                                    '</div>' +
                                    '<div class="card-footer bg-transparent border">' +
                                    '<div class="setting-cars-price">' +
                                    '<span class="font-size-18 font-weight-600 cars-text-theme-color">' + price + '</span> &nbsp ' + old_price +
                                    '</div>' +
                                    '<button type="button" class="btn cars-btn-outline-theme-color mt-2 setting-cars-select ' + (k == 0 ? 'active' : '') + '" data-setting_ads_id="' + v['setting_ads_id'] + '" data-setting_ads_category_id="' + v['setting_ads_category_id'] + '"></button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>');
                            });
                        }
                    }
                });
            });

            $('#car_brand_id').on('change', function () {
                var id = $(this).val()
                $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                $('#car_model_group_id').attr('disabled', true);
                $('#car_model_id').html('<option value="">Please select Model</option>');
                $('#car_model_id').attr('disabled', true);
                $('#car_manufacture_year').html('<option value="">Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_model_group')}}",
                    data: {
                        car_brand_id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true && e.is_model_group == true) {
                            $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                            $.each(sorting(e.data), function (key, value) {
                                if (value.key) {
                                    $('#car_model_group_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                }
                            });
                            $('#car_model_group_id').removeAttr('disabled');
                            $('.model_group').show();

                        } else {
                            $.ajax({
                                type: 'POST',
                                url: "{{route('ajax_get_car_model')}}",
                                data: {
                                    car_brand_id: id,
                                    _token: '{{csrf_token()}}'
                                },
                                success: function (e) {
                                    if (e.status == true) {
                                        $('#car_model_id').html('<option value="">Please select Model</option>');
                                        $.each(sorting(e.data), function (key, value) {
                                            if (value.key != '') {
                                                $('#car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                            }
                                        });
                                        $('#car_model_id').removeAttr('disabled');
                                        $('.model_group').hide();
                                    }
                                }
                            });
                        }
                    }
                });
            });

            $('#car_model_group_id').on('change', function () {
                $('#car_model_id').html('<option value="">Please select Model</option>');
                $('#car_model_id').attr('disabled', true);
                $('#car_manufacture_year').html('<option value="">Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_model_for_model_group')}}",
                    data: {
                        car_model_group_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_model_id').html('<option value="">Please select Model</option>');
                            $.each(sorting(e.data), function (key, value) {
                                if (value.key != '') {
                                    $('#car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                }
                            });
                            $('#car_model_id').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_model_id').on('change', function () {
                $('#car_manufacture_year').html('<option value="">Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_manufacture_year')}}",
                    data: {
                        car_model_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_manufacture_year').html('<option value="">Please select Manufacture Year</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {
                                    $('#car_manufacture_year').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_manufacture_year').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_manufacture_year').on('change', function () {
                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_transmission')}}",
                    data: {
                        car_model_id: $('#car_model_id').val(),
                        car_manufacture_year: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {
                                    $('#car_variant_transmission').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_variant_transmission').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_variant_transmission').on('change', function () {
                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_variant_cc')}}",
                    data: {
                        car_model_id: $('#car_model_id').val(),
                        car_manufacture_year: $('#car_manufacture_year').val(),
                        car_variant_transmission: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {
                                    $('#car_variant_cc').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_variant_cc').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_variant_cc').on('change', function () {
                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                $('#car_variant_id').attr('disabled', true);
                $('#ads-title').val('');
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_variant')}}",
                    data: {
                        car_model_id: $('#car_model_id').val(),
                        car_manufacture_year: $('#car_manufacture_year').val(),
                        car_variant_transmission: $('#car_variant_transmission').val(),
                        car_variant_cc: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            // $('#car_variant_id').html('<option value="">Please select Variant</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {

                                    $('#car_variant_id').html('<option value="">Please select Variant</option>');

                                    $.each(sorting(e.data), function (key, value) {
                                        $('#car_variant_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                    });
                                    // $('#car_variant_id').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_variant_id').removeAttr('disabled');
                        }
                    }
                });
            });


             $('#ads_discount').on('input', function () {
                nett_price_calculation();
            });

            $('#ads_price').on('input', function () {
                var value = this.value;
                $('#ads_discount').val('');
                $('#nett_price').val(value);
            });

            function nett_price_calculation() {
                var value = $('#ads_discount').val().replace(',', '');
                var ads_price = $('#ads_price').val().replace(',', '');
                if (parseFloat(value) < parseFloat(ads_price)) {
                    var nett_price = parseFloat(ads_price) - parseFloat(value);
                } else {
                    var nett_price = ads_price;
                }
                $('#nett_price').val(nett_price);
            }
             nett_price_calculation();


            $('#ads_price').inputmask({
                'alias': 'decimal',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'placeholder': '0.00',
                'text-align': 'left',
                'repeat': 8,
                'allowMinus': false
            });

            $('#ads_discount').inputmask({
                'alias': 'decimal',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'placeholder': '0.00',
                'text-align': 'left',
                'repeat': 8,
                'allowMinus': false
            });

            $('#nett_price').inputmask({
                'alias': 'decimal',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'placeholder': '0.00',
                'text-align': 'left',
                'repeat': 8,
                'allowMinus': false
            });

            $('#car_variant_id').on('change', function () {
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');
                $('#ads_highlight_ids').val('');
                if (this.value != '') {
                    var brand = $('#car_brand_id').find('option:selected').text();
                    var model = $('#car_model_id').find('option:selected').text();
                    var year = $('#car_manufacture_year').find('option:selected').text();
                    var variant = $(this).find('option:selected').text();
                    $('#ads-title').val(year + ' ' + brand + ' ' + model + ' ' + variant);

                    // Ads title size
                    // var ads_title_str = year + ' ' + brand + ' ' + model + ' ' + variant;
                    // $('.input-group-prepend').css('width', (ads_title_str.length + 1) * 8 + 'px');
                    // $('.input-group-prepend').css('max-width', '50%');

                    var length_title = $('#ads-title').val().length;
                    var balance = 199 - length_title;
                    $("#ads_title2").attr('maxlength', balance);

                    $.ajax({
                        type: 'POST',
                        url: "{{route('ajax_get_price_guide')}}",
                        data: {
                            car_variant_id: this.value,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (e) {
                            if (e.status == true) {
                                // if(e.data['min'] > 0 || e.data['avg'] > 0 || e.data['max'] > 0) {
                                if (e.data['avg'] > 0) {
                                    $('#price_guide').show();
                                    // $('#lowest_price').text('RM' + e.data['min']);
                                    $('#average_price').text('RM' + e.data['avg']);
                                    $('#average_price').digits();
                                    // $('#highest_price').text('RM' + e.data['max']);
                                }
                            }
                        }
                    });

                    // Select Highlight by Variant
                    $.ajax({
                        type: 'POST',
                        url: "{{route('ajax_get_highlight_by_variant')}}",
                        data: {
                            car_variant_id: this.value,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (e) {
                            if (e.status) {
                                ads_highlight_id = [];

                                $.each(e.data, function (k, v) {
                                    var dataId = $('.cars-highlight-card').attr("data-highlight-id");

                                    $("[data-highlight-id='" + k + "']").addClass('active');

                                    ads_highlight_id.push(k);
                                    $('#ads_highlight_ids').val(ads_highlight_id);
                                });
                            }
                        }
                    });

                } else {
                    $('#ads-title').val('');
                    $('#price_guide').hide();
                }
            });

            var length_title = $('#ads-title').val().length;
            var balance = 199 - length_title;
            $("#ads_title2").attr('maxlength', balance);

            $('.submit_find_car').on('click', function () {
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_find_car')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        car_brand_name: $('#request_car_brand_name').val(),
                        car_model_name: $('#request_car_model_name').val(),
                        car_request_year: $('#car_request_year').val(),
                        car_request_transmission: $('.car_request_transmission:checked').val(),
                        car_request_cc: $('#car_request_cc').val(),
                        car_request_description: $('#car_request_description').val(),
                        car_request_id: $('#car_request_id').val(),
                        ads_id: '{{ @$ads->ads_id }}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            var title = e.data['car_request_year'] + ' ' + e.data['car_brand_name'] + ' ' + e.data['car_model_name'];
                            $('#car-info-title').val(title)
                            $('#ads-title').val(title)
                            $('#car_request_id').val(e.data['car_request_id']);

                            $('.car-info').hide();
                            $('.car-info-title').show();
                            $('#myModal').modal('hide');

                        } else {
                            $.each(e.message, function (key, val) {
                                $('#' + key + '-error').text(val);
                            });
                        }
                    },
                });

            });

            $('#request_car_brand_name').change(function () {
                $('#car_brand_name-error').empty();
            });

            $('#request_car_model_name').change(function () {
                $('#car_model_name-error').empty();
            });

            $('#car_request_year').on('keyup', function () {
                $('#car_request_year-error').empty();
            });

            $('.car_request_transmission').on('click', function () {
                $('#car_request_transmission-error').empty();
            });

            $('#car_request_cc').on('keyup', function () {
                $('#car_request_cc-error').empty();
            });

            $('#car_request_description').on('keyup', function () {
                $('#car_request_description-error').empty();
            });

            $('input:radio[name="ads_type_id"]').on('click', function () {
                check_car_type(this.value);
            });

            function check_car_type(value){
                switch(value) {
                case '1':
                    $("#car_mileage").show();
                    $('#car_chassis_no').hide();
                    $('#car_plate_no').show();
                    $('#vehicle_detail').css("display", "block");
                    break;
                case '2':
                    $("#car_mileage").show();
                    $('#car_chassis_no').show();
                    $('#car_plate_no').hide();
                    $('#vehicle_detail').css("display", "block");
                    break;
                case '3':
                    $("#car_mileage").hide();
                    $('#car_chassis_no').hide();
                    $('#car_plate_no').hide();
                    $('#vehicle_detail').css("display", "none");
                    break;
                default:
                    $("#car_mileage").show();
                    $('#car_chassis_no').hide();
                    $('#car_plate_no').hide();
                    $('#vehicle_detail').css("display", "none");
                }
            }

            $('#setting_state_id').on('change', function () {
                $('#setting_city_id').html('<option value="">Please select City</option>');
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_setting_city')}}",
                    data: {
                        setting_state_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#setting_city_id').html('<option value="">Please select City</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {
                                    $('#setting_city_id').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#setting_city_id').removeAttr('disabled');
                        }
                    }
                });
            });

            $('.cars-color').on('click', function () {
                $('.cars-color').removeClass('active');
                $('#car_color_id').val(this.id);
                $(this).addClass('active');
            });

            $('.cars-quick-desc').on('click', '.cars-quick-description-element', function () {
                var textarea = $('#textarea').val();
                var template = $(this).data('template');
                var count = textarea + template;

                $('textarea').val(textarea + template + '\n');
                var scroll = $('#textarea').prop('scrollHeight');

                $('#textarea').css('height', 'auto');
                $('#textarea').css('height', scroll + 'px');
                // $('#textarea').setFunction();
                // $(".total-count").html(count);

                var count_description = countUtf8(count);
                $(".total-count").html(count_description);
            });

            // var ads_highlight_id = [];
            if ($('#ads_highlight_ids').val()) {
                var res = $('#ads_highlight_ids').val().split(',');
                $.each(res, function (i, j) {
                    ads_highlight_id.push(j);
                });
            }
            $('.cars-highlight-card').bind('mousedown', function (e) {
                var id = $(this).data('highlight-id');
                if ($(this).hasClass('active')) {
                    $.each(ads_highlight_id, function (i, val) {
                        if (val == id) {
                            ads_highlight_id.splice(i, 1);
                        }
                    });
                    $(this).removeClass('active');
                } else {
                    ads_highlight_id.push(id);
                    $(this).addClass('active');
                }
                $('#ads_highlight_ids').val(ads_highlight_id);
            });

            var setting_ads_id = '{{ @$post->setting_ads_id }}';
            if (setting_ads_id == '') {
                $('#setting_ads_id').val($('.setting-cars-card.active').find('.setting-cars-select').data('setting_ads_id'));
            }

            $('#setting_ads_category_id').val($(this).find('.setting-cars-select.active').data('setting_ads_category_id'));

            $('.setting-cars').on('click', '.setting-cars-card', function () {
                $('.setting-cars-card').removeClass('active');
                $('.setting-cars-select').removeClass('active');

                $(this).addClass('active');
                $('#setting_ads_id').val($(this).find('.setting-cars-select').data('setting_ads_id'));
                $('#setting_ads_category_id').val($(this).find('.setting-cars-select').data('setting_ads_category_id'));
                $(this).find('.setting-cars-select').addClass('active');

                check_discount_field();
            });

            function check_discount_field() {
                if ($('#setting_ads_category_id').val() === "5") {
                    $('#field_ads_nett_selling_price').show();
                    $('#field_ads_discount').show();
                    $('#field_ads_check_box').hide();
                    $('#field_ads_check_box_disabled').show();
                } else {
                    $('#field_ads_nett_selling_price').hide();
                    $('#field_ads_discount').hide();
                    $('#field_ads_check_box').show();
                    $('#field_ads_check_box_disabled').hide();
                }
            }

            check_discount_field();


            $('#cars-quick-search').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("ajax_get_car_info_by_keyword") }}',
                        data: {
                            _token: '{{csrf_token()}}',
                            car_keyword: request.term
                        },
                        success: function (e) {
                            var car_list = []

                            for (var key in e.data) {
                                car_list.push({
                                    'value': e.data[key].car_name,
                                    'car_brand_id': e.data[key].car_brand_id,
                                    'car_model_group_id': e.data[key].car_model_group_id,
                                    'car_model_id': e.data[key].car_model_id,
                                    'car_variant_id': e.data[key].car_variant_id,
                                    'car_variant_year': e.data[key].car_variant_year,
                                    'car_variant_transmission': e.data[key].car_variant_transmission,
                                    'car_variant_cc': e.data[key].car_variant_cc
                                })
                            }
                            response(car_list);
                        }
                    });
                },
                select: function (event, ui) {
                    $.when(
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("ajax_get_car_info") }}',
                            data: {
                                _token: '{{csrf_token()}}',
                                car_brand_id: ui.item.car_brand_id,
                                car_model_group_id: ui.item.car_model_group_id,
                                car_model_id: ui.item.car_model_id,
                                car_variant_year: ui.item.car_variant_year,
                                car_variant_transmission: ui.item.car_variant_transmission,
                                car_variant_cc: ui.item.car_variant_cc,
                                car_variant_id: ui.item.car_variant_id
                            },
                            success: function (e) {
                                $('#car_brand_id').val(ui.item.car_brand_id);

                                if (e.data['car_model_group_sel'] && e.data['car_model_group_sel'].length == undefined) {

                                    $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                                    $.each(sorting(e.data['car_model_group_sel']), function (key, val) {
                                        if (val.key) {
                                            var selected = (val.key == ui.item.car_model_group_id) ? 'selected' : ''
                                            $('#car_model_group_id').append('<option value="' + val.key + '" ' + selected + '>' + val.value + '</option>');
                                        }
                                    });
                                    $('#car_model_group_id').removeAttr('disabled');
                                    $('.model_group').show();
                                } else {
                                    $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                                    $('#car_model_group_id').attr('disabled', true);
                                    $('.model_group').hide();
                                }

                                $('#car_model_id').html('<option value="">Please select Model</option>');
                                $.each(sorting(e.data['car_model_sel']), function (key, val) {
                                    var selected = (val.key == ui.item.car_model_id) ? 'selected' : ''
                                    $('#car_model_id').append('<option value="' + val.key + '" ' + selected + ' >' + val.value + '</option>');
                                })
                                $('#car_model_id').removeAttr('disabled');

                                $('#car_manufacture_year').html('<option value="">Please select Manufactured Year</option>');
                                $.each(sorting(e.data['car_variant_year_sel']).reverse(), function (key, val) {
                                    if (val.key) {
                                        var selected = (val.key == ui.item.car_variant_year) ? 'selected' : ''
                                        $('#car_manufacture_year').append('<option value="' + val.key + '" ' + selected + ' >' + val.value + '</option>');
                                    }
                                })
                                $('#car_manufacture_year').removeAttr('disabled');

                                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                                $.each(e.data['car_variant_transmission_sel'], function (key, value) {
                                    if (key) {
                                        var selected = (key == ui.item.car_variant_transmission) ? 'selected' : ''
                                        $('#car_variant_transmission').append('<option value="' + key + '" ' + selected + ' >' + value + '</option>');
                                    }
                                })
                                $('#car_variant_transmission').removeAttr('disabled');

                                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                                $.each(e.data['car_variant_cc_sel'], function (key, value) {
                                    if (key) {
                                        var selected = (key == ui.item.car_variant_cc) ? 'selected' : ''
                                        $('#car_variant_cc').append('<option value="' + key + '" ' + selected + ' >' + value + '</option>');
                                    }
                                })
                                $('#car_variant_cc').removeAttr('disabled');

                                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                                $.each(sorting(e.data['car_variant_sel']), function (key, val) {
                                    if (val.key) {
                                        var selected = (val.key == ui.item.car_variant_id) ? 'selected' : ''
                                        $('#car_variant_id').append('<option value="' + val.key + '" ' + selected + ' >' + val.value + '</option>');
                                    }
                                })
                                $('#car_variant_id').removeAttr('disabled');
                            }
                        })
                    ).then(function () {
                        $('#car_variant_id').val(ui.item.car_variant_id).change();
                    });
                }
            });

            $('.cancel-car-request').on('click', function () {
                $('#car_request_id').val('');
                $('#ads-title').val('');
                $('.car-info-title').hide();
                $('.car-info').show();
            });

            // price to comma format
            $.fn.digits = function () {
                return this.each(function () {
                    $(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                })
            }

            // disabled all 3 button after submit
            $('.submit').on('click', function (e) {
                var ready = 0;
                var processing = 0;
                $.each(pondCarImages.getFiles(), function (key, val) {
                    switch (val.status) {
                        case 3: // processing
                        case 9: // queue
                            processing++;
                            break;
                        case 5:
                            ready++;
                            break;
                    }
                });

                if (processing == 0 && ready >= 5 && (pondCarRegistrationCard.getFile() ? pondCarRegistrationCard.getFile().status == 5 : true) && (pondCarVideo.getFile() ? pondCarVideo.getFile().status == 5 : true)) {
                    $('#ads_form').submit(function () {
                        $(this).find('button[type=submit]').prop('disabled', true);
                    });
                    $('#cancel').click(function (e) {
                        e.preventDefault();
                    }); // disabled cancel link
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'submit',
                        value: this.value
                    }).appendTo('#ads_form');
                } else if (processing == 0 && ready < 5) {
                    Swal.fire({
                        title: 'Validation Error',
                        text: 'The Car Pictures must be uploaded at least 5 images.',
                        type: 'warning',
                        confirmButtonText: 'Close'
                    });
                    return false;
                    e.preventDefault();
                } else {
                    Swal.fire({
                        title: 'Upload in progress',
                        text: 'Please wait for upload to complete.',
                        type: 'warning',
                        confirmButtonText: 'Close'
                    });
                    return false;
                    e.preventDefault();
                }

                // if(pondCarRegistrationCard.getFile().status != 5){
                //     Swal.fire({
                //         title: 'Upload in progress',
                //         text: 'Please wait for upload to complete.',
                //         type: 'warning',
                //         confirmButtonText: 'Close'
                //     });
                //     return false;
                //     e.preventDefault();
                // }
            });
        });

        function countUtf8(str) {
            var point;
            var index;
            var width = 0;
            var len = 0;
            for (index = 0; index < str.length;) {
                point = str.codePointAt(index);
                width = 0;
                while (point) {
                    width += 1;
                    point = point >> 8;
                }
                index += Math.round(width / 2);
                len += 1;
            }
            return len;
        }

        function sorting(data) {
            var sorted = [];
            $(data).each(function (k, v) {
                for (var key in v) {
                    sorted.push({
                        key: key,
                        value: v[key]
                    })
                }
            });

            return sorted.sort(function (a, b) {
                if (a.value < b.value) return -1;
                if (a.value > b.value) return 1;
                return 0;
            });
        }

        function getUnique(array) {
            var uniqueArray = [];

            // Loop through array values
            for (var value of array) {
                if (uniqueArray.indexOf(value) === -1) {
                    uniqueArray.push(value);
                }
            }
            return uniqueArray;
        }

        // register the plugins with FilePond
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageCrop,
            FilePondPluginImageEdit,
            FilePondPluginFilePoster,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );

        var pondMultipleTimeout;
        const inputCarImages = document.querySelector('#upload-car-images');
        const pondCarImages = FilePond.create(inputCarImages, {
            // imageCropAspectRatio: '4:3',
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            maxFiles: 30,
            maxFileSize: '40MB',
            allowMultiple: true,
            imagePreviewHeight: 150,
            allowImageResize: true,
            imageResizeTargetWidth: 1200,
            imageResizeMode: 'contain',
            filePosterHeight: 150,
            // stylePanelAspectRatio:'4:3',
            styleButtonRemoveItemPosition: 'right',
            styleImageEditButtonEditItemPosition: 'bottom right',
            allowImageEdit: true,
            itemInsertLocation: 'after',

            // configure Doka
            imageEditEditor: Doka.create({
                cropAspectRatioOptions: [{
                    label: 'Free',
                    value: null
                },
                    {
                        label: 'Portrait',
                        value: 1.25
                    },
                    {
                        label: 'Square',
                        value: 1
                    },
                    {
                        label: 'Landscape',
                        value: .75
                    }
                ],
            }),
            // imageTransformOutputMimeType: 'image/jpeg',
            insertAfter: (element) => {

            },
            onwarning: () => {
                var container = document.querySelector('.car-images-filepond');
                var error = container.querySelector('p.filepond--warning');
                if (!error) {
                    error = document.createElement('p');
                    error.className = 'filepond--warning';
                    error.textContent = 'The maximum number of files is ' + pondCarImages.maxFiles;
                    container.appendChild(error);
                }
                requestAnimationFrame(function () {
                    error.dataset.state = 'visible';
                });
                clearTimeout(pondMultipleTimeout);
                pondMultipleTimeout = setTimeout(function () {
                    error.dataset.state = 'hidden';
                }, 5000);
            },
            onupdatefiles: (files) => {
                if (files[0]) {
                    $(".filepond--list li").removeClass('main-image');
                    $("#filepond--item-" + files[0].id).addClass('main-image');
                }
            },
            onreorderfiles: (files, origin, target) => {
                if (origin == 0) {
                    $(".filepond--list li").removeClass('main-image');
                    $("#filepond--item-" + files[0].id).addClass('main-image');
                }
                if (target == 0) {
                    $(".filepond--list li").removeClass('main-image');
                    $("#filepond--item-" + files[target].id).addClass('main-image');
                }
                if (origin != 0 && origin != 0) {
                    $(".filepond--list li").removeClass('main-image');
                    $("#filepond--item-" + files[0].id).addClass('main-image');
                }
            },
            onremovefile(error, file) {
                var id = file.serverId;
                if (id) {
                    $.ajax({
                        url: "{{ route('ajax_remove_ads_images') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (e) {
                            if (e.status) {

                            }
                        }
                    })
                }
            },
            files: [
                    <?php
                    if (@$post->ads_img_detail && count(@$post->ads_img_detail) > 0) {
                    foreach ($post->ads_img_detail as $file) {
                    ?> {
                    // the server file reference
                    source: '{{ @$file->id }}',

                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',

                        // stub file information
                        file: {
                            name: '{{ @$file->file_name }}',
                            size: '{{ @$file->size }}',
                            type: '{{ @$file->mime_type }}'
                        },

                        // pass poster property
                        metadata: {
                            poster: '{{ @$file->hasGeneratedConversion("full") ? $file->getUrl("full") : $file->getUrl() }}'
                        }
                    }
                },
                <?php
                }
                }
                ?>
            ]
        });

        pondCarImages.setOptions({
            server: {
                process: {
                    url: "{{ route('ajax_upload_car_image') }}",
                    method: 'POST',
                    withCredentials: false,
                    headers: {},
                    onload: (response) => {
                        var e = JSON.parse(response);
                        if (e.img_id) {
                            return e.img_id;
                        }
                    },
                    onerror: (response) => response.data,
                    ondata: (formData) => {
                        var id = '{{ @$ads->ads_id ?? @$post->id }}';
                        var encrypt = '{{ @$post->id ? $post->encrypt : "" }}';
                        var action = '{{ @$ads->ads_id ? 2 : 1 }}';
                        var dealer_id = $('#user_id option:selected').val();
                        formData.append('id', id);
                        formData.append('encrypt', encrypt);
                        formData.append('action', action);
                        formData.append('_token', '{{csrf_token()}}');
                        formData.append('dealer_id', dealer_id);
                        return formData;
                    }
                },
                revert: {
                    url: "{{ route('ajax_revert_car_image') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    onload: function (response) {
                        var e = JSON.parse(response);
                        if (e.status) {

                        }
                    },
                },
            }
        });

        const inputCarRegistrationCard = document.querySelector('#upload-car-registration-card');
        const pondCarRegistrationCard = FilePond.create(inputCarRegistrationCard, {
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            maxFileSize: '5MB',
            imagePreviewHeight: 150,
            allowImageResize: true,
            imageResizeTargetWidth: 1200,
            imageResizeMode: 'contain',
            filePosterHeight: 150,
            styleButtonRemoveItemPosition: 'right',
            styleImageEditButtonEditItemPosition: 'bottom right',
            allowImageEdit: true,

            // configure Doka
            imageEditEditor: Doka.create({
                cropAspectRatioOptions: [{
                    label: 'Free',
                    value: null
                },
                    {
                        label: 'Portrait',
                        value: 1.25
                    },
                    {
                        label: 'Square',
                        value: 1
                    },
                    {
                        label: 'Landscape',
                        value: .75
                    }
                ],
            }),

            onremovefile(error, file) {
                var id = file.serverId;
                if (id) {
                    $.ajax({
                        url: "{{ route('ajax_remove_ads_images') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (e) {
                            if (e.status) {

                            }
                        }
                    })
                }
            },
            files: [
                    <?php if (@$post->car_registration_card_image) { ?> {
                    // the server file reference
                    source: '{{ @$post->car_registration_card_image->id }}',

                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',

                        // stub file information
                        file: {
                            name: '{{ @$post->car_registration_card_image->file_name }}',
                            size: '{{ @$post->car_registration_card_image->size }}',
                            type: '{{ @$post->car_registration_card_image->mime_type }}'
                        },

                        // pass poster property
                        metadata: {
                            poster: '{{ @$post->car_registration_card_image ? $post->car_registration_card_image->getUrl(): "" }}'
                        }
                    }
                },
                <?php } ?>
            ]
        });

        pondCarRegistrationCard.setOptions({
            server: {
                process: {
                    url: "{{ route('ajax_upload_car_registration_card') }}",
                    method: 'POST',
                    withCredentials: false,
                    headers: {},
                    onload: (response) => {
                        var e = JSON.parse(response);
                        if (e.img_id) {
                            return e.img_id;
                        }
                    },
                    onerror: (response) => response.data,
                    ondata: (formData) => {
                        var id = '{{ @$ads->ads_id ?? @$post->id }}';
                        var encrypt = '{{ @$post->id ? $post->encrypt : "" }}';
                        var action = '{{ @$ads->ads_id ? 2 : 1 }}';
                        formData.append('id', id);
                        formData.append('encrypt', encrypt);
                        formData.append('action', action);
                        formData.append('_token', '{{csrf_token()}}');
                        return formData;
                    }
                },
                revert: {
                    url: "{{ route('ajax_revert_car_image') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    onload: function (response) {
                        var e = JSON.parse(response);
                        if (e.status) {

                        }
                    },
                },
            }
        });

        const inputCarVideo = document.querySelector('#upload-car-video');
        const pondCarVideo = FilePond.create(inputCarVideo, {
            acceptedFileTypes: ['video/*'],
            maxFileSize: '50MB',
            imagePreviewHeight: 150,
            allowFileEncode: true,
            filePosterHeight: 150,
            styleButtonRemoveItemPosition: 'right',

            onactivatefile: function (file) {
                if (pondCarVideo.getFile().status == 5) {
                    var temp_fancybox = $.fancybox.open({
                        href: '',
                        type: 'iframe'
                    });

                    var href;
                    $.ajax({
                        url: "{{ route('ajax_get_media_by_id') }}",
                        method: 'POST',
                        data: {
                            id: file.serverId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (e) {
                            // if(e.status){
                            $.fancybox.destroy();
                            href = e.data['url'];
                            // }
                            $.fancybox.open({
                                src: href,
                                width: 800,
                                height: 600,
                            });
                        }
                    });
                }
            },

            onremovefile(error, file) {
                var id = file.serverId;
                if (id) {
                    $.ajax({
                        url: "{{ route('ajax_remove_ads_images') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (e) {
                            if (e.status) {

                            }
                        }
                    })
                }
            },
            files: [
                    <?php if (@$post->car_video_detail) { ?> {
                    // the server file reference
                    source: '{{ @$post->car_video_detail->id }}',

                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',

                        // stub file information
                        file: {
                            name: '{{ @$post->car_video_detail->name }}',
                            size: '{{ @$post->car_video_detail->size }}',
                            type: '{{ @$post->car_video_detail->mime_type }}'
                        },

                        // pass poster property
                        metadata: {
                            poster: '{{ @$post->car_video_detail ? $post->car_video_detail->getUrl("thumbnail"): "" }}'
                        }
                    }
                },
                <?php } ?>
            ]
        });

        pondCarVideo.setOptions({
            server: {
                process: {
                    url: "{{ route('ajax_upload_car_video') }}",
                    method: 'POST',
                    withCredentials: false,
                    headers: {},
                    // timeout: 7000,
                    onload: (response) => {
                        var e = JSON.parse(response);
                        // change video thumb using conversion thumbnail
                        $('#upload-car-video .filepond--file').append('<div class="filepond--image-preview-wrapper"><div class="filepond--image-preview-overlay filepond--image-preview-overlay-idle" style="opacity:.25;pointer-events:none"><svg width="500" height="200" viewBox="0 0 500 200" preserveAspectRatio="none"><defs><radialGradient id="gradient-1" cx=".5" cy="1.25" r="1.15"><stop offset="50%" stop-color="#000000"></stop><stop offset="56%" stop-color="#0a0a0a"></stop><stop offset="63%" stop-color="#262626"></stop><stop offset="69%" stop-color="#4f4f4f"></stop><stop offset="75%" stop-color="#808080"></stop><stop offset="81%" stop-color="#b1b1b1"></stop><stop offset="88%" stop-color="#dadada"></stop><stop offset="94%" stop-color="#f6f6f6"></stop><stop offset="100%" stop-color="#ffffff"></stop></radialGradient><mask id="mask-1"><rect x="0" y="0" width="500" height="200" fill="url(#gradient-1)"></rect></mask></defs><rect x="0" width="500" height="200" fill="currentColor" mask="url(#mask-1)"></rect></svg></div><div class="filepond--image-preview-overlay filepond--image-preview-overlay-success" style="opacity:1"><svg width="500" height="200" viewBox="0 0 500 200" preserveAspectRatio="none"><defs><radialGradient id="gradient-2" cx=".5" cy="1.25" r="1.15"><stop offset="50%" stop-color="#000000"></stop><stop offset="56%" stop-color="#0a0a0a"></stop><stop offset="63%" stop-color="#262626"></stop><stop offset="69%" stop-color="#4f4f4f"></stop><stop offset="75%" stop-color="#808080"></stop><stop offset="81%" stop-color="#b1b1b1"></stop><stop offset="88%" stop-color="#dadada"></stop><stop offset="94%" stop-color="#f6f6f6"></stop><stop offset="100%" stop-color="#ffffff"></stop></radialGradient><mask id="mask-2"><rect x="0" y="0" width="500" height="200" fill="url(#gradient-2)"></rect></mask></defs><rect x="0" width="500" height="200" fill="currentColor" mask="url(#mask-2)"></rect></svg></div><div class="filepond--image-preview-overlay filepond--image-preview-overlay-failure" style="opacity:0;visibility:hidden;pointer-events:none"><svg width="500" height="200" viewBox="0 0 500 200" preserveAspectRatio="none"><defs><radialGradient id="gradient-3" cx=".5" cy="1.25" r="1.15"><stop offset="50%" stop-color="#000000"></stop><stop offset="56%" stop-color="#0a0a0a"></stop><stop offset="63%" stop-color="#262626"></stop><stop offset="69%" stop-color="#4f4f4f"></stop><stop offset="75%" stop-color="#808080"></stop><stop offset="81%" stop-color="#b1b1b1"></stop><stop offset="88%" stop-color="#dadada"></stop><stop offset="94%" stop-color="#f6f6f6"></stop><stop offset="100%" stop-color="#ffffff"></stop></radialGradient><mask id="mask-3"><rect x="0" y="0" width="500" height="200" fill="url(#gradient-3)"></rect></mask></defs><rect x="0" width="500" height="200" fill="currentColor" mask="url(#mask-3)"></rect></svg></div><div class="filepond--image-preview" style="transform:translate3d(0,0,0) scale3d(1,1,1);opacity:1"><div class="filepond--image-clip" style="opacity:1;height:150px;width:177.5px"><div class="filepond--image-canvas-wrapper" style="transform-origin:177.5px 150px;transform:translate3d(-88.75px,-75px,0) scale3d(.5,.5,1) rotateZ(6.28319rad);opacity:1;height:300px;width:355px"><img class="w-100 h-100" src="' + e.video_url + '"></div></div></div></div>');

                        if (e.video_id) {
                            return e.video_id;
                        }
                    },
                    onerror: (response) => response.data,
                    ondata: (formData) => {
                        var id = '{{ @$ads->ads_id ?? @$post->id }}';
                        var encrypt = '{{ @$post->id ? $post->encrypt : "" }}';
                        var action = '{{ @$ads->ads_id ? 2 : 1 }}';
                        formData.append('id', id);
                        formData.append('encrypt', encrypt);
                        formData.append('action', action);
                        var ads_id = '{{ @$ads->ads_id }}';
                        formData.append('_token', '{{csrf_token()}}');
                        return formData;
                    }
                },
                revert: {
                    url: "{{ route('ajax_revert_car_image') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                },
            }
        });
    </script>
@endsection
