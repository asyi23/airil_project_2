@extends('layouts.master')

@section('title') {{ $title }} Ads @endsection

@section('css') 
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.css')}}">
@endsection
@section('content')
<!-- start page title -->
<!-- <div class="container"> -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $title }} Ads</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Ads</a>
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
                    <x-user-credit-balance :userId="@$post->user_id" userIdField="user_id" />
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Car details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="car-info">
                                <div class="form-group ui-widget">
                                    <label for="quick-search" class="col-form-label">Search</label>
                                    <input class="form-control" type="search" placeholder="Eg: 2020 Toyota Yaris" id="cars-quick-search">
                                </div>
                                <div class="form-group">
                                    <label for="car_brand_id">BRAND <span class="text-danger">*</span></label>
                                    {!! Form::select('car_brand_id', $car_brand_sel, @$post->car_brand_id, ['class' => 'form-control', 'id' => 'car_brand_id']) !!}
                                </div>   
                                <div class="form-group model_group" @if( !@$post->car_model_group_id ) style="display: none" @endif }}>
                                    <label for="car_model_group_id">MODEL GROUP <span class="text-danger" >*</span></label>
                                    {!! Form::select('car_model_group_id', $car_model_group_sel, @$post->car_model_group_id,  (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'car_model_group_id'] : ['class' => 'form-control', 'id' => 'car_model_group_id', 'disabled'])  ) !!}
                                </div> 
                                <div class="form-group">
                                    <label for="car_model_id">MODEL <span class="text-danger">*</span></label>
                                    {!! Form::select('car_model_id', $car_model_sel, @$post->car_model_id,  (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'car_model_id'] : ['class' => 'form-control', 'id' => 'car_model_id', 'disabled'])  ) !!}
                                </div> 
                                <div class="form-group">
                                    <label for="car_manufacture_year">MANUFACTURING YEAR <span class="text-danger">*</span></label>
                                    {!! Form::select('car_manufacture_year', $car_manufacture_year_sel, @$post->car_manufacture_year, (@$post->car_model_id ? ['class' => 'form-control', 'id' => 'car_manufacture_year'] : ['class' => 'form-control', 'id' => 'car_manufacture_year', 'disabled']) ) !!}
                                </div>  
                                
                                <div class="form-group">
                                    <label for="car_variant_transmission">TRANSMISSION <span class="text-danger">*</span></label>
                                    {!! Form::select('car_variant_transmission', $car_variant_transmission_sel, @$post->car_variant_transmission, (@$post->car_manufacture_year ? ['class' => 'form-control', 'id' => 'car_variant_transmission'] : ['class' => 'form-control', 'id' => 'car_variant_transmission', 'disabled']) ) !!}
                                </div>  
                                <div class="form-group">
                                    <label for="car_variant_cc">ENGINE CAPACITY (CC) <span class="text-danger">*</span></label>
                                    {!! Form::select('car_variant_cc', $car_variant_cc_sel, @$post->car_variant_cc, (@$post->car_variant_transmission ? ['class' => 'form-control', 'id' => 'car_variant_cc'] : ['class' => 'form-control', 'id' => 'car_variant_cc', 'disabled']) ) !!}
                                </div>  
                                <div class="form-group">
                                    <label for="car_variant_id">VARIANT <span class="text-danger">*</span></label>
                                    {!! Form::select('car_variant_id', $car_variant_sel, @$post->car_variant_id, (@$post->car_variant_cc ? ['class' => 'form-control', 'id' => 'car_variant_id'] : ['class' => 'form-control', 'id' => 'car_variant_id', 'disabled']) ) !!}
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Car Pictures <span class="text-danger">*</span></h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> 
                                <div id="ads-images-dropzone" class="cars-dropzone">
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                        </div>                                        
                                        <h4>Drop files here or click to upload.</h4>
                                        <label for="ads_files" class="btn cars-btn-theme-color waves-effect waves-light">Upload Photos</label>
                                    </div>                                    
                                </div>                                
                                <input type="file" id="ads_files" name="ads_files" class="d-none" accept="image/x-png,image/gif,image/jpeg" multiple/>
                                <div id="ads_files_error"></div>        
                                <?php  

                                    $preview = '';
                                    $display = '';

                                    if(isset($ads) && @$ads->hasMedia('ads_images')) {    

                                        $img_preview = ''; 
                                        $img_preview_main = '';  

                                        foreach($ads->getMedia('ads_images') as $key => $val){     

                                            if($val->id != $ads->ads_thumbnail_id){

                                                $img_preview .= '<div class="preview-image" data-img_id="'. $val->id .'" style="background-image: url(' . $val->getUrl('thumb') . ')"><a href="javascript:void(0)" class="set-main-img">Set As Main</a><a href="javascript:void(0)" class="preview-remove-btn remove"><i class="mdi mdi-close-circle preview-remove-btn-icon"></i></a></div>';
                                            
                                            } else {

                                                $img_preview_main = '<div class="preview-image main_photo" data-img_id="'. $val->id .'" style="background-image: url(' . $val->getUrl('thumb') . ')"><span class="cars-main-img">Main Image</span><a href="javascript:void(0)" class="preview-remove-btn remove"><i class="mdi mdi-close-circle preview-remove-btn-icon"></i></a></div>';
                                            
                                            }

                                            $preview = $img_preview_main . $img_preview;
                                        }
                                        
                                    } elseif(isset($post) && @$post->temp_ads_images) {

                                        $img_preview = ''; 
                                        $img_preview_main = ''; 

                                        foreach($post->temp_ads_images as $key => $val){     

                                            if($val->id != $post->ads_thumbnail_id){

                                                $img_preview .= '<div class="preview-image" data-img_id="'. $val->id .'" style="background-image: url(' . $val->getUrl() . ')"><a href="javascript:void(0)" class="set-main-img">Set As Main</a><a href="javascript:void(0)" class="preview-remove-btn remove"><i class="mdi mdi-close-circle preview-remove-btn-icon"></i></a></div>';
                                            
                                            } else {

                                                $img_preview_main = '<div class="preview-image main_photo" data-img_id="'. $val->id .'" style="background-image: url(' . $val->getUrl() . ')"><span class="cars-main-img">Main Image</span><a href="javascript:void(0)" class="preview-remove-btn remove"><i class="mdi mdi-close-circle preview-remove-btn-icon"></i></a></div>';
                                            
                                            }                                                                                     
                                        }

                                        $preview = $img_preview_main . $img_preview;                                        
                                    
                                    } else {          

                                        $display = 'style="display: none;"';   
                                    }
                                    ?>
                                <div id='loading_ads_images' class="loadingmessage" style='display:none'>
                                    <img src='{{ URL::asset('assets/images/loading.gif')}}'/>
                                </div>
                                <div id="preview_ads_images" class="preview-container mt-4" {!! $display !!}>  
                                    {!! $preview !!} 
                                </div>
                            </div>
                            
                        </div>  
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Car Registration Card</h4>
                    <div class="row">
                        <div class="col-sm-12">    
                            <div class="form-group mb-0"> 
                                <div id="registration_card_temp_container" class="mb-1" @if(!@$post->registration_card_temp_image) style="display: none;" @endif>
                                    <img id="registration_card_temp_image" src="{{ @$post->registration_card_temp_image ? $post->registration_card_temp_image->getUrl() : '' }}" width="50" height="50">
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
            </div>
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Car details</h4> --}}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="car-info-title" style="display: none;">
                                <div class="form-group">
                                    <div class="input-group car-info-title-detail">
                                        <div class="input-group-prepend">
                                            <input type="button" value="Cancel Request" class="btn cancel-car-request">
                                        </div>
                                        <input type="text" class="form-control" id="car-info-title" readonly>   
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ads_type">CAR TYPE <span class="text-danger">*</span></label>
                                <div class="row col-sm-12">
                                    @foreach($ads_type as $row)
                                        <div class="col-4 col-sm-4">
                                            <div class="custom-control admin-custom-radio mb-3">
                                                <input id="ads_type_id_{{ $row->ads_type_id }}" type="radio" name="ads_type_id" class="admin-custom-control-input" value="{{$row->ads_type_id}}" {{ @$post->ads_type_id == $row->ads_type_id ? 'checked' : '' }}>
                                                <label class="admin-custom-control-label" for="ads_type_id_{{ $row->ads_type_id }}">
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
                                                <input id="assemble_type_{{ $val }}" type="radio" name="assemble_type" class="admin-custom-control-input" value="{{ $val }}" {{ @$post->assemble_type == $val ? 'checked' : '' }}>
                                                <label class="admin-custom-control-label" for="assemble_type_{{ $val }}">
                                                    {{ strtoupper($val) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>  
                            <div class="form-group" id="car_mileage" @if(@$post->ads_type_id == 3 || @$post->ads_type_id == 0) style="display:none" @endif>
                                <label for="car_mileage_id">MILEAGE <span class="text-danger">*</span></label>
                                {!! Form::select('car_mileage_id', $car_mileage_sel, @$post->car_mileage_id, ['class' => 'form-control', 'id' => 'car_mileage_id'] ) !!}
                            </div> 
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="car_color_id">COLOR <span class="text-danger">*</span></label>
                                <!-- <ul class="cars-ul-car-color">
                                {{-- @foreach($car_color as $row)
                                    <li class="cars-li-car-color" >
                                        <div id="{{ $row->car_color_id }}" class="cars-color @if(@$post->car_color_id == $row->car_color_id) active @endif">
                                            <span class="cars-color-code" style="background-color:<?php //echo $row->car_color_code; ?>;">
                                            </span>
                                            <p>{{ $row->car_color_name }}</p>
                                        </div>
                                    </li>
                                @endforeach --}}
                                </ul> -->
                                <div class="row">
                                    @foreach($car_color as $row)
                                        <div class="col-3 col-md-1 pl-0 pr-0">
                                            <div id="{{ $row->car_color_id }}" class="cars-color @if(@$post->car_color_id == $row->car_color_id) active @endif">
                                            <span class="cars-color-code" style="background-color: {{ $row->car_color_code }}">
                                            </span>
                                            <p>{{ $row->car_color_name }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>  
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group" id="car_chassis_no">
                                <label for="car_chassis_no">VEHICLE CHASSIS NUMBER</label>
                                <input type="text" name="car_chassis_no" class="form-control" value="{{ @$post->car_chassis_no }}">
                                <span>This will not be published</span>
                            </div>  
                            <div class="form-group" id="car_plate_no" style="display:none">
                                <label for="car_plate_no">PLATE NUMBER</label>
                                <input type="text" name="car_plate_no" class="form-control" value="{{ @$post->car_plate_no }}">
                                <span>This will not be published</span>
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="car_reference_no">REFERENCE NUMBER</label>
                                <input type="text" name="car_reference_no" class="form-control" value="{{ @$post->car_reference_no }}">
                                <span>This will not be published</span>
                            </div>  
                        </div>
                        <div class="col-sm-6" id="price_guide">
                            <!-- <div class="form-group">
                                <label for="price_guide">PRICE GUIDE</label>
                                {!! Form::select('price_guide_period', $price_guide_period, @$post->price_guide_period, ['class' => 'form-control', 'id' => 'price_guide_period'] ) !!}                            
                            </div>  -->
                            <div class="form-group">
                                <table class="table table-bordered" style="width: 100%">
                                    <tr align="center">
                                        <!-- <td class="m-0 p-2">
                                            <span>Average Low</span>
                                            <h5 id="lowest_price"></h5>
                                        </td> -->
                                        <td class="m-0 p-2">
                                            <span>Average Price</span>
                                            <h5 id="average_price"></h5>
                                        </td>
                                        <!-- <td class="m-0 p-2">
                                            <span>Average High</span>
                                            <h5 id="highest_price"></h5>
                                        </td> -->
                                    </tr>                                    
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ads_price">SELLING PRICE <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input id="ads_price" name="ads_price" class="form-control text-left" type="text" value="{{ @$post->ads_price }}">                                    
                                </div>                                                                
                            </div>  
                            <div class="form-group">
                                <label for="ads_title">TITLE</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <input class="form-control input-group-text no-outline" id="ads-title" name="ads_title" value="{{ @$post->ads_title }}" readonly>
                                    </div>
                                <input id="ads_title2" type="text" class="form-control" name="ads_title2" value="{{ @$post->ads_title2 }}">
                                </div>
                            </div>  
                            
                        </div>
                    </div>
                    <div class="row cars-quick-desc">
                        
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <label>SELLER POST <span class="text-danger">*</span></label>
                                <p>Sell your car faster by letting buyers know what makes your car unique.</p>
                                <textarea id="textarea" name="ads_description" class="form-control" maxlength="5000" rows="10" value="">{{ @$post->ads_description }}</textarea>
                            </div>  
                        </div>
                        {{-- <div class="dropdown col-sm-6">
                            <label class="dropbtn"> Template content 1</label>
                            <div class="dropdown-content" style="left:0;">
                                <ul class="cars-ul-car-color" style="overflow: auto;">
                                    @foreach($setting_ads_template as $key => $val)
                                    <li>
                                        <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                            <div class="dropdown col-sm-6 ">
                            <label class="dropbtn"> Template content 2</label>
                            <div class="dropdown-content" style="left:0;">
                                <ul id="user-template" class="cars-ul-car-color" style="overflow: auto;">
                                    @if($user_template)
                                        @foreach($user_template as $key => $val)
                                        <li class="cars-quick-description-list">
                                            <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            </div> --}}

                            <div class="col-12 col-sm-12">
                            <div class="">
                                {{-- <p class="text-muted">Template Content</p> --}}
                                <!-- Small modal -->
                                <button type="button" class="dropbtn waves-effect waves-light" data-toggle="modal" data-target="#exampleModalScrollable">Template Content</button>
                            </div>

                            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Template Content</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul id="user-template" class="cars-ul-car-color" style="height: 210px ;overflow: auto;">
                                                <h5>My Template Content</h5>
                                                @foreach($setting_ads_template as $key => $val)
                                                <li class="cars-quick-description-list">
                                                        <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <ul id="user-template" class="cars-ul-car-color" style="height: 210px ;overflow: auto;">
                                                <h5>Admin Template Content</h5>
                                                @if($user_template)
                                                    @foreach($user_template as $key => $val)
                                                    <li class="cars-quick-description-list">
                                                        <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                                    </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                            </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                            {{-- <div class="col-sm-6 cars-quick-desc">
                            <div class="form-group">
                                <label> </label>
                                <p>Quickly add to your description by clicking on the options below.</p>
                                <ul id="user-template" class="cars-ul-car-color" style="height: 210px ;overflow: auto;">
                                    @foreach($setting_ads_template as $key => $val)
                                    <li class="cars-quick-description-list">
                                        <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>  
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label> </label>
                                <p>Quickly add to your description by clicking on the options below.</p>
                                <ul id="user-template" class="cars-ul-car-color" style="overflow: auto;">
                                    @if($user_template)
                                        @foreach($user_template as $key => $val)
                                        <li class="cars-quick-description-list">
                                            <a class="cars-quick-description-element" href="javascript:void(0)" data-template="{{ $val }}">{{ $key }}</a>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>  
                        </div>  --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="setting_state_id">LOCATION (STATE) <span class="text-danger">*</span></label>
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

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Highlight</h4>
                    <div class="row" id="show_highligh">
                        @foreach($setting_highlight as $key => $row)
                            <div class="column mar-bot">
                                <div class="h-100 cars-highlight-card @if(@$post->ads_highlight_ids) {{ in_array($row->setting_highlight_id, explode(',', $post->ads_highlight_ids)) ? 'active' : '' }} @endif" data-highlight-id="{{ $row->setting_highlight_id }}" >
                                    <div class="cars-highlight-card-main pb-0 d-flex flex-column">
                                        <div class="cars-highlight-rounded-box" style="background-image: url(<?php echo optional($row->setting_highlight_icon)->getUrl() ?>)">
                                        </div>
                                        <div class="cars-highlight-title text-center">{{ $row->setting_highlight_name }}</div>
                                        <div class="cars-highlight-desc mt-auto m-1">
                                            <input name="ads_highlight_description[{{ $row->setting_highlight_id }}]" type="text" class="form-control cars-highlight-desc-input font-size-11" maxlength="15" placeholder="Max.15 charac.." value="{{ @$post->ads_highlight_description[$row->setting_highlight_id]  }}">
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
                    <h4 class="card-title mb-4">Upgrade Your Ad</h4>
                    <div class="row">                        
                        {{-- foreach($setting_ads_list as $row) --}}
                        <?php 
                            $price = $setting_ads->is_setting_ads_sales ?  $setting_ads->setting_ads_sales_price : $setting_ads->setting_ads_price;
                            
                            $price_display = $price > 0 ? '<span class="font-size-18 font-weight-600 cars-text-theme-color">' . number_format($price, 0) . ' Credit</span>' : '<span class="font-size-18 font-weight-600 cars-text-theme-color">FREE</span>';
                            
                            $old_price = $setting_ads->is_setting_ads_sales ? '<span class="font-size-12" style="text-decoration: line-through;">' . number_format($setting_ads->setting_ads_price) . ' Credit</span>' : '';
                            
                            $validity = $setting_ads->setting_ads_validity ? '<h3>' . $setting_ads->setting_ads_validity . ' days</h3>' : '';
                        ?>
                        <div class="col-sm-4">
                            <div class="card setting-cars-card active">
                                <div class="card-header cars-setting-header">{{ $setting_ads->setting_ads_name }}</div>
                                <div class="card-body">
                                    {!! $validity !!}
                                </div>
                                <div class="card-footer bg-transparent border">
                                    <div>
                                        {!! $price_display !!} &nbsp {!! $old_price !!}
                                    </div>
                                    <button type="button" class="btn cars-btn-outline-theme-color mt-2 setting-cars-select active" data-setting_ads_id="{{ $setting_ads->setting_ads_id }}"></button>
                                </div>
                            </div>
                        </div> 
                        {{-- @endforeach --}}                                       
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Click submit below to post your Ad</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> 
                                <input type="hidden" id="car_request_id" name="car_request_id" value="{{ @$post->car_request_id }}">
                                <input type="hidden" id="car_color_id" name="car_color_id" value="{{ @$post->car_color_id }}">
                                <input type="hidden" id="ads_thumbnail_id" name="ads_thumbnail_id" value="{{ @$post->ads_thumbnail_id }}">    
                                <input type="hidden" id="ads_highlight_ids" name="ads_highlight_ids" value="{{ @$post->ads_highlight_ids }}">
                                <input type="hidden" id="setting_ads_id" name="setting_ads_id" value="{{ @$post->setting_ads_id }}">
                                <input type="hidden" id="media_temp_id" name="media_temp_id" value="{{ @$post->media_temp_id }}">
                                <input type="hidden" id="registration_card_temp_id" name="registration_card_temp_id" value="{{ @$post->registration_card_temp_id }}">
                                <p>By posting your ad, you are agreeing to our terms of use and privacy policy.</p>
                                <button type="submit" name="submit" value="submit" class="btn btn-company waves-effect waves-light mr-1 submit">Publish</button>  
                                @if(@$ads->ads_status_id == 1)
                                <button type="submit" name="submit" value="preview" class="btn cars-yellow-bg-color waves-effect waves-light mr-1 submit">Save and Preview</button>
                                @endif 
                                {{-- @if(@$ads->ads_status_id == 2)
                                <span class='btn btn-outline-danger waves-effect waves-light reject_button mr-1' data-toggle='modal' data-target='#activate' data-id='$ads->ads_id'>Reject</span>
                                @endif                            --}}
                                <a id="cancel" href="{{ route('ads_listing') }}" class="btn cars-btn-default" type="button">Cancel</a>
                            </div>  
                        </div>  
                    </div>
                </div>
            </div>        
        </div>        
    </div>  
    <!-- Modal -->
    {{-- <div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @csrf
                <div class="modal-body">
                    <h4>Reject this Ads ?</h4>
                    <div class="col-sm-12">
                        <div class="form-group" id="message_container">
                            <label for="message">Message</label>
                            <textarea id="textarea" type="text" class="form-control" maxlength="250" rows="10" name="message" id="message"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" value="reject" class="btn btn-success submit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Modal -->

</form>
<!-- </div> -->
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
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/custom.js')}}"></script>
    <script src="{{ URL::asset('assets/js/jquery-ui.js')}}"></script>

    <script>
        var id = '{{ @$ads->ads_id ? $ads->ads_id : 0}}';
        var action = '{{ @$ads->ads_id ?  "update" : "add"}}';
        var img_temp_id = [];
        if($('#media_temp_id').val()){
            var arr = $('#media_temp_id').val().split(',');
            $.each(arr, function(key, value) {
                img_temp_id.push(value);
            });
        }

        $(document).ready(function(e) {

            //if got request then continue with request data
            var is_car_request_variant_create = '{{ @$ads->car_request ? $ads->car_request->is_variant_create : 0 }}';
            var car_request = $('#car_request_id').val();
            if(is_car_request_variant_create == 0 && car_request > 0) // only show request as title if variant is still not created & car request exist
            {
                $('#car-info-title').val($('#ads-title').val());
                $('#car_request_id').val($('#car_request_id').val());

                //if got request then continue with request data
                if($('#car_request_id').val()){
                    $('#car-info-title').val($('#ads-title').val());
                    $('#car_request_id').val($('#car_request_id').val());

                    $('.car-info').hide();
                    $('.car-info-title').show();
                }
            }

            if($('#car_variant_id').val() > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_price_guide')}}",
                    data: {
                        car_variant_id: $('#car_variant_id').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {
                        if (e.status == true) {
                            if(e.data['avg'] > 0) {
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

            if(ads_type_id){
                if(ads_type_id == 1 || ads_type_id == 2) {
                    $("#car_mileage").show();
                    $('#car_chassis_no').hide();
                    $('#car_plate_no').show();
                } else {
                    $("#car_mileage").hide();
                    $('#car_chassis_no').show();
                    $('#car_plate_no').hide();
                }
            }

            // If ads_id is true, add ads_highlight to hidden input
            if(id) {
                ads_highlight_ids = '{{ @$ads->ads_highlight_ids ? $ads->ads_highlight_ids : 0 }}';
                ads_highlight_ids_arr = ads_highlight_ids.split(',');
                new_ads_highlight_ids_arr = getUnique(ads_highlight_ids_arr);
                new_ads_highlight_ids = new_ads_highlight_ids_arr.join();

                $('#ads_highlight_ids').val(new_ads_highlight_ids);
            }

            $('#user_type_id').on('change', function() {

                $('#user_id').html('<option>Please select User</option>');
                $('#user_id').attr('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user')}}",
                    data: {
                        user_type_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {
                        if (e.status == true) {
                            $('#user_id').html('<option value="">Please select User</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#user_id').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#user_id').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#user_id').on('change', function() {

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user_template')}}",
                    data: {
                        user_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {
                        $('#user-template').html('');
                        if (e.status == true) {                                                        
                            $.each(e.data, function(key, value) {                                
                                $('#user-template').append('<li class="cars-quick-description-list"><a class="cars-quick-description-element" href="javascript:void(0)" data-template="' + value + '">' + key + '</a></li>');                                
                            });
                        }
                    }
                });
            });

            $('#car_brand_id').on('change', function() {
                var id = $(this).val()
                $('#car_model_group_id').html('<option>Please select Model Group</option>');
                $('#car_model_group_id').attr('disabled', true);
                $('#car_model_id').html('<option>Please select Model</option>');
                $('#car_model_id').attr('disabled', true);
                $('#car_manufacture_year').html('<option>Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option>Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option>Please select Engine Capacity (CC)</option>');
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
                    success: function(e) {
                        if (e.status == true && e.is_model_group == true) {
                            $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                            $.each(sorting(e.data), function(key, value) {
                                if(value.key){
                                    $('#car_model_group_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                }      
                            });
                            $('#car_model_group_id').removeAttr('disabled');
                            $('.model_group').show();
  
                        } 
                        else {
                            $.ajax({
                                type: 'POST',
                                url: "{{route('ajax_get_car_model')}}",
                                data: {
                                    car_brand_id: id,
                                    _token: '{{csrf_token()}}'
                                },
                                success: function(e) {
                                    if (e.status == true) {
                                        $('#car_model_id').html('<option value="">Please select Model</option>');
                                        $.each(sorting(e.data), function(key, value) {
                                            if(value.key != ''){
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

                // $.ajax({
                //     type: 'POST',
                //     url: "{{route('ajax_get_car_model')}}",
                //     data: {
                //         car_brand_id: $(this).val(),
                //         _token: '{{csrf_token()}}'
                //     },
                //     success: function(e) {
                //         if (e.status == true) {
                           
                //             $.each(e.data, function(key, value) {
                //                 if(key != ''){
                //                     console.log(key);
                //                     console.log(value);
                //                     $('#car_model_id').html('<option value="">Please select Model</option>');
                //                     // $('#car_model_id').append('<option value="' + key + '">' + value + '</option>');
                //                     $.each(sorting(e.data), function (key, value) {
                //                         $('#car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                //                     });
                //                 }      
                //             });
                //             $('#car_model_id').removeAttr('disabled');
                //         } 
                //     }
                // });
            });

            $('#car_model_group_id').on('change', function() {

                $('#car_model_id').html('<option>Please select Model</option>');
                $('#car_model_id').attr('disabled', true);
                $('#car_manufacture_year').html('<option>Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option>Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option>Please select Engine Capacity (CC)</option>');
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
                    success: function(e) {
                        if (e.status == true) {
                            $('#car_model_id').html('<option value="">Please select Model</option>');
                            $.each(sorting(e.data), function(key, value) {
                                if(key != ''){
                                    $('#car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                }      
                            });
                            $('#car_model_id').removeAttr('disabled');
                        } 
                    }
                });
            });

            $('#car_model_id').on('change', function() {

                $('#car_manufacture_year').html('<option>Please select Manufacture Year</option>');
                $('#car_manufacture_year').attr('disabled', true);
                $('#car_variant_transmission').html('<option>Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option>Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option>Please select Variant</option>');
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
                    success: function(e) {
                        if (e.status == true) {
                            $('#car_manufacture_year').html('<option value="">Please select Manufacture Year</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#car_manufacture_year').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_manufacture_year').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_manufacture_year').on('change', function() {

                $('#car_variant_transmission').html('<option>Please select Transmission</option>');
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_variant_cc').html('<option>Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option>Please select Variant</option>');
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
                    success: function(e) {
                        if (e.status == true) {
                            $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#car_variant_transmission').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_variant_transmission').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_variant_transmission').on('change', function() {

                $('#car_variant_cc').html('<option>Please select Engine Capacity (CC)</option>');
                $('#car_variant_cc').attr('disabled', true);
                $('#car_variant_id').html('<option>Please select Variant</option>');
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
                    success: function(e) {
                        if (e.status == true) {
                            $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#car_variant_cc').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#car_variant_cc').removeAttr('disabled');
                        }
                    }
                });
            });

            $('#car_variant_cc').on('change', function() {

                $('#car_variant_id').html('<option>Please select Variant</option>');
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
                    success: function(e) {
                        if (e.status == true) {
                            // $('#car_variant_id').html('<option value="">Please select Variant</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){

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

            $('#car_variant_id').on('change', function() {
                $('#price_guide').hide();
                $('.cars-highlight-card').removeClass('active');
                $('#ads_highlight_ids').val('');
                if(this.value != ''){
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
                        success: function(e) {
                            if (e.status == true) {
                                // if(e.data['min'] > 0 || e.data['avg'] > 0 || e.data['max'] > 0) {
                                if(e.data['avg'] > 0) {
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
                        success: function(e) {
                            if (e.status) {
                                ads_highlight_id = [];

                                $.each(e.data, function(k,v) {
                                    var dataId = $('.cars-highlight-card').attr("data-highlight-id");
 
                                    $("[data-highlight-id='"+ k +"']").addClass('active');

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
            // console.log(length_title);
            // console.log(balance);

            // $('#price_guide_period').on('change', function() {
            //     $.ajax({
            //         type: 'POST',
            //         url: "{{route('ajax_get_price_guide')}}",
            //         data: {
            //             car_variant_id: $('#car_variant_id').val(),
            //             price_guide_period: this.value,
            //             _token: '{{csrf_token()}}'
            //         },
            //         success: function(e) {
            //             if (e.status == true) {
            //                 $('#lowest_price').text('RM' + e.data['min']);     
            //                 $('#average_price').text('RM' + e.data['avg']);  
            //                 $('#highest_price').text('RM' + e.data['max']);                             
            //             }
            //         }
            //     });
            // });

            $('input:radio[name="ads_type_id"]').on('click', function() {

                if (this.value == 1 || this.value == 2) {
                    $("#car_mileage").show();
                    $('#car_chassis_no').hide();
                    $('#car_plate_no').show();
                } else {
                    $("#car_mileage").hide();
                    $('#car_chassis_no').show();
                    $('#car_plate_no').hide();
                }
            });

            $('#setting_state_id').on('change', function() {
                $('#setting_city_id').html('<option>Please select City</option>');
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_setting_city')}}",
                    data: {
                        setting_state_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {
                        if (e.status == true) {
                            $('#setting_city_id').html('<option value="">Please select City</option>');
                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#setting_city_id').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#setting_city_id').removeAttr('disabled');
                        }
                    }
                });
            });

            $('.cars-color').on('click', function() {
                $('.cars-color').removeClass('active');
                $('#car_color_id').val(this.id);
                $(this).addClass('active');
            }); 

            $('.cars-quick-desc').on('click', '.cars-quick-description-element', function() {
                var textarea = $('#textarea').val();
                var template = $(this).data('template');
                $('#textarea').val(textarea + template + '\n');
            }); 

            // var ads_highlight_id = [];
            if($('#ads_highlight_ids').val()){
                var res = $('#ads_highlight_ids').val().split(',');
                $.each(res, function(i, j) {
                    ads_highlight_id.push(j);
                });         
            }
            $('.cars-highlight-card').bind( 'mousedown', function (e) {
                var id = $(this).data('highlight-id');
                if($(this).hasClass('active')){
                    $.each(ads_highlight_id, function(i, val) {
                        if(val == id){
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

            $('.setting-cars-card').on('click', function () {
                $('.setting-cars-card').removeClass('active');
                $('.setting-cars-select').removeClass('active');

                $(this).addClass('active');
                $('#setting_ads_id').val($(this).find('.setting-cars-select').data('setting_ads_id'));
                $(this).find('.setting-cars-select').addClass('active');
            });

            /***  Ads Images ***/
            $("#ads_files").change(function() {
                add_ads_images(this.files)
            });
            //drag and drop
            var ads_images_dropzone = document.getElementById('ads-images-dropzone');
            ads_images_dropzone.ondragover = function () { 
                return false; 
            };
            ads_images_dropzone.ondrop = function (e) {
                e.preventDefault();

                var files = e.dataTransfer.files;      
                add_ads_images(files);      
            };

            $('#preview_ads_images').on('click', '.remove', function() {
                var id = $(this).parent().data('img_id');
                var $this = $(this);
                var new_main_id;

                //remove media id from array img_temp_id
                $.each(img_temp_id, function(i, val) {
                    if(val == id){
                        img_temp_id.splice(i,1);
                    }
                });
                $('#media_temp_id').val(img_temp_id);

                //remove image from preview                
                $(this).parent().remove();

                //remove ads thumbnail id
                if($this.parent().hasClass('main_photo')){                        
                    var new_main = $('#preview_ads_images').children().first();
                    new_main.addClass('main_photo');
                    $('<span class="cars-main-img">Main Image</span>').insertBefore(new_main.find('.remove'));
                    new_main.find('.set-main-img').remove();
                    $('#ads_thumbnail_id').val(new_main.data('img_id'));
                    new_main_id = new_main.data('img_id');
                }
                console.log(new_main_id);
                //remove media from db
                $.ajax({    
                    type: 'POST',
                    url: "{{route('ajax_remove_ads_images')}}",
                    data: {
                        id: id,
                        ads_id: '{{ @$ads->ads_id ? $ads->ads_id : 0}}',
                        new_ads_thumbnail_id: new_main_id,
                        _token: '{{csrf_token()}}',
                    },

                    success: function(e) {
                        if (e.status == true) {
                            console.log('Deleted image');
                        }
                    }
                });
                
            });

            $('#preview_ads_images').on('click', '.set-main-img', function() {
                var old_main = $('#preview_ads_images').find('.main_photo');
                var id = $(this).parent().data('img_id');
                var arr_temp = [];

                $('#ads_thumbnail_id').val(id);

                //remove class main photo from previous main
                old_main.removeClass('main_photo');
                old_main.find('.cars-main-img').remove();
                $('<a href="javascript:void(0)" class="set-main-img">Set As Main</a>').insertBefore(old_main.find('.remove'));

                //move new main photo to the first
                $($(this).parent()).prependTo($('#preview_ads_images'));
                $(this).parent().addClass('main_photo');
                $('<span class="cars-main-img">Main Image</span>').insertBefore($(this).parent().find('.remove'));
                $(this).remove('.set-main-img');

                $('#preview_ads_images div').each(function (index) {
                    arr_temp.push($(this).data('img_id'));
                });
                $('#media_temp_id').val(arr_temp);

            });

            /***  Ads Registration Card ***/
            $('#ads-registration_card').on('change', function(e){
                var file = this.files[0];
                
                add_ads_registration_card(file);
            });       
            
            var start_index;
            var start_item;  
            var drop_index;                      
            var drop_item;            
            
            $('#preview_ads_images').sortable({
                start: function(event, ui) { 
                    start_index = ui.item.index();
                    start_item = ui.item;
                },
                stop: function(event, ui) {
                    var imageIdsArray = [];
                    var arr_temp = []
                    drop_index = ui.item.index();
                    drop_item = ui.item;

                    if(start_index != drop_index){
                        $('#preview_ads_images div').each(function (index) {
                            arr_temp.push($(this).data('img_id'));
                        });
                        $('#media_temp_id').val(arr_temp);

                        if(drop_index == 0){
                            var old_main = $('#preview_ads_images').find('.main_photo');
                            var id = drop_item.data('img_id');

                            $('#ads_thumbnail_id').val(id);

                            //remove class main photo from previous main
                            old_main.removeClass('main_photo');
                            old_main.find('.cars-main-img').remove();
                            $('<a href="javascript:void(0)" class="set-main-img">Set As Main</a>').insertBefore(old_main.find('.remove'));

                            //set as main photo
                            drop_item.addClass('main_photo');
                            $('<span class="cars-main-img">Main Image</span>').insertBefore(drop_item.find('.remove'));
                            drop_item.find('.set-main-img').remove();
                        }
                        if(start_index == 0){
                            //remove class main photo from previous main
                            start_item.removeClass('main_photo');
                            start_item.find('.cars-main-img').remove();
                            $('<a href="javascript:void(0)" class="set-main-img">Set As Main</a>').insertBefore(start_item.find('.remove'));

                            //set as main photo
                            var new_main = $('#preview_ads_images :first-child');
                            new_main.addClass('main_photo');
                            $('<span class="cars-main-img">Main Image</span>').insertBefore(new_main.find('.remove'));
                            new_main.find('.set-main-img').remove();

                            $('#ads_thumbnail_id').val(new_main.data('img_id'));
                        }
                    }                    
                }
            });
            $('#preview_ads_images').disableSelection();

            $('#cars-quick-search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("ajax_get_car_info_by_keyword") }}',
                        data: {
                            _token: '{{csrf_token()}}',
                            car_keyword : request.term
                        },
                        success: function(e) {
                            var car_list = []
                            
                            for(var key in e.data) {
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
                select: function( event, ui ) {
                    $.when(
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("ajax_get_car_info") }}',
                            data: {
                                _token: '{{csrf_token()}}',
                                car_brand_id: ui.item.car_brand_id,
                                // car_model_group_id: ui.item.car_model_group_id,
                                car_model_id: ui.item.car_model_id,
                                car_variant_year: ui.item.car_variant_year,
                                car_variant_transmission: ui.item.car_variant_transmission,
                                car_variant_cc: ui.item.car_variant_cc,
                                car_variant_id: ui.item.car_variant_id
                            },
                            success: function(e) {
                                $('#car_brand_id').val(ui.item.car_brand_id);

                                if(e.data['car_model_group_sel'] && e.data['car_model_group_sel'].length == undefined){

                                    $('#car_model_group_id').html('<option value="">Please select Model Group</option>');
                                    $.each(sorting(e.data['car_model_group_sel']), function(key, val) {
                                        if(val.key){
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
                                    if(val.key){
                                        var selected = (val.key == ui.item.car_variant_year) ? 'selected' : ''
                                        $('#car_manufacture_year').append('<option value="' + val.key + '" ' + selected + ' >' + val.value + '</option>');
                                    }
                                })
                                $('#car_manufacture_year').removeAttr('disabled');

                                $('#car_variant_transmission').html('<option value="">Please select Transmission</option>');
                                $.each(e.data['car_variant_transmission_sel'], function (key, value) {
                                    if(key){
                                        var selected = (key == ui.item.car_variant_transmission) ? 'selected' : ''
                                        $('#car_variant_transmission').append('<option value="' + key + '" ' + selected + ' >' + value + '</option>');
                                    }
                                })
                                $('#car_variant_transmission').removeAttr('disabled');

                                $('#car_variant_cc').html('<option value="">Please select Engine Capacity (CC)</option>');
                                $.each(e.data['car_variant_cc_sel'], function (key, value) {
                                    if(key){
                                        var selected = (key == ui.item.car_variant_cc) ? 'selected' : ''
                                        $('#car_variant_cc').append('<option value="' + key + '" ' + selected + ' >' + value + '</option>');
                                    }
                                })
                                $('#car_variant_cc').removeAttr('disabled');

                                $('#car_variant_id').html('<option value="">Please select Variant</option>');
                                $.each(sorting(e.data['car_variant_sel']), function (key, val) {
                                    if(val.key){
                                        var selected = (val.key == ui.item.car_variant_id) ? 'selected' : ''
                                        $('#car_variant_id').append('<option value="' + val.key + '" ' + selected + ' >' + val.value + '</option>');
                                    }
                                })
                                $('#car_variant_id').removeAttr('disabled');
                            }
                        })
                    ).then(function() {
                        $('#car_variant_id').val(ui.item.car_variant_id).change();
                    });
                }
            });

            // price to comma format
            $.fn.digits = function(){ 
                return this.each(function(){ 
                    $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
                })
            }

            // disabled all 3 button after submit
            $('.submit').one('click', function() {
                $('#ads_form').submit(function() {
                    $(this).find('button[type=submit]').prop('disabled',true)
                });
                $('#cancel').click(function(e) { e.preventDefault(); }); // disabled cancel link
                $('<input>').attr({type: 'hidden',name: 'submit',value: this.value}).appendTo('#ads_form');
            });
        });

        function sorting(data)
        {
            var sorted = [];
            $(data).each(function(k, v) {
                for(var key in v) {
                    sorted.push({key: key, value: v[key]})
                }
            });

            return sorted.sort(function(a, b){
                if (a.value < b.value) return -1;
                if (a.value > b.value) return 1;
                return 0;
            });
        }

        function getUnique(array){
            var uniqueArray = [];
            
            // Loop through array values
            for(var value of array){
                if(uniqueArray.indexOf(value) === -1){
                    uniqueArray.push(value);
                }
            }
            return uniqueArray;
        }
</script>
@endsection