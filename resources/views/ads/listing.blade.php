@extends('layouts.master')

@section('title') Ads Listing @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/calendar.min.css')}}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-preview.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-edit.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-file-poster.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
@endsection

@section('content')
    <!-- start page title -->
    @if ($errorSuccessMessages = Session::get('errorSuccessMessages'))
        @if (@$errorSuccessMessages['error'])
            @foreach ($errorSuccessMessages['error'] as $message)
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ $message }}
                </div>
            @endforeach
        @endif
        @if (@$errorSuccessMessages['success'])
            @foreach (@$errorSuccessMessages['success'] as $message)
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ $message }}
                </div>
            @endforeach
        @endif
    @endif
    <div id="ajax_error"></div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">
                    <span class="mr-3">Ads Listing</span>
                    @can('ads_manage')
                        <a href="{{ $submit }}">
                            <button type="button" class="btn btn-outline-success waves-effect waves-light btn-sm">
                                <i class="mdi mdi-plus mr-1"></i> Create Ads
                            </button>
                        </a>
                    @endcan
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Ads Brand</a>
                        </li>
                        <li class="breadcrumb-item active">Listing</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12 mb-2">
            <x-nav-tab :routeList="$route_list" :currentRoute="$current_route"/>
        </div>
    </div>
    <div class="row" style="overflow-width:hidden">
        <div class="col-12">
            <form method="POST" action="{{ route('ads_listing') }}">
                @csrf
                <div class="card">
                    <div class="cars-card-col">
                        <div class="row">
                            <div class="col">
                                <h6>Filter By</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <input type="text" class="form-control select_active" name="freetext"
                                       value="{{@$search['freetext']}}" placeholder="Search by keyword / Reference no">
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="company_id" class="form-control select2 select2_active" id="company_id">
                                    @foreach($company_sel as $key => $val)
                                        <option
                                            value="{{$key}}" {{ $key == @$search['company_id'] ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="user_id" class="form-control select2 select2_active" id="user_id">
                                    <option value="">Please select user</option>
                                    {{-- <optgroup label="Dealer">
                                        @foreach($get_dealer_sel as $key => $val)
                                            <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{$val}}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Sales Agent">
                                        @foreach($get_sales_agent_sel as $key => $val)
                                            <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{$val}}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Broker">
                                        @foreach($get_broker_sel as $key => $val)
                                            <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{$val}}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Private User">
                                        @foreach($get_private_user_sel as $key => $val)
                                            <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{$val}}</option>
                                        @endforeach
                                    </optgroup> --}}
                                    @foreach($user_sel as $user_type_name => $row)
                                        <optgroup label="{{ $user_type_name }}">
                                            @foreach($row as $key => $val)
                                                <option
                                                    value="{{ $key }}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{ $val }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="admin_user_id" class="form-control select2 select2_active"
                                        id="admin_user_id">
                                    @foreach($admin_sel as $key => $val)
                                        <option
                                            value="{{$key}}" {{ $key == @$search['admin_user_id'] ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="car_brand_id" class="form-control select2 select2_active"
                                        id="car_brand_id">
                                    @foreach($car_brand_sel as $key => $val)
                                        <option
                                            value="{{$key}}" {{ $key == @$search['car_brand_id'] ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="car_model_id" class="form-control select2 select2_active"
                                        id="car_model_id">
                                    @if(@$search['car_brand_id'])
                                        <option value="">Car Model</option>@endif
                                    @foreach($car_model_sel as $key => $val)
                                        <option
                                            value="{{$key}}" {{ $key == @$search['car_model_id'] ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                <select name="car_variant_name" class="form-control select2 select2_active"
                                        id="car_variant_name">
                                    @if(@$search['car_model_id'])
                                        <option value="">Car Variant</option>@endif
                                    @foreach($car_variant_sel as $key => $val)
                                        <option
                                            value="{{$key}}" {{ $key == @$search['car_variant_name'] ? 'selected' : '' }}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                {!! Form::select('setting_ads_category_id', $ads_category_sel, @$search['setting_ads_category_id'], ['class' => 'form-control select_active']) !!}
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                {!! Form::select('ads_type_id', $ads_type_sel, @$search['ads_type_id'], ['class' => 'form-control select_active']) !!}
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                {!! Form::select('setting_coverage_area_id', $setting_coverage_area_sel, @$search['setting_coverage_area_id'], ['class' => 'form-control select_active']) !!}
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                {!! Form::select('bump_auto_scheduler', $bump_auto_scheduler_sel, @$search['bump_auto_scheduler'], ['class' => 'form-control select_active']) !!}
                            </div>
                            <div class="col-12 col-sm-12 col-md-3 my-2">
                                {!! Form::select('ads_order_by', $ads_order_by_sel, @$search['ads_order_by'], ['class' => 'form-control select_active']) !!}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="tab-pane active" id="home1" role="tabpanel">
                        <div class="cars-card-col">
                            <div class="row d-flex justify-content-between">
                                <div class="col-5 my-auto">
                                    @can('ads_manage')
                                        <input class="mr-3" type="checkbox" id="check_all" value="1">
                                        Select All
                                        {{--<button type="button" class="cars-btn cars-btn-default" id="delete_selected" value="Delete Selected">
                                            Delete
                                        </button>
                                        <button type="button" class="cars-btn cars-btn-default sold-selected" value="Mark Sold Selected">
                                            Sold
                                        </button>
                                        <button type="button" class="cars-btn cars-btn-default cars-btn-bump-multiple" id="cars-bump-multiple" value="Bump" data-backdrop="static" data-toggle="modal" data-target=".upgrade-modal" data-setting_ads_upgrade_id="4" data-ads_id="0">
                                            Bump
                                        </button>--}}
                                    @endcan
                                </div>
                                <div class="col-7">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-success mr-2" name="submit" id="search"
                                                value="search">
                                            <i class="fas fa-search"></i> Search
                                        </button>

                                        <button type="submit" class="btn cars-btn-default" name="submit" value="reset">
                                            <i class="fas fa-times"></i> Reset
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <ul class="list-nav-group">
                        @foreach($ads_status_sel as $ads_status)
                            <li class="list-nav-group-item @if($ads_status->ads_status_id == @$search['ads_status_id']) active @endif">
                                <button type="button" value="{{ $ads_status->ads_status_id }}"
                                        class="cars-card-col cars-btn button_status">
                                    <span class="cars-font">{{ $ads_status->ads_status_name }}</span>
                                    <span class="cars-font">({{ @$count_status[$ads_status->ads_status_id] ? $count_status[$ads_status->ads_status_id] : 0 }})</span>
                                </button>
                            </li>
                        @endforeach
                        <input id="hidden_ads_value" type="hidden" name="ads_status_id" class="hidden_value_id"
                               value="{{ @$search['ads_status_id'] }}"/>
                    </ul>
                </div>
            </form>
            @if($records)
                <form id="execute_action" method="POST" action="{{ route('ads_execute_action') }}">
                    @csrf
                    @foreach($records as $row)
                        <?php
                        $preview = "<a href='" . $web_url . $row->ads_type->ads_type_slug . '/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank'>$row->ads_title</a>";
                        $preview_button = "<a href='" . $web_url . $row->ads_type->ads_type_slug . '/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank'><button type='button' class='btn btn-primary waves-effect waves-light pending-approval-button mb-2' data-ads_id='" . $row->ads_id . "'>Preview</button></a>";
                        $status_action = '';
                        $report = '';

                        switch (true) {
                            case ($row->ads_status_id == 1):
                                $status = "<span class='badge badge-warning cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
									<a href='" . $web_url . 'car/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank' class='cars-icon-default ml-2'>
										<i class='bx bxs-show font-size-16'></i>
									</a>
									<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span>";
                                break;
                            case ($row->ads_status_id == 2 || $row->is_pending_approval)://pending approval
                                $status = "<span class='badge badge-secondary cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
									<a href='" . $web_url . 'car/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank' class='cars-icon-default ml-2'>
										<i class='bx bxs-show font-size-16'></i>
									</a>
									<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span> ";
                                $status_action = '<a class="btn btn-primary waves-effect pending-approval-button mb-2" href="' . route('ads_pending_verification', $row->ads_id) . '">Verification</a>';
                                break;
                            case ($row->ads_status_id == 3)://published
                                $status = "<span class='badge badge-success cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
								<a class='btn cars-btn-default cars-duplicate waves-effect waves-light ml-2 ' data-ads_id='" . $row->ads_id . "'>Duplicate</a>
								<a class='btn cars-btn-default waves-effect waves-light ml-2 cars-sold' data-toggle='modal' data-target='.info-ads-modal' data-ads_id='" . $row->ads_id . "'>Sold</a>

<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>

								<a href='" . $web_url . 'car/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank' class='cars-icon-default ml-2'>
									<i class='bx bxs-show font-size-16'></i>
								</a>
								<span data-ads_id='" . $row->ads_id . "' class='delete ml-2'>
									<a href='javascript:void(0);' class='cars-icon-default'>
										<i class='bx bxs-trash-alt font-size-16'></i>
									</a>
								</span> ";

                                $status_action = '<div class="row mb-3">
								<div class="col-6">
									Current Page <span class="font-weight-bolder font-size-16">' . $row->page_num . '</span>
								</div>
								<div class="col-6">
									Bump Remain <span class="font-weight-bolder font-size-16">' . ($row->ads_bump_schedule_active ? $row->ads_bump_remain : 0) . '</span>
								</div>
							</div>';

                                if ($row->has_ads_upgrade) {
                                    if ($row->ads_upgrade_active) {
                                        $ads_upgrade_setting = $row->ads_upgrade_active->setting_ads_upgrade;
                                        $status_action .= '<div class="badge badge-upgrade font-size-10 cars-status-padding mb-3" style="background-color: ' . $ads_upgrade_setting->setting_ads_upgrade_color . '">' . $ads_upgrade_setting->setting_ads_upgrade_name . '</div>';
                                    }

                                    if ($row->ads_bump_next || $row->ads_bump_auto_scheduler_active) {
                                        if ($row->ads_bump_next) {
                                            $status_action .= '<div class="mb-2"><div class="mb-2">Bump Schedule</div>';

                                            foreach ($row->ads_bump_next as $next_bump) {
                                                $status_action .= '<span class="font-size-11 font-weight-bolder">' . $next_bump['date'] . ' ' . $next_bump['time'] . '<br/></span>';
                                            }

                                            $status_action .= '</div>';
                                        }
                                    }
                                } else {
                                    $status_action .= '<div class="mb-2">';
                                    foreach ($setting_ads_upgrade as $upgrade) {
                                        if ($upgrade->ads_classified_id == $row->ads_classified_id) {
                                            if (!($row->setting_ads_category_id == 5 && $upgrade->setting_ads_category_id == 2)) {
                                                if ($upgrade->is_disabled) {
                                                    $status_action .= '<div class="btn cars-yellow-bg-color waves-effect waves-light text-dark cars-upgrade-disabled"><div class="row"><div class="col-3"><i class="' . $upgrade->setting_ads_upgrade_icon . ' upgrade-icon"></i></div><div class="col-9">' . $upgrade->setting_ads_upgrade_name . '</div></div></div>';
                                                } else {
                                                    $status_action .= '<div data-toggle="modal" data-target=".upgrade-modal" data-backdrop="static" data-setting_ads_upgrade_id="' . $upgrade->setting_ads_upgrade_id . '" data-ads_id="' . $row->ads_id . '" class="btn cars-yellow-bg-color waves-effect waves-light text-dark cars-upgrade"><div class="row"><div class="col-3"><i class="' . $upgrade->setting_ads_upgrade_icon . ' upgrade-icon"></i></div><div class="col-9" data-ads_id="' . $row->ads_id . '">' . $upgrade->setting_ads_upgrade_name . '</div></div></div>';
                                                }
                                            }
                                        }
                                    }

                                    $status_action .= '</div>';
                                }

                                $status_action .= '<p class="mb-2">Last Updated: ';

                                if ($row->ads_date_last_bump != 0) {
                                    $status_action .= date('Y-m-d', strtotime($row->ads_date_last_bump));
                                } else {
                                    $status_action .= date('h:i A', strtotime($row->ads_date_last_bump));
                                }
                                $status_action .= '</p>';

                                $status_action .= '<p class="mb-0">Expired In: ' . $row->ads_expired_days . '</p>';

                                if ($row->ads_bump_auto_scheduler_active) {

                                    $status_action .= '<div class="d-flex flex-row flex-wrap justify-content-between mt-4 mb-2">
                                                            <span class="font-weight-bolder">Autorun Bump</span>
                                                            <div class="float-right">
                                                                <a href="javascript: void(0);" class="font-weight-bolder text-theme cars-bump-edit" data-toggle="modal" data-target=".upgrade-modal"
                                                                    data-backdrop="static"
                                                                    data-ads_id="' . $row->ads_id . '">EDIT</a>
                                                                <span>|</span>
                                                                <a href="javascript: void(0);" class="font-weight-bolder text-danger cars-bump-cancel"
                                                                    onclick="cancel_auto_bump_scheduler(' . $row->ads_bump_auto_scheduler_active->ads_bump_auto_scheduler_id . ')"
                                                                    data-ads_id="' . $row->ads_id . '">CANCEL</a>
                                                            </div>
                                                        </div>';
                                    $status_action .= view('ads.auto_scheduler_bump_detail_body', ['day_list' => $day_list, 'ads_bump_auto_scheduler' => $row->ads_bump_auto_scheduler_active])->render();

                                }


                                $report = "<span class='report-flag ml-2'>
							<a href='" . route('ads_pending_verification', $row->ads_id) . "' class='cars-icon-default'>
								<i class='bx bxs-flag-alt font-size-16'></i>
							</a>
						</span>";
                                break;
                            case ($row->ads_status_id == 4):
                                $status = "<span class='badge badge-danger cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
						<a class='btn cars-btn-default cars-duplicate waves-effect waves-light ml-2 ' data-ads_id='" . $row->ads_id . "'>Duplicate</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
						<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span>";
                                $status_action = '<button type="button" class="btn btn-danger waves-effect pending-approval-button mb-2 rejected_reason" data-toggle="modal" data-target="#activate" data-id="' . $row->ads_id . '" value="' . $row->ads_id . '">Rejected Reason</button>';
                                break;
                            case ($row->ads_status_id == 5):
                                $status = "<span class='badge badge-primary cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
						<a class='btn cars-btn-default cars-duplicate waves-effect waves-light ml-2 ' data-ads_id='" . $row->ads_id . "'>Duplicate</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
						<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span>";

                                if ($row->sold_as_premier == 1) {
                                    if ($row->setting_warranty_company) {
                                        $status_action .= 'Warranty Company:<br/>' . '<b  style="word-break: break-all">' . $row->setting_warranty_company->setting_warranty_company_name . '</b>';
                                        if ($row->hasMedia('warranty_cover')) {
                                            $status_action .= '<br/><a class="iframe form-text text-primary mb-2"  href="' . $row->getFirstMediaUrl('warranty_cover') . '">
                                        View Warranty Cover
                                    </a>';
                                        }
                                    }
                                }
                                break;
                            case ($row->ads_status_id == 6):
                                $status = "<span class='badge badge-warning cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a class='btn cars-btn-default cars-duplicate waves-effect waves-light mr-3 ' data-ads_id='" . $row->ads_id . "'>Duplicate</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
						<a href='" . route('ads_edit', $row->ads_id) . "' class='cars-icon-default mr-3' type='button'><i class='bx bxs-pencil font-size-16'></i></a><span data-ads_id='" . $row->ads_id . "' class='delete pl-2'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span>";
                                break;
                            case ($row->ads_status_id == 7):
                                $status = "<span class='badge badge-primary cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>

						<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span>";
                                // $preview = $row->ads_title;
                                break;
                            case ($row->ads_status_id == 8):
                                $status = "<span class='badge badge-secondary cars-status-padding'>{$row->ads_status->ads_status_name}</span>";
                                $action = "<a href='" . route('ads_edit', $row->ads_id) . "' class='btn cars-btn-default cars-edit waves-effect waves-light'>Edit</a>
<a class='btn cars-btn-default waves-effect waves-light ml-2 ads-log' data-toggle='modal' data-target='.info-ads-log' data-ads_id='" . $row->ads_id . "'>Log</a>
									<a href='" . $web_url . 'car/' . $row->ads_slug . '/' . $row->ads_id . '/' . md5($row->ads_id . $encryption_code) . '?preview=true' . "' target='_blank' class='cars-icon-default ml-2'>
										<i class='bx bxs-show font-size-16'></i>
									</a>
									<span data-ads_id='" . $row->ads_id . "' class='delete ml-4'><a href='javascript:void(0);' class='cars-icon-default'><i class='bx bxs-trash-alt font-size-16'></i></a></span> ";
                                $status_action = '<a class="btn btn-primary waves-effect pending-approval-button mb-2" href="' . route('ads_pending_inspection_verification', $row->ads_id) . '">Verification</a>';
                                break;
                        }


                        ?>
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row m-0">
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 cars-card-col">
                                        <div class="mb-2">
                                            @can('ads_manage')
                                                <input type="checkbox" name="ads_id[]" value="{{ $row->ads_id }}"
                                                       class="check-ads-id mr-2"
                                                       onchange="save_selected_ads_id('update', this.checked,[{{ $row->ads_id }}])"
                                                       @if(in_array($row->ads_id,session('selected_ads_id',[]))) checked @endif>
                                            @endcan
                                            <span
                                                class="font-weight-bolder mr-2">#{{ sprintf("%08d", $row->ads_id) }}</span>
                                            {!! $status !!}
                                            {!! $report !!}
                                        </div>
                                        <div class="img-wrap cars-cover-img border">
                                            @if(!empty($row->cover_photo) && $row->cover_photo->hasGeneratedConversion("thumb"))
                                                <img class="photo" src="{{ $row->cover_photo->getUrl('thumb') }}"
                                                     class="card-img-top card-company-banner" width="100%">
                                                @if($row->hasMedia('ads_video'))
                                                    <img src="{{ URL::asset('assets/images/video_play_button.svg') }}"
                                                         class="dealer-video-play-button">
                                                @endif
                                            @else
                                                <img class="photo" src="{{ asset('images/no_image_available.png') }}"
                                                     class="card-img-top card-company-banner" width="100%">
                                            @endif
                                        </div>
                                        <div class="image-count p-2 font-size-16">
                                            <i class="bx bx-camera"></i>
                                            {{ $row->ads_images_count }}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 cars-detail-card">
                                        <div class="mb-2">
                                            <?php
                                            $ads_updated = $row->ads_updated;
                                            $ads_date_display = $row->ads_date_display ? 'Posted On: <span class="font-weight-bolder">' . date('Y-m-d', strtotime($row->ads_date_display)) . '</span>' : 'Created On: <span class="font-weight-bolder">' . $row->ads_created->format('Y-m-d') . '</span>';
                                            ?>
                                            <span
                                                class="cars-text-grey font-size-11 text-nowrap mr-2">{!! $ads_date_display !!}</span>
                                            <span class="cars-text-grey font-size-11 text-nowrap mr-2">Updated On: <span
                                                    class="font-weight-bolder">{{ $ads_updated->format('Y-m-d') }} </span></span>

                                            @if(!empty($row->ads_date_last_bump) && $row->ads_date_last_bump != '2020-01-01 00:00:00')
                                                <span class="cars-text-grey font-size-11 text-nowrap">
                                                    Bumped On:
                                                    <span class="font-weight-bolder">
                                                        {{ date('Y-m-d h:i A', strtotime($row->ads_date_last_bump)) }}
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <h5>
                                                {!! $preview !!}
                                            </h5>
                                        </div>
                                        <div class="mb-2">
                                            <span
                                                class="badge badge-secondary mr-2 cars-status-padding">{{ $row->ads_type->ads_type_name }}</span>
                                            <span class="mr-2"><img class="mr-2"
                                                                    src="{{ URL::asset('images/engine_cc.svg') }}">{{ @$row->car_variant ? $row->car_variant->car_variant_cc : '-' }}</span>
                                            <span><img class="mr-2" src="{{ URL::asset('images/transmission.svg') }}">{{ @$row->car_variant ? $row->car_variant->car_variant_transmission: '-' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <span
                                                class="font-weight-bold">{{ strtoupper($row->ads_category->setting_ads_category_name) }}</span><br/>
                                            @if($row->car_chassis_no)
                                                Chassis No. <span
                                                    class="font-weight-bolder">{{ $row->car_chassis_no }}</span>
                                            @else
                                                Plate No. <span
                                                    class="font-weight-bolder">{{ $row->car_plate_no }}</span>
                                            @endif
                                            @if($row->is_registration_card > 0 && @$row->hasMedia('ads_registration_card'))
                                                <a class="iframe" data-fancybox-type="image"
                                                   href="{{ $row->ads_registration_card->getUrl() }}">
                                                    <img src="{{asset('')}}assets/images/bxs-credit-card-front.png"
                                                         alt="" class="img-fluid">
                                                </a>
                                            @endif
                                            <br/>
                                            Reference No. <span
                                                class="font-weight-bolder">{{ $row->car_reference_no }}</span></br>
                                        </div>
                                        <div class="mb-3">
                                            <span
                                                class="font-weight-bolder">{{ $row->user->join_company ? ucwords($row->user->join_company->company->company_name) : 'Private' }}</span></br>
                                            <span>{{ $row->user->user_type->user_type_name }}</span> Name <span>({{ $row->user->user_fullname }})</span></br>
                                        </div>
                                        <div class="mb-2">
                                            @switch($row->setting_ads_display_price_id)
                                                @case(1)
                                                @if($row->is_discount == 0)
                                                    Current Price
                                                    <div class="cars-text-theme-color font-size-20 font-weight-bolder">
                                                        RM {{ number_format($row->ads_price, 0) }}</div>
                                                @else
                                                    <?php
                                                    $discount = $row ? (1 - round(($row->ads_price / $row->ads_price_before_discount), 2)) * 100 : 0;
                                                    ?>
                                                    <div class="text-muted mr-2">
                                                        <del>
                                                            RM {{ number_format($row->ads_price_before_discount ?? 0, 0) }}</del>
                                                    </div>
                                                    <span
                                                        class="text-danger text-uppercase mr-2">{{$discount}}% Off</span>
                                                    <span
                                                        class="font-weight-bold font-size-16">RM{{ number_format($row->ads_price ?? 0, 0) }}</span>
                                                @endif
                                                @break
                                                @case(2)
                                                @if ($row->ads_upgrade_active)
                                                    <?php
                                                    $discount = (1 - round(($row->ads_upgrade_active->ads_upgrade_price / $row->ads_upgrade_active->ads_upgrade_avg_price), 2)) * 100;
                                                    ?>
                                                <!-- <span class="cars-upgrade-avg-price">RM {{ number_format($row->ads_upgrade_active->ads_upgrade_avg_price, 0) }} Avg. mkt.</span><br/>
											<span class='badge badge-soft-danger'>{{ $discount }}%</span><span class="ml-2 text-danger font-size-16 font-weight-bolder">RM {{ number_format($row->ads_upgrade->ads_upgrade_price, 0) }}</span> -->
                                                    <h6><span class="text-muted mr-2"><del>RM {{ number_format($row->ads_upgrade_active->ads_upgrade_avg_price, 0) }}</del> Avg. mkt.</span>
                                                    </h6>
                                                    <span
                                                        class="text-danger text-uppercase mr-2">{{ $discount }}% Off</span>
                                                    <span
                                                        class="font-weight-bold font-size-16">RM{{ number_format($row->ads_upgrade->ads_upgrade_price, 0) }}</span>
                                                @else
                                                    Current Price <span
                                                        class="cars-text-theme-color font-size-20 font-weight-bolder">RM {{ number_format($row->ads_price, 0) }}</span>
                                                @endif
                                                @break
                                                @case(3)
                                                @if ($row->ads_upgrade_active)
                                                    <?php
                                                    $current = new DateTime();
                                                    $end = new DateTime($row->ads_upgrade_active->ads_upgrade_end);
                                                    $date = $end->diff($current);

                                                    $day = $date->days > 0 ? ($date->days > 1 ? $date->days . ' DAYS' : $date->days . 'DAY') : '';
                                                    $hour = $date->h > 0 ? ($date->h > 1 ? $date->h . ' HOURS' : $date->h . ' HOUR') : 'LESS THAN AN HOUR';
                                                    ?>
                                                    <h5 class="text-danger font-weight-bolder">{{ $day }} {{ $hour }}</h5>
                                                    <small>Left for this deal to end, call now!</small>
                                                @endif
                                                @break
                                            @endswitch
                                        </div>
                                        @if(@$row->inspection_list_url)
                                            <div class="mb-2">
                                                <a href="{{ $row->inspection_list_url }}" target="_blank"
                                                   class="btn btn-primary btn-sm">View Inspection List</a>
                                                <a href="{{route('inspection_list_edit',$row->ads_id)}}"
                                                   class="btn btn-outline-secondary btn-sm">Edit</a>
                                            </div>
                                    @endif
                                    <!-- <div class="d-flex mb-2">
								{!! Form::select('price_guide_period', $price_guide_period, @$post->price_guide_period, ['class' => 'form-control cars-price_guide_period'] ) !!}
                                        <button type="button" class="btn cars-yellow-bg-color waves-effect waves-light text-dark cars-price_guide" data-car_variant_id="{{ $row->car_variant_id }}">
									Price Guide
								</button>
							</div>
							<div class="loadingmessage text-center" style="display:none">
								<img src='{{ URL::asset('assets/images/loading.gif')}}'/>
							</div>
							<div class="price_guide_table" style="display:none">
								<table class="table table-bordered" style="width: 100%">
									<tr align="center">
										<td class="m-0 p-2">
											<span>Average Low</span>
											<h6 class="lowest_price">test</h6>
										</td>
										<td class="m-0 p-2">
											<span>Average Price</span>
											<h6 class="average_price"></h6>
										</td>
										<td class="m-0 p-2">
											<span>Average High</span>
											<h6 class="highest_price"></h6>
										</td>
									</tr>
								</table>
							</div> -->
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 cars-card-col">
                                        <div class="mb-2 text-right">
                                            @can('ads_manage')
                                                {!! $action !!}
                                            @endcan
                                        </div>
                                        {{-- <div class="row m-0 p-3 bg-primary text-white">
                                            <div class="col-5 p-0"><span class="font-weight-bolder">{{ $row->total_view }}</span> Views</div>
                                            <div class="col-1 p-0 text-center">|</div>
                                            <div class="col-6 p-0 pl-2"><span class="font-weight-bolder">{{ $row->total_impression }}</span> Impression</div>
                                        </div > --}}
                                        <div
                                            class="d-none d-sm-flex justify-content-between m-0 p-3 bg-primary text-white">
                                            <div><span class="font-weight-bolder">{{ $row->total_view }}</span> Views
                                            </div>
                                            <div>|</div>
                                            <div><span
                                                    class="font-weight-bolder">{{ $row->total_view_by_7_days }}</span>
                                                Views (7D)
                                            </div>
                                            <div>|</div>
                                            <div><span class="font-weight-bolder">{{ $row->total_impression }}</span>
                                                Imp
                                            </div>
                                        </div>
                                        <div class="d-none d-sm-block border apex-charts"
                                             id="line_chart_dashed_{{ $row->ads_id }}" dir="ltr">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 p-0 d-flex">
                                        <div class="cars-bump-section position-relative w-100">
                                            {!! $status_action !!}
                                            @if(!$row->ads_bump_schedule_active)
                                                @php
                                                    $visibility = null;
                                                    $visibility_class = 'low-visibility-color';
                                                    $visibility_font_class = 'low-visibility-font-color';
                                                    $visibility_tooltip_class = 'low-visibility-tooltip-color';
                                                    $visibility_btn_class = 'cars-btn-default1';

                                                    if ($row->page_num >= 10) {
                                                        $visibility = 'very low visibility';
                                                    } elseif ($row->page_num >= 5) {
                                                        $visibility = 'low visibility';
                                                    } elseif ($row->page_num >= 3) {
                                                        $visibility = 'suggest to bump';
                                                        $visibility_class = 'low-visibility-yellow';
                                                        $visibility_font_class = 'low-visibility-font-yellow';
                                                        $visibility_tooltip_class = 'low-visibility-tooltip-yellow';
                                                        $visibility_btn_class = 'cars-btn-default-yellow';
                                                    }
                                                @endphp

                                                @if($visibility)
                                                    <div style="height: 50px"></div>
                                                    <div class="position-absolute fixed-bottom">
                                                        <div
                                                            class="d-flex justify-content-between badge badge-danger font-size-16 cars-status-padding {{ $visibility_class }} w-100">
                                                        <span
                                                            class="my-auto font-size-13 mr-2 {{ $visibility_font_class }} text-uppercase">{{ $visibility }} <i
                                                                class="mdi mdi-help-circle-outline {{ $visibility_tooltip_class }}"
                                                                data-toggle="tooltip"
                                                                data-placement="top" data-html="true" data-title="
                                                            <div class='row'>
                                                                <div class='col-5 border-right'>
                                                                    <div class='font-size-12 font-weight-bold {{ $visibility_font_class }} text-capitalize'>{{ $visibility }}</div>
                                                                    <div class='low-visibility-content text-left'>The probability of a potential buyer saw this ads listing is low</div>
                                                                </div>
                                                                <div class='text-dark col-7'>
                                                                    <div class='font-size-12 font-weight-bold'>Current Ads Criteria</div>
                                                                    <div class='text-left'>
                                                                        <div>Brand <span class='ml-2 font-weight-bold'>{{ $row->car_brand->car_brand_name }}</span></div>
                                                                    </div>
                                                                    <div class='text-left'>
                                                                        <div>Body Type <span class='ml-2 font-weight-bold'>{{ $row->car_body_type->car_body_type_name }}</span></div>
                                                                    </div>
                                                                    <div class='text-left'>
                                                                        <div>Condition <span class='ml-2 font-weight-bold'>{{ $row->ads_type->ads_type_name }}</span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            "></i>
                                                        </span>
                                                            <button type="button"
                                                                    class="cars-btn {{ $visibility_btn_class }} btn-hover-opacity cars-btn-bump-multiple1 cars-bump-now"
                                                                    data-toggle="modal" data-target=".upgrade-modal"
                                                                    data-backdrop="static"
                                                                    data-setting_ads_upgrade_id="{{ $setting_ads_upgrade_bump->setting_ads_upgrade_id }}"
                                                                    data-ads_id="{{ $row->ads_id }}">
                                                                BUMP NOW
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Rejected modal --}}
                    <div class="modal fade" id="activate" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>Rejected Reason</h4>
                                        <p class="reject_message"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                </form>
            <!-- <ul class="pagination pagination-rounded justify-content-end mb-2">
				<li class="page-item">
					<a class="page-link" href="{{ $records->previousPageUrl() }}" aria-label="Previous">
						<i class="mdi mdi-chevron-left"></i>
					</a>
				</li>
				@for ($i = 1; $i <= $records->lastPage(); $i++)
                <li class="page-item @if($records->currentPage() == $i) active  @endif">
						<a class="page-link" href="{{ $records->url($i) }}">{{ $i }}</a>
					</li>
					@endfor
                <li class="page-item">
                    <a class="page-link" href="{{ $records->nextPageUrl() }}" aria-label="Next">
							<i class="mdi mdi-chevron-right"></i>
						</a>
					</li>
			</ul> -->
                {{ $records->links() }}
            @endif
        </div>
    </div>


    <!-- End Modal -->
    <!-- End Page-content -->

    <!-- Modal Upgrade -->
    <div class="modal fade bs-example-modal-lg upgrade-modal" tabindex="-1" role="dialog"
         aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" id="setting_ads_upgrade">

        </div>
    </div>
    <!-- End Modal -->

    <div class="modal fade info-ads-modal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="ads_detail" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" id="info-ads">

        </div>
    </div>

    <div class="modal fade info-ads-log" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="ads_detail" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" id="info-ads-log">

        </div>
    </div>

    <div class="modal fade" id="auto_scheduler_bump_detail" tabindex="-1" role="dialog"
         aria-labelledby="auto_scheduler_bump_detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" id="auto_scheduler_bump_detail_content">
        </div>
    </div>

    <div id="selected_bar" style="height: 70px">
        <div class="main-content fixed-bottom" style="box-shadow: 10px -3px 10px #e2e0e0;">
            <div class="d-flex flex-nowrap justify-content-around align-items-center py-0 px-4 bg-white"
                 style="min-height: 60px">
                <div class="d-inline-flex align-items-center">
                    <button type="button" class="close mr-2" aria-label="Close" onclick="save_selected_ads_id('reset')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="badge badge-secondary text-white p-2 mr-2" id="selected_bar_total">0</span>
                    Ad Selected
                </div>
                <div class="d-inline-flex flex-nowrap justify-content-end mt-1">
                    <button type="button" class="btn btn-light btn-select-action font-weight-bold" id="delete_selected"
                            value="Delete Selected">
                        <div class="d-flex flex-row justify-content-center">
                            Delete
                            <div class="d-none d-sm-block ml-1">Selected</div>
                            <div id="btn-select-delete-spinner" class="spinner-border spinner-border-sm ml-1"
                                 style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </button>
                    @if(isset($search['ads_status_id']) && $search['ads_status_id'] == 3) {{-- Published --}}
                    <button type="button" class="btn btn-warning btn-select-action sold-selected" data-toggle="modal"
                            data-target=".info-ads-modal" value="Sold Selected">
                        <div class="d-flex flex-row justify-content-center">
                            Sold
                            <div class="d-none d-sm-block ml-1">Selected</div>
                            <div id="btn-select-sold-spinner" class="spinner-border spinner-border-sm ml-1"
                                 style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </button>
                    @endif
                    @if(isset($search['ads_status_id']) && in_array($search['ads_status_id'],[1,6])) {{-- Draft, Expired --}}
                    <button type="button" class="btn btn-company btn-select-action"
                            onclick="ajax_ads_update_selected('publish',{{$search['ads_status_id']}})">
                        <div class="d-flex flex-row justify-content-center">
                            Publish
                            <div class="d-none d-sm-block ml-1">Selected</div>
                            <div id="btn-select-publish-spinner" class="spinner-border spinner-border-sm ml-1"
                                 style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </button>
                    @endif
                    @if(isset($search['ads_status_id']) && $search['ads_status_id'] == 3) {{-- Published --}}
                    <button type="button" class="btn btn-success btn-select-action" id="cars-bump-multiple" value="Bump"
                            data-backdrop="static" data-toggle="modal" data-target=".upgrade-modal"
                            data-setting_ads_upgrade_id="4" data-ads_id="0">
                        <div class="d-flex flex-row justify-content-center">
                            Bump
                            <div class="d-none d-sm-block ml-1">Selected</div>
                        </div>
                    </button>
                    <a class="btn btn-primary btn-select-action" id="cars-bump-multiple"
                       href="{{ route('ads_upgrade_bulk_promotion') }}">
                        <div class="d-flex flex-row justify-content-center">
                            Promote
                            <div class="d-none d-sm-block ml-1">Selected</div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- apexcharts init -->
    <!-- <script src="{{ URL::asset('assets/js/pages/apexcharts.init.js')}}"></script> -->

    <!-- Magnific Popup -->
    <script src="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>

    <!-- Tour init js -->
    <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>

    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-preview.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-resize.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-transform.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-crop.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-edit.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-file-poster.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-image-exif-orientation.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-size.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{ asset('assets/js/filepond/filepond.js')}}"></script>

    <script>

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

        $(document).ready(function (e) {

            show_selected_bar({{ count(session('selected_ads_id',[])) }});


            $('.low-visibility-tooltip-color').tooltip({
                // trigger:'manual',
                offset: '100',
                template: '<div class="tooltip low-visibility-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner low-visibility-tooltip-border-color"></div></div>'
            });

            $('.low-visibility-tooltip-yellow').tooltip({
                // trigger:'manual',
                offset: '100',
                template: '<div class="tooltip low-visibility-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner low-visibility-tooltip-border-yellow"></div></div>'
            });

            $('#more_info').hover(function () {
                console.log('dah hover');
                $('#popout').css("display", "block");
            })

            $('#more_info').mouseout(function () {
                $('#popout').css("display", "none");
            })

            $('#company_id').on('change', function () {
                var company_id = $("#company_id option:selected").val();
            });

            $('#car_brand_id').on('change', function () {
                var car_brand_id = $("#car_brand_id option:selected").val();

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_car_model')}}",
                    data: {
                        car_brand_id: car_brand_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_model_id').html('<option value="">Please select Model</option>');
                            $('#car_variant_name').html('<option value="">Please select Variant</option>');
                            $.each(sorting(e.data), function (key, value) {
                                if (key != '') {
                                    $('#car_model_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                                    $('#car_model_id').select2();
                                    $('#car_variant_name').select2();
                                }
                            });
                        }
                    }
                });
            });

            $('#car_model_id').on('change', function () {
                var car_model_id = $("#car_model_id option:selected").val();

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_select_car_variant')}}",
                    data: {
                        car_model_id: car_model_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        if (e.status == true) {
                            $('#car_variant_name').html('<option value="">Please select Variant</option>');
                            $.each(e.data, function (key, value) {
                                if (key != '') {
                                    $('#car_variant_name').append('<option value="' + key + '">' + value + '</option>');
                                    $('#car_variant_name').select2();
                                }
                            });
                        }
                    }
                });
            });

            $('.delete').on('click', function () {
                var id = $(this).attr('data-id');
                $(".modal-body #ads_id").val(id);
            });
            // $('.rejected_reason').on('click', function() {
            // 	var id = $(this).attr('data-id');
            // 	console.log(id);
            // 	$(".modal-body #ads_id").val(id);
            // });

            $('.rejected_reason').on('click', function () {
                var reject_id = $(this).val();
                console.log(reject_id);

                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_rejected_reason')}}",
                    data: {
                        reject_id: reject_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        $('.reject_message').html('');
                        if (e.status == true) {
                            $('.reject_message').text(e.data);
                        }
                    }
                });
            });

            $('[data-toggle="popover"]').popover({
                html: true,
                placement: 'auto left'
            });


            $('.button_status').on('click', function () {

                var value_ads = this.value;
                // alert(value_ads);
                $('#hidden_ads_value').val(value_ads);
                $('#search').click();
            });

            <?php
            foreach ($records as $row) {
            ?>
            var options = {
                chart: {
                    height: 175,
                    type: 'line',
                    stacked: true,
                    animations: {
                        enabled: false
                    },
                    toolbar: {
                        tools: {
                            download: false,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                        },
                    }
                },
                colors: ['#0066FF', '#DA9700', '#34C38F'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [2, 2, 2],
                    curve: 'straight',
                    dashArray: [0, 0, 0]
                },
                series: [
                    {
                        name: "View",
                        data: {!! json_encode(array_values($row->chart_data->view)) !!},
                        type: 'bar',
                    },
                    {
                        name: "Bump",
                        data: {!! json_encode(array_values($row->chart_data->bump)) !!},
                        type: 'bar',
                    },
                    {
                        name: 'Impression',
                        data: {!! json_encode(array_values($row->chart_data->impression)) !!},
                        type: 'line',
                    }],
                title: {
                    text: undefined,
                },
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                yaxis: [
                    {
                        seriesName: 'View',
                        tickAmount: 5,
                        min: 0,
                        max: function () {
                            var max = Math.max.apply(Math, {!! json_encode(array_values($row->chart_data->view)) !!});
                            // console.log(max)
                            return max > 5 ? max : 5;
                        },
                        forceNiceScale: function () {
                            var scale = false;
                            return max < 5 ? scale : true;
                        },
                        title: {
                            text: "View/Bump",
                            style: {
                                color: '#da9700',
                            }
                        },
                        labels: {
                            formatter: function (val, index) {
                                if (val) {
                                    return val.toFixed(0);
                                }

                            }
                        }
                    },
                    {
                        seriesName: 'Bump',
                        tickAmount: 5,
                        min: 0,
                        max: function () {
                            var max = Math.max.apply(Math, {!! json_encode(array_values($row->chart_data->view)) !!});
                            // console.log(max)
                            return max > 5 ? max : 5;
                        },
                        forceNiceScale: function () {
                            var scale = false;
                            return max < 5 ? scale : true;
                        },
                        show: false,
                    },
                    {
                        seriesName: 'Impression',
                        tickAmount: 5,
                        min: 0,
                        max: function () {
                            var max = Math.max.apply(Math, {!! json_encode(array_values($row->chart_data->impression)) !!});
                            // console.log(max)
                            return max > 50 ? max : 50;
                        },
                        forceNiceScale: function () {
                            var scale = false;
                            return max < 50 ? scale : true;
                        },
                        opposite: true,
                        title: {
                            text: "Impression",
                            style: {
                                color: '#da9700',
                            }
                        }
                    },
                ],
                xaxis: {
                    categories: {!! json_encode(array_values($row->chart_data->dates)) !!},
                    labels: {
                        show: false,
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                    x: {
                        show: true,
                    },
                    y: [{
                        title: {
                            formatter: function formatter(val) {
                                return val;
                            }
                        }
                    }, {
                        title: {
                            formatter: function formatter(val) {
                                return val;
                            }
                        }
                    }],
                },
                grid: {
                    borderColor: '#f1f1f1'
                }
            };
            var chart = new ApexCharts(
                document.querySelector("#line_chart_dashed_" + <?php echo $row->ads_id; ?>),
                options
            );
            chart.render();
            <?php
            }
            ?>

            // // Cars Upgrade
            $('.cars-upgrade, .cars-bump-now').on('click', function (e) {
                var setting_ads_upgrade_id = $(this).data('setting_ads_upgrade_id');
                var ads_id = $(this).data('ads_id');

                if (setting_ads_upgrade_id == 4) {
                    $.post('{{ route("ajax_get_setting_ads_upgrade_bump_multiple") }}', {
                        'ad_id': ads_id,
                        'ads_classified_id': '{{$ads_classified_id}}',
                        '_token': '{{csrf_token()}}'
                    }, function (data) {
                        $('#setting_ads_upgrade').html(data);
                    });
                } else {
                    $('#setting_ads_upgrade').html('');
                    $.get('{{ url("setting_ads_upgrade/ajax_get_setting_ads_upgrade") }}/' + setting_ads_upgrade_id + '/' + ads_id, {
                        'ad_id': ads_id,
                        'ads_classified_id': '{{$ads_classified_id}}',
                        '_token': '{{csrf_token()}}'
                    }, function (data) {
                        $('#setting_ads_upgrade').html(data);
                    });
                }


            });

            $('#cars-bump-multiple').on('click', function (e) {
                var ads_ids = []

                $(".check-ads-id:checked").each(function () {
                    ads_ids.push($(this).val());
                });

                $('#setting_ads_upgrade').html('');

                $.post('{{ route("ajax_get_setting_ads_upgrade_bump_multiple") }}', {
                    'ads_classified_id': '{{$ads_classified_id}}',
                    '_token': '{{csrf_token()}}'
                }, function (data) {
                    $('#setting_ads_upgrade').html(data);
                });
            });

            $('.cars-bump-edit').on('click', function (e) {
                var ads_id = $(this).data('ads_id');

                $('#setting_ads_upgrade').html('');
                $.get('{{ url("setting_ads_upgrade/ajax_get_edit_autorun_bump") }}/' + ads_id, function (data) {
                    $('#setting_ads_upgrade').html(data);
                });
            });

            $('#check_all').on('click', function (event) {
                if (this.checked) {
                    $('.btn-selected').prop("disabled", false);
                    $('.check-ads-id').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.btn-selected').prop("disabled", true);
                    $('.check-ads-id').each(function () {
                        this.checked = false;
                    });
                }

                save_selected_ads_id('update', this.checked, {{ $records->pluck('ads_id') }});
            });

            $('.check-ads-id').change(function () {
                if ($('.check-ads-id:checked').length > 0) {
                    $('.btn-selected').prop("disabled", false);
                } else {
                    $('.btn-selected').prop("disabled", true);
                }
            });

            $('#reset_check').on('click', function () {
                $('.check-ads-id:checked').prop('checked', false);
                $('#check_all:checked').prop('checked', false);
            });

            $('#delete_selected:enabled').on('click', function () {
                var $this = $(this);
                Swal.fire({
                    title: "Are you sure to delete?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f46a6a",
                    cancelButtonColor: "#A8B5C9",
                    confirmButtonText: "Delete"
                }).then(function (result) {
                    if (result.value) {
                        //disabled others button
                        $('.btn-select-action').prop('disabled', true);
                        $('#btn-select-delete-spinner').css('display', 'block');

                        $('.cars-sold').off('click');
                        $('.cars-duplicate').off('click');
                        $('.delete').off('click');
                        $('a').click(function (e) {
                            e.preventDefault();
                        });

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'btn_submit',
                            value: 'execute_action'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'action',
                            value: 'delete_selected'
                        }).appendTo('#execute_action');
                        $('#execute_action').submit();
                        // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    }
                });
            });

            $('.sold-selected').on("click", function () {
                $('#info-ads').html('');
                $.get('{{ url("ads/ajax_get_mark_sold_modal") }}/', function (data) {
                    $('#info-ads').html(data);
                });
            });

            $('.cars-duplicate').on('click', function () {
                var $this = $(this);
                var ads_id = $(this).data('ads_id');
                Swal.fire({
                    title: "Are you sure to duplicate?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f46a6a",
                    cancelButtonColor: "#A8B5C9",
                    confirmButtonText: "Duplicate"
                }).then(function (result) {
                    if (result.value) {
                        //disabled others button
                        $this.off('click');
                        $('.cars-sold').off('click');
                        $('.delete').off('click');
                        // $('.cars-duplicate').off('click');
                        $this.off('click');
                        $('.delete_selected').prop('disabled', true);
                        $('a').click(function (e) {
                            e.preventDefault();
                        });

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'btn_submit',
                            value: 'execute_action'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'action',
                            value: 'duplicate'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'ads_id',
                            value: ads_id
                        }).appendTo('#execute_action');
                        $('#execute_action').submit();
                    }
                });
            });

            $('.cars-approve').on('click', function () {
                var ads_id = $(this).data('ads_id');
                // console.log(ads_id);
                Swal.fire({
                    title: "Are you sure to approve?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#8CD4F5",
                    cancelButtonColor: "#A8B5C9",
                    confirmButtonText: "Approve"
                }).then(function (result) {
                    if (result.value) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'action',
                            value: 'approve'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'ads_id',
                            value: ads_id
                        }).appendTo('#execute_action');
                        $('#execute_action').submit();
                    }
                });
            });
            $('.cars-reject').on('click', function () {
                var ads_id = $(this).data('ads_id');
                // console.log(ads_id);
                Swal.fire({
                    title: "Are you sure to reject?",
                    type: "warning",
                    input: 'textarea',
                    showCancelButton: true,
                    confirmButtonColor: "#f46a6a",
                    cancelButtonColor: "#A8B5C9",
                    confirmButtonText: "Reject"
                }).then(function (result) {
                    if (result.value) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'action',
                            value: 'reject'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'message',
                            value: result.value
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'ads_id',
                            value: ads_id
                        }).appendTo('#execute_action');
                        $('#execute_action').submit();
                    }
                });
            });

            $('.cars-sold').on("click", function () {
                var id = $(this).data("ads_id");
                $('#info-ads').html('');
                $.get('{{ url("ads/ajax_get_mark_sold_modal") }}/' + id, function (data) {
                    $('#info-ads').html(data);
                });
            });


            $('.ads-log').on("click", function () {
                var id = $(this).data("ads_id");
                $('#info-ads-log').html('');
                $.get('{{ url("ads/ajax_get_log_modal") }}/' + id, function (data) {
                    $('#info-ads-log').html(data);
                });
            });


            $('.delete').on('click', function () {
                var $this = $(this);
                var ads_id = $(this).data('ads_id');
                Swal.fire({
                    title: "Are you sure to delete?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f46a6a",
                    cancelButtonColor: "#A8B5C9",
                    confirmButtonText: "Delete"
                }).then(function (result) {
                    if (result.value) {
                        //disabled others button
                        $this.off('click');
                        $('.cars-sold').off('click');
                        $('.cars-duplicate').off('click');
                        $('.delete_selected').prop('disabled', true);
                        $('a').click(function (e) {
                            e.preventDefault();
                        });

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'action',
                            value: 'delete'
                        }).appendTo('#execute_action');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'ads_id',
                            value: ads_id
                        }).appendTo('#execute_action');
                        $('#execute_action').submit();
                        // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    }
                });
            });

            $('.cars-price_guide').on('click', function () {
                var price_guide_period = $(this).siblings('.cars-price_guide_period').val();
                var dropdown = $(this);
                dropdown.parent().siblings('.price_guide_table').hide();
                dropdown.parent().siblings('.loadingmessage').show();
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_price_guide')}}",
                    data: {
                        car_variant_id: $(this).data('car_variant_id'),
                        price_guide_period: price_guide_period,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (e) {
                        dropdown.parent().siblings('.loadingmessage').hide();
                        dropdown.parent().siblings('.price_guide_table').show();
                        if (e.status) {
                            dropdown.parent().siblings('.price_guide_table').find('.lowest_price').text('RM' + e.data['min']);
                            dropdown.parent().siblings('.price_guide_table').find('.average_price').text('RM' + e.data['avg']);
                            dropdown.parent().siblings('.price_guide_table').find('.highest_price').text('RM' + e.data['max']);
                        }
                    }
                });
            });

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

            $('.low-visibility-tooltip').tooltip();
        });

        function save_selected_ads_id(action, checked = false, ads_id = []) {

            if (action === "reset") {
                $('input:checkbox').each(function () {
                    this.checked = false;
                });
            }

            $.ajax({
                type: 'POST',
                url: "{{route('ajax_save_selected_ads_id')}}",
                data: {
                    action: action,
                    checked: checked,
                    ads_id: ads_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.status) {
                        show_selected_bar(response.data.total_selected);
                    }
                }
            });
        }

        function show_selected_bar(total_selected) {
            if (parseInt(total_selected) > 0) {
                $('#selected_bar_total').html(total_selected);
                $('#selected_bar').removeClass('d-none');
                $('.footer').css("bottom", "60px");
            } else {
                $('#selected_bar').addClass('d-none');
                $('.footer').css("bottom", "0");
            }
        }

        function cancel_auto_bump_scheduler(id) {
            Swal.fire({
                title: 'Are you sure you want to cancel this autorun bump ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#f46a6a",
                cancelButtonColor: "#A8B5C9",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then(function (result) {
                if (result.value) {
                    let url = '{{ route('cancel_auto_scheduler_bump',['id' => ':id']) }}';
                    url = url.replace(':id', id);
                    location.replace(url);
                }
            });
        }

        function ajax_ads_update_selected(action, ads_status_id) {

            $('#ajax_error').empty();

            Swal.fire({
                title: "Are you sure to " + action + " the selected ads?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#31ACBF",
                cancelButtonColor: "#A8B5C9",
                confirmButtonText: action.charAt(0).toUpperCase() + action.slice(1)
            }).then(function (result) {
                if (result.value) {
                    // disabled all button
                    $('.btn-select-action').prop('disabled', true);
                    $('#btn-select-' + action + '-spinner').css('display', 'block');

                    $.ajax({
                        type: 'POST',
                        url: "{{route('ajax_ads_update_selected')}}",
                        data: {
                            action: action,
                            ads_status_id: ads_status_id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status) {
                                location.replace("{{ route('ads_listing') }}");
                            } else {
                                if (response.data.error) {
                                    let html = '';
                                    response.data.error.forEach(function (value) {
                                        html += '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' + value + '</div>';
                                    });
                                    $('#ajax_error').html(html);
                                }

                                window.scrollTo(0, 0);

                                $('.btn-select-action').prop('disabled', false);
                                $('.spinner-border').css('display', 'none');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('.btn-select-action').prop('disabled', false);
                            $('.spinner-border').css('display', 'none');
                        }
                    });
                }
            });
        }

        function sorting(data) {
            var sorted = [];
            $(data).each(function (k, v) {
                for (var key in v) {
                    sorted.push({key: key, value: v[key]})
                }
            });

            return sorted.sort(function (a, b) {
                if (a.value < b.value) return -1;
                if (a.value > b.value) return 1;
                return 0;
            });
        }

    </script>
@endsection
