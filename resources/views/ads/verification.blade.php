@extends('layouts.master')

@section('title') Ad Verification @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">
<link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Ad Verification</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Ad Verification</a>
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
<form method="POST" action="{{ $submit }}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
				<div class="card-body p-0">
					<div class="row m-0">
						<div class="col-sm-4 col-12 cars-card-col">
							<div class="mb-2">
								<span class="font-weight-bolder mr-2">#{{ sprintf("%08d", $ads->ads_id) }}</span>
							</div>
							<div class="img-wrap cars-cover-img border">
								@if($ads->hasMedia('ads_images'))
								<img class="photo" src="{{ $ads->cover_photo }}" class="card-img-top card-company-banner" width="100%">
								@else
								<img class="photo" src="{{ asset('images/no_image_available.png') }}" class="card-img-top card-company-banner" width="100%">
								@endif
							</div>
							<div class="image-count pt-2 pl-2 font-size-16">
								<i class="bx bx-camera"></i>
								{{ count($ads->getMedia('ads_images')) }}
							</div>
						</div>
						<div class="col-sm-8 col-12 cars-card-col">
							<div class="mb-2">
								<?php
								$ads_updated = $ads->ads_updated;
								$ads_date_display = $ads->ads_date_display ? 'Posted On: <span class="font-weight-bolder">' . date('Y-m-d', strtotime($ads->ads_date_display)) . '</span>' : 'Created On: <span class="font-weight-bolder">' . $ads->ads_created->format('Y-m-d') . '</span>';
								?>
								<span class="cars-text-grey font-size-11 mr-2">{!! $ads_date_display !!}</span>
								<span class="cars-text-grey font-size-11">Updated On: <span class="font-weight-bolder">{{ $ads_updated->format('Y-m-d') }} </span></span>
							</div>
							<div class="mb-2">
								<h5>{{ $ads->ads_title }}</h5>
							</div>
							<div class="mb-2">
								<span class="badge badge-secondary mr-2 cars-status-padding">{{ $ads->ads_type->ads_type_name }}</span>
								<span class="mr-2"><img class="mr-2" src="{{ URL::asset('images/engine_cc.svg') }}">{{ @$ads->car_variant->car_variant_cc }}</span>
								<span><img class="mr-2" src="{{ URL::asset('images/transmission.svg') }}">{{ @$ads->car_variant->car_variant_transmission }}</span>
							</div>
							<div class="mb-2">
                                <span class="font-weight-bold">{{ strtoupper($ads->ads_category->setting_ads_category_name) }}</span><br/>
								@if($ads->car_chassis_no)
								Chassis No. <span class="font-weight-bolder">{{ $ads->car_chassis_no }}</span>
								@else
								Plate No. <span class="font-weight-bolder">{{ $ads->car_plate_no }}</span>
                                @endif
                                @if($ads->is_registration_card > 0 && @$ads->hasMedia('ads_registration_card'))
                                    <a class="iframe" data-fancybox-type="image" href="{{ $ads->ads_registration_card->getUrl() }}">
                                        <img src="{{asset('')}}assets/images/bxs-credit-card-front.png" alt="" class="img-fluid">
                                    </a>
                                @endif
								<br/>
								Reference No. <span class="font-weight-bolder">{{ $ads->car_reference_no }}</span></br>
							</div>
							<div class="mb-3">
								<span class="font-weight-bolder">{{ $ads->user->join_company ? ucwords($ads->user->join_company->company->company_name) : 'Private' }}</span></br>
								<span>{{ $ads->user->user_type->user_type_name }}</span> Name <span>({{ $ads->user->user_fullname }})</span></br>
							</div>
							<div class="mb-2">
								Current Price <span class="cars-text-theme-color font-size-20 font-weight-bolder">RM {{ number_format($ads->ads_price, 0) }}</span>
                            </div>
                            @if($ads->ads_status_pending_ids)
                            <div class="mb-2">
                                <div class="mb-2">Ad Pending Approval due to :-</div>
                                @foreach($ads->ads_status_pending_ids as $key => $ads_status_pending)
                                    <div class="font-weight-bold">{{ ++$key }}) {{ $ads_status_pending->ads_status_pending_name }}</div>
                                @endforeach
                            </div>
                            @endif
						</div>
                    </div>
                </div>
            </div>
            @if($ads->ads_status_id == 8)
                @if(@$setting_inspection_list)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Inspection List</h4>
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <div class="col-md-12">
                                        <ul class="inspection" style="padding:0">
                                            <li class="custom-control custom-checkbox">
                                                <input type="checkbox" id="check_all" class="custom-control-input check" checked>
                                                <label class="custom-control-label" for="check_all">All Pass</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="p-0 pl-sm-4">
                                            @foreach($setting_inspection_list as $list)
                                                <li style='padding:10px 0px;list-style:none;'><b>{{ $list->setting_inspection_list_name }}</b></li>
                                                @if($list->sub_setting_inspections->isNotEmpty())
                                                    <div class="row">
                                                    @foreach($list->sub_setting_inspections as $sub_list)
                                                        <div class="col-sm-6 col-xl-4 mb-4 mb-sm-2">
                                                            <div class="row">
                                                                <div class="col-sm-6 inspection">
                                                                    <li class="custom-control custom-checkbox" style="list-style:none;">
                                                                        <input class="custom-control-input check" type="checkbox" name="setting_inspection_list_ids[{{ $sub_list->setting_inspection_list_id }}]" value="{{ $sub_list->setting_inspection_list_id }}" id="{{ $sub_list->setting_inspection_list_id }}"
                                                                        @if(@$post->setting_inspection_list_ids) {{ in_array($sub_list->setting_inspection_list_id, $post->setting_inspection_list_ids) ? 'checked' : '' }} @else checked @endif>
                                                                        <label class="custom-control-label" for="{{ $sub_list->setting_inspection_list_id }}" >{{ $sub_list->setting_inspection_list_name }}</label>
                                                                    </li>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control" name="setting_inspection_list_description[{{ $sub_list->setting_inspection_list_id }}]" value="{{ @$post->setting_inspection_list_description[$sub_list->setting_inspection_list_id] }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Inspector Notes</h4>
                        <div class="repeater">
                            <div data-repeater-list="ads_inspection_list_notes">
                                @if(@$post->ads_inspection_list_notes)
                                    @foreach($post->ads_inspection_list_notes as $ads_inspection_list_notes_detail)
                                    <div data-repeater-item class="row">
                                        <div  class="form-group col-6 col-md-2">
                                            <label for="name">Section</label>
                                            <input type="text" name="inspection_section" class="form-control" value="{{ $ads_inspection_list_notes_detail['inspection_section'] }}" />
                                        </div>
                                        <div  class="form-group col-6 col-md-2">
                                            <label for="name">Item</label>
                                            <input type="text" name="inspection_item" class="form-control" value="{{ $ads_inspection_list_notes_detail['inspection_item'] }}" />
                                        </div>
                                        <div  class="form-group col-md-6">
                                            <label for="name">Notes</label>
                                            <input type="text" name="inspection_notes" class="form-control" value="{{ $ads_inspection_list_notes_detail['inspection_notes'] }}" />
                                        </div>
                                        <div class="form-group col-md-2 my-auto">
                                            <button data-repeater-delete type="button" class="btn btn-danger desktop-btn">
                                                <i class="bx bx-trash" style="font-size: 15px"></i>
                                            </button>

                                            <input data-repeater-delete type="button" class="btn btn-danger btn-block mobile-btn" value="Delete"/>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div data-repeater-item class="row">
                                        <div  class="form-group col-6 col-md-2">
                                            <label for="name">Section</label>
                                            <input type="text" name="inspection_section" class="form-control"/>
                                        </div>
                                        <div  class="form-group col-6 col-md-2">
                                            <label for="name">Item</label>
                                            <input type="text" name="inspection_item" class="form-control"/>
                                        </div>
                                        <div  class="form-group col-md-6">
                                            <label for="name">Notes</label>
                                            <input type="text" name="inspection_notes" class="form-control"/>
                                        </div>
                                        <div class="form-group col-md-2 my-auto">
                                            <button data-repeater-delete type="button" class="btn btn-danger desktop-btn">
                                                <i class="bx bx-trash" style="font-size: 15px"></i>
                                            </button>

                                            <input data-repeater-delete type="button" class="btn btn-danger btn-block mobile-btn" value="Delete"/>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/>
                        </div>
                    </div>
                </div>
            @else
            @if($ads->ads_status_pending_ids)
                @foreach($ads->ads_status_pending_ids as $ads_status_pending)
                    @switch($ads_status_pending->ads_status_pending_id)
                        @case(1)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">{{ $ads_status_pending->ads_status_pending_name }}</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Fullname</label>
                                                @if($ads->user->hasMedia('user_ic'))
                                                    <a class="iframe" data-fancybox-type="image" href="{{ $ads->user->getFirstMediaUrl('user_ic') }}">
                                                        <img src="{{asset('')}}assets/images/bxs-credit-card-front.png" alt="" class="img-fluid">
                                                    </a>
                                                @endif
                                                <input class="form-control" type="text" value="{{ $ads->user->user_fullname }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input class="form-control" type="text" value="{{ $ads->user->user_mobile }}" readonly>
                                            </div>
                                            @if($ads->user->user_whatsapp)
                                            <div class="form-group">
                                                <label>Whatsapp Number</label>
                                                <input class="form-control" type="text" value="{{ $ads->user->user_whatsapp }}" readonly>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>User Ic</label>
                                                <input class="form-control" type="text" value="{{ $ads->user->user_nric }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="text" value="{{ $ads->user->user_email }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break
                        @case(2)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">{{ $ads_status_pending->ads_status_pending_name }}</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @if($ads->price_range['min_avg'] == 0 || $ads->price_range['max_avg'] == 0)
                                            <div class="form-group">
                                                There is no price range for this Ad.
                                            </div>
                                            <div>
                                                The current Ad price is <span class="text-success font-weight-bold">RM{{ number_format($ads->ads_price, 0) }}</span>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                The Ad has price range between <span class="text-warning font-weight-bold">RM{{ number_format($ads->price_range['min_avg'], 0) }}</span> to <span class="text-warning font-weight-bold">RM{{ number_format($ads->price_range['max_avg'], 0) }}.</span>
                                            </div>
                                            <div>
                                                The current Ad price is <span class="text-danger font-weight-bold">RM{{ number_format($ads->ads_price, 0) }}</span>
                                                @if($ads->ads_price > $ads->price_range['max_avg'])
                                                    which is <span class="text-danger font-weight-bold">higher</span> compared to the price range for the car.
                                                @elseif($ads->ads_price < $ads->price_range['min_avg'])
                                                    which is <span class="text-danger font-weight-bold">lower</span> compared to the price range for the car.
                                                @else

                                                @endif

                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break
                        @case(3)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">{{ $ads_status_pending->ads_status_pending_name }}</h4>
                                    <label>Car Brand</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" value="{{ @$ads->car_request->car_brand_name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="existing_car_brand_radio" type="radio" name="car_brand_radio" class="admin-custom-control-input" value="existing_car_brand" {{ @$post->car_brand_radio == 'existing_car_brand' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="existing_car_brand_radio">
                                                        Existing Car Brand
                                                    </label>
                                                </div>
                                                <div>
                                                {!! Form::select('car_brand_id', $car_brand_sel, @$post->car_brand_id, ['class' => 'form-control mb-3','id' => 'existing_car_brand_id', 'disabled']) !!}
                                                </div>
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="new_car_brand_radio" type="radio" name="car_brand_radio" class="admin-custom-control-input" value="new_car_brand" {{ @$post->car_brand_radio == 'new_car_brand' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="new_car_brand_radio">
                                                        New Car Brand
                                                    </label>
                                                </div>
                                                <label>Car Brand Name</label>
                                                <input id="new_car_brand_id" class="form-control" name="car_brand_name" type="text" value="{{ @$post->car_brand_name }}" maxlength="40" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="model-group" @if( !@$post->car_model_group_id ) style="display: none" @endif }}>
                                        <label>Car Model Group</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    {!! Form::select('car_model_group_id', $car_model_group_sel, @$post->car_model_group_id,  (@$post->car_brand_id ? ['class' => 'form-control', 'id' => 'car_model_group_id'] : ['class' => 'form-control', 'id' => 'car_model_group_id', 'disabled'])  ) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <label>Car Model</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" value="{{ @$ads->car_request->car_model_name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="existing_car_model_radio" type="radio" name="car_model_radio" class="admin-custom-control-input" value="existing_car_model" {{ @$post->car_model_radio == 'existing_car_model' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="existing_car_model_radio">
                                                        Existing Car Model
                                                    </label>
                                                </div>
                                                <div>
                                                {!! Form::select('car_model_id', $car_model_sel, @$post->car_model_id, ['class' => 'form-control mb-3','id' => 'existing_car_model_id', 'disabled']) !!}
                                                </div>
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="new_car_model_radio" type="radio" name="car_model_radio" class="admin-custom-control-input" value="new_car_model" {{ @$post->car_model_radio == 'new_car_model' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="new_car_model_radio">
                                                        New Car Model
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="new_car_model_id">
                                                <div class="form-group">
                                                    <label>Car Model Name</label>
                                                    <input class="form-control" type="text" name="car_model_name" value="{{ @$post->car_model_name }}" maxlength="40" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Car Body Type</label>
                                                    {!! Form::select('car_body_type_id', $car_body_type_sel, @$post->car_body_type_id, ['class' => 'form-control mb-3', 'id' => 'car_body_type_id', 'disabled']) !!}
                                                    <!-- <input id="new_car_model_id" class="form-control" type="text" value="{{ $ads->car_request->car_model_name }}" disabled> -->
                                                </div>
                                                <div class="form-group">
                                                    <label>Car Seat Number</label>
                                                    <!-- <input id="new_car_model_id" class="form-control" name="car_seat_number" type="number" value="2" min="2" disabled> -->
                                                    <input name="car_seat_number" class="form-control input-mask text-left" data-inputmask="'mask': '99','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" value="{{ @$post->car_seat_number }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Car Drive Wheel</label>
                                                    {!! Form::select('car_drive_wheel_id', $car_drive_wheel_sel, @$post->car_drive_wheel_id, ['class' => 'form-control mb-3', 'id' => 'car_drive_wheel_id', 'disabled']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <label>Car Variant</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" value="{{ @$ads->car_request->car_request_description }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="existing_car_variant_radio" type="radio" name="car_variant_radio" class="admin-custom-control-input" value="existing_car_variant" {{ @$post->car_variant_radio == 'existing_car_variant' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="existing_car_variant_radio">
                                                        Existing Car Variant
                                                    </label>
                                                </div>
                                                <div>
                                                {!! Form::select('car_variant_id', $car_variant_sel, @$post->car_variant_id, ['class' => 'form-control mb-3','id' => 'existing_car_variant_id', 'disabled']) !!}
                                                </div>
                                                <div class="custom-control admin-custom-radio mb-3">
                                                    <input id="new_car_variant_radio" type="radio" name="car_variant_radio" class="admin-custom-control-input" value="new_car_variant" {{ @$post->car_variant_radio == 'new_car_variant' ? 'checked' : '' }}>
                                                    <label class="admin-custom-control-label" for="new_car_variant_radio">
                                                        New Car Variant
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="new_car_variant_id">
                                                <div class="form-group">
                                                    <label>Car Variant Name</label>
                                                    <input class="form-control" type="text" name="car_variant_name" value="{{ @$post->car_request_description }}" disabled maxlength="90">
                                                </div>
                                                <div class="form-group">
                                                    <label>Year</label>
                                                    <input name="car_variant_year" class="form-control" type="number" value="{{ @$post->car_request_year }}" maxlength="4" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Transmission</label>
                                                    {!! Form::select('car_variant_transmission', $car_variant_transmission_sel, @$post->car_request_transmission, ['class' => 'form-control mb-3', 'id' => 'car_variant_transmission', 'disabled']) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label>Engine Capacity (CC)</label>
                                                    <!-- <input class="form-control" name="car_variant_cc" type="number" value="{{ $ads->car_request->car_request_cc }}" maxlength="4" disabled> -->
                                                    <input name="car_variant_cc" class="form-control input-mask text-left" data-inputmask="'mask': '9999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" value="{{ @$post->car_request_cc }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fuel Type</label>
                                                    {!! Form::select('car_fuel_type_id', $car_fuel_type_sel, @$post->car_fuel_type_id, ['class' => 'form-control mb-3', 'id' => 'car_fuel_type_id', 'disabled']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break
                        @case(4)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">{{ $ads_status_pending->ads_status_pending_name }}</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Ad Title</label>
                                                <div>{{ $ads->ads_title }}</div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ad Description</label>
                                                <div>{{ $ads->ads_description }}</div>
                                            </div>
                                            @if($ads->ads_with_profanity_list)
                                            <div class="form-group">
                                                The Ads Description contains profanity such as
                                                @foreach($ads->ads_with_profanity_list as $list)
                                                <span class="text-danger font-weight-bold">{{ $list }}</span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @break
                        @case(5)
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">{{ $ads_status_pending->ads_status_pending_name }}</h4>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            @if($ads->is_registration_card > 0 && @$ads->hasMedia('ads_registration_card'))
                                                <a class="iframe zoom-img" data-fancybox-type="image" href="{{ $ads->ads_registration_card->getUrl() }}">
                                                    <img src="{{ $ads->ads_registration_card->getUrl() }}" alt="" class="img-fluid" width="200">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @break
                    @endswitch
                @endforeach
            @endif
            @endif

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Remark</h4>
                    <textarea id="textarea" class="form-control" name="remark" rows="10" maxlength="255">{{ @$post->remark }}</textarea>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if($ads->ads_status_id == 2 || $ads->ads_status_id == 8 || ($ads->ads_status_id == 3 && $ads->is_pending_approval))
                    <button type="submit" name="submit" value="approve" class="btn btn-success waves-effect waves-light mr-1">Approve</button>
                    @endif
                    <button type="submit" name="submit" value="reject" class="btn btn-danger waves-effect waves-light mr-1">Reject</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>
<script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js')}}"></script>
<script>
    $(document).ready(function(e) {
        $(".iframe").fancybox({
            maxWidth: 800,
            maxHeight: 500,
            fitToView: true,
            width: '100%',
            height: '100%',
            autoSize: false,
            closeClick: false,
            openEffect: 'elastic',
            closeEffect: 'elastic',
            afterLoad: function () {
                if (this.type == "iframe") {
                    $.extend(this, {
                        iframe: {
                            preload: false
                        }
                    })
                }
            }
        });

        $('.repeater').repeater({
            defaultValues: {
                // 'textarea-input': 'foo'
            },
            show: function show() {
                $(this).slideDown();
            },
            hide: function hide(deleteElement) {
                $(this).slideUp(deleteElement);
            },
            ready: function ready(setIndexes) {
            }
        });

        var car_brand_radio = '{{ @$post->car_brand_radio }}';
        var car_model_radio = '{{ @$post->car_model_radio }}';
        var car_variant_radio = '{{ @$post->car_variant_radio }}';

        var is_model_group = $('#car_model_group_id option').length;

        if(is_model_group > 1){
            $('.model-group').show();
        } else {
            $('.model-group').hide();
        }

        if (car_brand_radio == 'existing_car_brand') {
            // $('#existing_car_brand_radio').click();
            $('#existing_car_brand_id').attr('disabled', false);
            $('#new_car_brand_id').attr('disabled', true);
        } else if(car_brand_radio == 'new_car_brand') {
            // $('#new_car_brand_radio').click();
            $('#existing_car_brand_id').attr('disabled', true);
            $('#new_car_brand_id').attr('disabled', false);
        }

        if (car_model_radio == 'existing_car_model') {
            // $('#existing_car_model').click();
            $('#existing_car_model_id').attr('disabled', false);
            $('#new_car_model_id input').attr('disabled', true);
            $('#car_drive_wheel_id').attr('disabled', true);
            $('#car_body_type_id').attr('disabled', true);
        } else if(car_model_radio == 'new_car_model') {
            // $('#new_car_model').click();
            $('#existing_car_model_id').attr('disabled', true);
            $('#new_car_model_id input').attr('disabled', false);
            $('#car_drive_wheel_id').attr('disabled', false);
            $('#car_body_type_id').attr('disabled', false);
        }

        if (car_variant_radio == 'existing_car_variant') {
            // $('#existing_car_variant_radio').click();
            $('#existing_car_variant_id').attr('disabled', false);
            $('#new_car_variant_id input').attr('disabled', true);
            $('#car_variant_transmission').attr('disabled', true);
            $('#car_fuel_type_id').attr('disabled', true);
        } else if(car_variant_radio == 'new_car_variant') {
            // $('#new_car_variant_radio').click();
            $('#existing_car_variant_id').attr('disabled', true);
            $('#new_car_variant_id input').attr('disabled', false);
            $('#car_variant_transmission').attr('disabled', false);
            $('#car_fuel_type_id').attr('disabled', false);
        }

        $('input:radio[name="car_brand_radio"]').on('click', function() {
            if (this.value == 'existing_car_brand') {
                $('#existing_car_brand_id').attr('disabled', false);
                $('#new_car_brand_id').attr('disabled', true);
            } else {
                $('#existing_car_brand_id').attr('disabled', true);
                $('#new_car_brand_id').attr('disabled', false);
            }
        });

        $('input:radio[name="car_model_radio"]').on('click', function() {
            if (this.value == 'existing_car_model') {
                $('#existing_car_model_id').attr('disabled', false);
                $('#new_car_model_id input').attr('disabled', true);
                $('#car_drive_wheel_id').attr('disabled', true);
                $('#car_body_type_id').attr('disabled', true);
            } else {
                $('#existing_car_model_id').attr('disabled', true);
                $('#new_car_model_id input').attr('disabled', false);
                $('#car_drive_wheel_id').attr('disabled', false);
                $('#car_body_type_id').attr('disabled', false);
            }
        });

        $('input:radio[name="car_variant_radio"]').on('click', function() {
            if (this.value == 'existing_car_variant') {
                $('#existing_car_variant_id').attr('disabled', false);
                $('#new_car_variant_id input').attr('disabled', true);
                $('#car_variant_transmission').attr('disabled', true);
                $('#car_fuel_type_id').attr('disabled', true);
            } else {
                $('#existing_car_variant_id').attr('disabled', true);
                $('#new_car_variant_id input').attr('disabled', false);
                $('#car_variant_transmission').attr('disabled', false);
                $('#car_fuel_type_id').attr('disabled', false);
            }
        });

        $('#existing_car_brand_id').on('change', function() {
            var id = $(this).val()

            // $.ajax({
            //     type: 'POST',
            //     url: "{{route('ajax_get_car_model')}}",
            //     data: {
            //         car_brand_id: id,
            //         _token: '{{csrf_token()}}'
            //     },
            //     success: function(e) {
            //         if (e.status == true) {
            //             $('#existing_car_model_id').html('<option value="">Please select Model</option>');
            //             $.each(sorting(e.data), function(key, value) {
            //                 if(value.key != ''){
            //                     $('#existing_car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
            //                 }
            //             });
            //             // $('#existing_car_model_id').removeAttr('disabled');
            //         }
            //     }
            // });
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
                        $('.model-group').show();
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
                                    $('#existing_car_model_id').html('<option value="">Please select Model</option>');
                                    $.each(sorting(e.data), function(key, value) {
                                        if(value.key != ''){
                                            $('#existing_car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                        }
                                    });
                                    // $('#existing_car_model_id').removeAttr('disabled');
                                }
                            }
                        });
                    }
                }
            });
        });

        $('#car_model_group_id').on('change', function() {
            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_car_model_for_model_group')}}",
                data: {
                    car_model_group_id: $(this).val(),
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if (e.status == true) {
                        $('#existing_car_model_id').html('<option value="">Please select Model</option>');
                        $.each(sorting(e.data), function(key, value) {
                            if(value.key != ''){
                                $('#existing_car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                            }
                        });
                    }
                }
            });
        });

        $('#existing_car_model_id').on('change', function() {
            var id = $(this).val()

            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_car_variant_by_model')}}",
                data: {
                    car_model_id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if (e.status == true) {
                        $('#existing_car_variant_id').html('<option value="">Please select Variant</option>');
                        $.each(sorting(e.data), function(key, value) {
                            if(key != ''){
                                $('#existing_car_variant_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                            }
                        });
                        // $('#existing_car_model_id').removeAttr('disabled');
                    }
                }
            });
        });

        $("#check_all").click(function () {
            $(".check:not(:disabled)").prop('checked', $(this).prop('checked'));
        });

        console.log($('.inspection .custom-checkbox .custom-control-input:not(#check_all)').length);
        console.log($('.inspection .custom-checkbox .custom-control-input:not(#check_all):checked').length);

        $('.custom-checkbox').on('change', function() {
            var checkbox_size = $('.inspection .custom-checkbox .custom-control-input:not(#check_all)').length;
            var checked_length = $('.inspection .custom-checkbox .custom-control-input:not(#check_all):checked').length;

            if(checkbox_size == checked_length) {
                $('.inspection .custom-checkbox #check_all').prop({
                    indeterminate: false,
                    checked: true
                });
            } else if(checked_length == 0) {
                $('.inspection .custom-checkbox #check_all').prop({
                    indeterminate: false,
                    checked: false
                });
            } else {
                $('.inspection .custom-checkbox #check_all').prop({
                    indeterminate: true,
                    checked: false
                });
            }
        })
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
</script>
@endsection
