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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    #img, #img1, #img2, #img3, #img4, #img5, #img6,#img7,#img8, #img9{
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
    #img,#img1,#img2,#img3,#img4,#img5,#img6,#img7,#img8,#img9 {
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
                                    <option value="{{ $countryAbb }}" @if($countryAbb == @$post->company_country_dialcode) selected @elseif ($countryAbb == @$country_abb) selected @endif data-dialcode="{{ $countryData['dialcode'] }}">
                                        {{ $countryData['country_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="gap"></div>
                                <input id="input-mask" oninput="validateInput(this)" name="company_phone" maxlength="45" class="form-control input-mask text-left combined-right" data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" value="{{@$post->company_phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label for="company_status">Company Status<span class="text-danger">*</span></label>
                            @if(Auth::user()->user_type->user_type_group === 'administrator')
                                {!! Form::select('company_status', $company_status_sel, $post->company_status ?? 'active', ['class' => 'form-control select2', 'id' => 'company_status','required' => 'required' ]) !!}
                            @else
                                @if(@$post->company_status === "active")
                                <input type="text"  class="form-control" value="Active" disabled>
                                @else
                                <input type="text"  class="form-control" value="Pending" disabled>
                                @endif
                            @endif
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
                            <input name="company_website" type="url" maxlength="45" class="form-control" value="{{ @$post->company_website }}">
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
                            <input name="company_address" type="text" maxlength="150" class="form-control" value="{{ @$post->company_address }}" >
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
                            <input name="company_postcode" class="form-control input-mask text-left" data-inputmask="'mask': '99999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{ @$post->company_postcode }}" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_city_name">Company City</label>
                            <input id="company_city_name" name="company_city_name" type="text" class="form-control" value="{{ @$post->company_city_name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="company_state">Company State</label>
                            <input hidden name="company_state_name" id="company_state_name" type="text" class="form-control" value="">
                            {!! Form::select('company_state_id', $state_sel, @$post->company_state_id, ['class' => 'form-control state select2','id' => 'company_state_id']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
						<label for="company_country">Company Country</label>
                        <input hidden name="company_country_name" id="company_country_name" type="text" class="form-control" value="">
                        {!! Form::select('company_country_id', $country_dropdown, @$post->company_country_id, ['class' => 'form-control country select2','id' => 'company_country_id']) !!}
					</div>
                </div>
            </div>
        </div>
        <div class="card  d-xl-block d-lg-none d-md-none d-sm-none d-none">
            <div class="card-body">
                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                @if (Auth::user()->user_type->user_type_slug == 'admin')
                    <a href="{{ route('company_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                @else
                <a href="{{ route('company_profile') }}" class="btn btn-secondary" type="button">Cancel</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title mb-4">Upload Details</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        @php
                            $companyLogo = $company->getMedia('company_logo')->last();
                        @endphp
                        <label for="company_logo">Company Logo</label>
                        <div id="companyLogoContainer" style="margin-bottom: 5px; display: {{ $companyLogo ? 'flex' : 'none' }};align-items:center;">
                            <img id="companyLogoPreview" src="{{ $companyLogo ? $companyLogo->getUrl() : '' }}" style="height: 90px; max-width: 150px; margin-bottom: 5px; cursor: pointer; float: left;" class="company-logo-clickable">
                            <a class="closeButton" id="logoCloseButton" data-modal-message="Company Logo" data-company-id="{{ @$post->company_id }}" data-file-name="company_logo" style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom: 10px;" name="company_logo" id="company_logo" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'companyLogoPreview', 'companyLogoContainer','logoCloseButton', 'Company_Logo')" @error('company_logo') is-invalid @enderror>
                            <label class="custom-file-label" id="Company_Logo" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" for="exampleInputFile">Select Company Logo</label>
                        </div>
                        @error('company_logo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        @php
                            $companyBanner = $company->getMedia('company_banner')->last();
                        @endphp
                        <label for="company_banner">Company Banner</label>
                        <div id="companyBannerContainer" style="margin-bottom: 5px; display: {{ $companyBanner ? 'flex' : 'none' }};align-items:center;">
                            <img id="companyBannerPreview" src="{{ $companyBanner ? $companyBanner->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;" class="company-banner-clickable">
                            <a class="closeButton" id="bannerCloseButton" data-modal-message="Company Banner"  data-company-id="{{ @$post->company_id }}" data-file-name="company_banner"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="company_banner" id="company_banner" accept=".jpeg,.png,.jpg,.gif"  onchange="updateImagePreview(this, 'companyBannerPreview', 'companyBannerContainer','bannerCloseButton',  'Company_Banner')"  @error('company_banner') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="Company_Banner"
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
                        @php
                            $Pricelist = $company->getMedia('pricelist_media')->last();
                        @endphp
                        <label for="pricelist_media">Pricelist (Default)</label>
                        <div id="PricelistContainer" style="margin-bottom: 5px; display: {{ $Pricelist ? 'flex' : 'none' }};align-items:center">
                            <a href="{{$Pricelist?->getUrl()}}" target="_blank"><img id="PricelistPreview" src="{{ $Pricelist ? $Pricelist->getUrl('thumb') : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;"></a>
                            <a class="closeButton" data-modal-message="Pricelist" data-company-id="{{ @$post->company_id }}" data-file-name="pricelist_media"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;"  name="pricelist_media" id="pricelist_media" accept=".pdf" onchange="updateImagePreview2(this,'PricelistPreview','PricelistContainer'),updateLabelWithFileName(this, 'pricelist_media_label',)" multiple @error('pricelist_media') is-invalid @enderror>
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
                         @php
                            $Brochure = $company->getMedia('brochure_media')->last();
                        @endphp
                        <label for="brochure_media">Brochure (Default)</label>
                        <div id="BrochureContainer" style="margin-bottom: 5px; display: {{ $Brochure ? 'flex' : 'none' }};align-items:center">
                            <a href="{{  $Brochure?->getUrl() }}" target="_blank"><img id="BrochurePreview" src="{{ $Brochure ? $Brochure->getUrl('thumb') : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;"></a>
                            <a class="closeButton" data-modal-message="Brochure" data-company-id="{{ @$post->company_id }}" data-file-name="brochure_media"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;"  name="brochure_media" id="brochure_media" accept=".pdf" onchange="updateImagePreview2(this, 'BrochurePreview','BrochureContainer'),updateLabelWithFileName(this, 'brochure_media_label')" multiple @error('brochure_media') is-invalid @enderror>
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
                <h4 class="card-title mb-4">Upload Custom Thumbnails</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        @php
                            $companyThumbnail = $company->getMedia('company_thumbnail')->last();
                        @endphp
                        <label for="company_thumbnail">Company Thumbnail</label>
                        <div id="companyThumbnailContainer" style="margin-bottom: 5px; display: {{ $companyThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="companyThumbnailPreview" src="{{ $companyThumbnail ? $companyThumbnail->getUrl(): ''}}"  style="height:90px;max-width:150px;margin-bottom: 5px;cursor: pointer;float: left;" class="company-thumbnail-clickable">
                            <a class="closeButton" id="cThumbnailCloseButton" data-modal-message="Company Thumbnail"  data-company-id="{{ @$post->company_id }}" data-file-name="company_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;margin-top:-" name="company_thumbnail" id="company_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'companyThumbnailPreview', 'companyThumbnailContainer','cThumbnailCloseButton', 'Company_Thumbnail')" @error('company_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id = "Company_Thumbnail"
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
                        @php
                            $promotionThumbnail = $company->getMedia('promotion_thumbnail')->last();
                        @endphp
                        <label for="promotion_thumbnail">Promotion Thumbnail</label>
                        <div id="PromotionThumbnailContainer" style="margin-bottom: 5px; display: {{ $promotionThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="PromotionThumbnailPreview" src="{{ $promotionThumbnail ? $promotionThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left" class="promotion-thumbnail-clickable">
                            <a class="closeButton" id="pThumbnailCloseButton" data-modal-message="Promotion Thumbnail" data-company-id="{{ @$post->company_id }}" data-file-name="promotion_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="promotion_thumbnail" id="promotion_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'PromotionThumbnailPreview', 'PromotionThumbnailContainer','pThumbnailCloseButton', 'Promotion_Thumbnail')" @error('promotion_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="Promotion_Thumbnail"
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
                    <div class="col-lg-12 col-md-6 col-sm-12"  id="catalog_thumbnail">
                        @php
                            $catalogThumbnail = $company->getMedia('catalog_thumbnail')->last();
                        @endphp
                        <label for="catalog_thumbnail">Catalog Thumbnail</label>
                        <div id="CatalogThumbnailContainer" style="margin-bottom: 5px; display: {{ $catalogThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="CatalogThumbnailPreview" src="{{ $catalogThumbnail ? $catalogThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;" class="catalog-thumbnail-clickable">
                            <a class="closeButton" id="catalogTCloseButton" data-modal-message="Catalog Thumbnail" data-company-id="{{ @$post->company_id }}" data-file-name="catalog_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="catalog_thumbnail" id="catalog_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'CatalogThumbnailPreview', 'CatalogThumbnailContainer', 'catalogTCloseButton','Catalog_Thumbnail')"  @error('catalog_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="Catalog_Thumbnail"
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
                    <div class="col-lg-12 col-md-6 col-sm-12"  id="pricelist_thumbnail">
                        @php
                            $pricelistThumbnail = $company?->getMedia('pricelist_thumbnail')?->last();
                        @endphp
                        <label for="pricelist_thumbnail">Pricelist Thumbnail</label>
                        <div id="PricelistThumbnailContainer" style="margin-bottom: 5px; display: {{ $pricelistThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="PricelistThumbnailPreview" src="{{ $pricelistThumbnail ? $pricelistThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;" class="pricelist-thumbnail-clickable">
                            <a class="closeButton" id="pricelistTCloseButton" data-modal-message="Pricelist Thumbnail" data-company-id="{{ @$post->company_id }}" data-file-name="pricelist_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="pricelist_thumbnail" id="pricelist_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'PricelistThumbnailPreview', 'PricelistThumbnailContainer', 'pricelistTCloseButton','Pricelist_Thumbnail')"  @error('pricelist_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="Pricelist_Thumbnail"
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
                    <div class="col-lg-12 col-md-6 col-sm-12"  id="brochure_thumbnail">
                        @php
                            $brochureThumbnail = $company?->getMedia('brochure_thumbnail')?->last();
                        @endphp
                        <label for="brochure_thumbnail">Brochure Thumbnail</label>
                        <div id="BrochureThumbnailContainer" style="margin-bottom: 5px; display: {{ $brochureThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="BrochureThumbnailPreview" src="{{ $brochureThumbnail ? $brochureThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;" class="brochure-thumbnail-clickable">
                            <a class="closeButton" id="brochureTCloseButton" data-modal-message="Brochure Thumbnail" data-company-id="{{ @$post->company_id }}" data-file-name="brochure_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="brochure_thumbnail" id="brochure_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'BrochureThumbnailPreview', 'BrochureThumbnailContainer', 'brochureTCloseButton','Brochure_Thumbnail')"  @error('brochure_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="Brochure_Thumbnail"
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
                    <div class="col-lg-12 col-md-6 col-sm-12" id="general_thumbnail">
                        @php
                            $generalThumbnail = $company->getMedia('general_thumbnail')->last();
                        @endphp
                        <label for="general_thumbnail">General Thumbnail</label>
                        <div id="GeneralThumbnailContainer" style="margin-bottom: 5px; display: {{ $generalThumbnail ? 'flex' : 'none' }};align-items:center;">
                            <img id="GeneralThumbnailPreview" src="{{ $generalThumbnail ? $generalThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;" class="general-thumbnail-clickable">
                            <a class="closeButton" id="GeneralTCloseButton" data-modal-message="General Thumbnail" data-company-id="{{ @$post->company_id }}" data-file-name="general_thumbnail"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                        </div>
                        <div class="input-group">
                            <input type="file"class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="general_thumbnail" id="general_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this, 'GeneralThumbnailPreview', 'GeneralThumbnailContainer', 'GeneralTCloseButton', 'General_Thumbnail')" @error('general_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="General_Thumbnail"
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-12 col-md-12 d-xl-none">
        <div class="card">
            <div class="card-body">
                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                @if (Auth::user()->user_type->user_type_slug == 'admin')
                    <a href="{{ route('company_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                @else
                <a href="{{ route('company_profile') }}" class="btn btn-secondary" type="button">Cancel</a>
                @endif
            </div>
        </div>
    </div>
</div>
</form>
{{-- Modal --}}
<div id="logoModal" class="modal">
    <span class="closebtn" id="closeModal" style="color: white">&times;</span>
    <img src="" alt="" id="img">
</div>
<div id="bannerModal" class="modal">
    <span class="closebtn" id="closeModal1"  style="color: white">&times;</span>
    <img src="" alt="" id="img1">
</div>
<div id="comThumbnailModal" class="modal">
    <span class="closebtn" id="closeModal2"  style="color: white">&times;</span>
    <img src="" alt="" id="img2">
</div>
<div id="catThumbnailModal" class="modal">
    <span class="closebtn" id="closeModal3"  style="color: white">&times;</span>
    <img src="" alt="" id="img3">
</div>
<div id="generalThumbnailModal" class="modal">
    <span class="closebtn" id="closeModal4"  style="color: white">&times;</span>
    <img src="" alt="" id="img4">
</div>
<div id="promotionThumbnailModal" class="modal">
    <span class="closebtn" id="closeModal7"  style="color: white">&times;</span>
    <img src="" alt="" id="img7">
</div>
<div id="pricelistModal" class="modal">
    <span class="closebtn" id="closeModal8"  style="color: white">&times;</span>
    <img src="" alt="" id="img8">
</div>
<div id="brochureModal" class="modal">
    <span class="closebtn" id="closeModal9"  style="color: white">&times;</span>
    <img src="" alt="" id="img9">
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('company_remove_upload')}}">
                @csrf
                <div class="modal-body">
                    <h4 style="margin-bottom: 10px">Remove This ?</h4>
                    <input type="hidden" name="company_id" id="company_id_modal">
                    <input type="hidden" name="file_name" id="file_name_modal">
                    <input type="hidden" name="action" value="delete">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Remove</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
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
    $(document).ready(function () {
        $('#company_country_dialcode').select2({
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
</script>
<script>
    function updateImagePreview(input, previewId, containerId, buttonId, labelId) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(containerId);
        const button = document.getElementById(buttonId);
        const modal = document.getElementById("upload_error");
        const maxSize = 10 * 1024 * 1024;
        var messageContainer = $("#fileSizeExceedMessage");

        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                input.value = '';
                messageContainer.text("File size exceeds the 10 MB limit.");
                $(modal).modal('show');
            } else {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                container.style.display = 'flex';
                button.style.display = 'none';

                reader.readAsDataURL(input.files[0]);
            }
        } else {
            preview.src = '';
            container.style.display = 'none';
        }

        const label = document.querySelector('label[id="' + labelId + '"]');
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = "Select " + labelId.replace("_", " ");
        }
    }
    function updateLabelWithFileName(input, labelId) {
        const label = document.getElementById(labelId);
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = `Select ${labelId === 'pricelist_media_label' ? 'Company Pricelist' : 'Company Brochure'}`;
        }
    }
    function updateImagePreview2(input, previewId, containerId,) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(containerId);
        const modal = document.getElementById("upload_error");
        const maxSize = 50 * 1024 * 1024;
        var messageContainer = $("#fileSizeExceedMessage");

        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                input.value = ''; // Clear the input field
                messageContainer.text("File size exceeds the 50 MB limit.");
                $(modal).modal('show');

            } else {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                preview.src = '';
                container.style.display = 'none';

                reader.readAsDataURL(input.files[0]);
            }
        } else {
            preview.src = '';
            container.style.display = 'none';
        }
    }
</script>
<script>
    var logoModal = document.getElementById("logoModal");
    var logoModalImg = document.getElementById("img");

    var logoImages = document.querySelectorAll(".company-logo-clickable");

    logoImages.forEach(function(img) {
        img.onclick = function(){
            logoModal.style.display = "flex";
            logoModalImg.src = this.src;
        }
    });

    var logoCloseButton = document.getElementById("closeModal");
    logoCloseButton.onclick = function() {
        logoModal.style.display = "none";
    }
</script>
<script>
    var bannerModal = document.getElementById("bannerModal");
    var bannerModalImg = document.getElementById("img1");

    var bannerImages = document.querySelectorAll(".company-banner-clickable");

    bannerImages.forEach(function(img) {
        img.onclick = function(){
            bannerModal.style.display = "flex";
            bannerModalImg.src = this.src;
        }
    });

    var bannerCloseButton = document.getElementById("closeModal1");
    bannerCloseButton.onclick = function() {
        bannerModal.style.display = "none";
    }
</script>
<script>
    var comThumbnailModal = document.getElementById("comThumbnailModal");
    var comThumbnailModalImg = document.getElementById("img2");

    var comThumbnailImages = document.querySelectorAll(".company-thumbnail-clickable");

    comThumbnailImages.forEach(function(img) {
        img.onclick = function(){
            comThumbnailModal.style.display = "flex";
            comThumbnailModalImg.src = this.src;
        }
    });

    var comThumbnailCloseButton = document.getElementById("closeModal2");
    comThumbnailCloseButton.onclick = function() {
        comThumbnailModal.style.display = "none";
    }
</script>
<script>
    var catThumbnailModal = document.getElementById("catThumbnailModal");
    var catThumbnailModalImg = document.getElementById("img3");

    var catThumbnailImages = document.querySelectorAll(".catalog-thumbnail-clickable");

    catThumbnailImages.forEach(function(img) {
        img.onclick = function(){
            catThumbnailModal.style.display = "flex";
            catThumbnailModalImg.src = this.src;
        }
    });

    var catThumbnailCloseButton = document.getElementById("closeModal3");
    catThumbnailCloseButton.onclick = function() {
        catThumbnailModal.style.display = "none";
    }
</script>
<script>
    var generalThumbnailModal = document.getElementById("generalThumbnailModal");
    var generalThumbnailModalImg = document.getElementById("img4");

    var generalThumbnailImages = document.querySelectorAll(".general-thumbnail-clickable");

    generalThumbnailImages.forEach(function(img) {
        img.onclick = function(){
            generalThumbnailModal.style.display = "flex";
            generalThumbnailModalImg.src = this.src;
        }
    });

    var generalThumbnailCloseButton = document.getElementById("closeModal4");
    generalThumbnailCloseButton.onclick = function() {
        generalThumbnailModal.style.display = "none";
    }
</script>
<script>
    var promotionThumbnailModal = document.getElementById("promotionThumbnailModal");
    var promotionThumbnailModalImg = document.getElementById("img7");

    var promotionThumbnailImages = document.querySelectorAll(".promotion-thumbnail-clickable");

    promotionThumbnailImages.forEach(function(img) {
        img.onclick = function(){
            promotionThumbnailModal.style.display = "flex";
            promotionThumbnailModalImg.src = this.src;
        }
    });

    var promotionThumbnailCloseButton = document.getElementById("closeModal7");
    promotionThumbnailCloseButton.onclick = function() {
        promotionThumbnailModal.style.display = "none";
    }
</script>
<script>
    var pricelistModal = document.getElementById("pricelistModal");
    var pricelistModalImg = document.getElementById("img8");

    var pricelistImages = document.querySelectorAll(".pricelist-thumbnail-clickable");

    pricelistImages.forEach(function(img) {
        img.onclick = function(){
            pricelistModal.style.display = "flex";
            pricelistModalImg.src = this.src;
        }
    });

    var pricelistCloseButton = document.getElementById("closeModal8");
    pricelistCloseButton.onclick = function() {
        pricelistModal.style.display = "none";
    }
</script>
<script>
    var brochureModal = document.getElementById("brochureModal");
    var brochureModalImg = document.getElementById("img9");

    var brochureImages = document.querySelectorAll(".brochure-thumbnail-clickable");

    brochureImages.forEach(function(img) {
        img.onclick = function(){
            brochureModal.style.display = "flex";
            brochureModalImg.src = this.src;
        }
    });

    var brochureCloseButton = document.getElementById("closeModal9");
    brochureCloseButton.onclick = function() {
        brochureModal.style.display = "none";
    }
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
    });
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select all elements with the class "closeButton"
        const closeButtons = document.querySelectorAll(".closeButton");

        // Add click event listener to each closeButton
        closeButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                // Get the modal element
                const modal = document.getElementById("delete");
                // Get the modal message from the data attribute
                const modalMessage = this.getAttribute("data-modal-message");

                // Update the modal content with the dynamic message
                modal.querySelector(".modal-body h4").textContent = `Remove this ${modalMessage}?`;

                // Get the company_id from your data source (e.g., data attribute)
                const companyId = this.getAttribute("data-company-id");

                // Update the value of the hidden input field in the modal
                modal.querySelector("#company_id_modal").value = companyId;

                const fileName = this.getAttribute("data-file-name");
                modal.querySelector("#file_name_modal").value = fileName;

                // Display the modal
                $(modal).modal("show");
            });
        });
    });
</script>
{{-- Google API --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initAutocomplete" async defer></script>
@endsection
