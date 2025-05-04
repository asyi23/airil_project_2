@extends('layouts.master')

@section('title')
    {{ $title }} Product
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-image-edit.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/filepond-plugin-file-poster.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/doka.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.min.css') }}">
    <style>
        .custom-dropdown-container .select2-container {
            width: 100% !important;
        }
        .note-editor.note-frame .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-codable {
            color: #000000 !important;
        }
        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #img, #img1{
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
        #img,#img1{
            width: 100%;
        }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }} Product</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Product</a>
                        </li>
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
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
                                @if (!empty($user_company))
                                    <div class="form-group">
                                        <label for="company_id">Company <span class="text-danger">*</span></label>
                                            @foreach ($company as $key => $val)
                                                @if ($key == $user_company_id)
                                                    @php
                                                        $desired_company = $val;
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                            <input name="company_id" class="form-control " id="company_id" value="{{ $desired_company }}" {{ @$action === 'edit' }}readonly>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="company_id">Company <span class="text-danger">*</span></label>
                                        <select name="company_id" class="form-control select2" id="company_id"
                                            {{ @$action === 'edit' }}>
                                            @foreach ($company as $key => $val)
                                                <option value="{{ $key }}"
                                                {{ $key == @$post->company_id ? 'selected' : ($key == (@$product->company->company_id ?? null) ? 'selected' : '') }}>
                                                    {{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                            @if (Auth::user()->roles->value('id') == 4)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company_branch_id">Company Branch <span
                                                class="text-danger">*</span></label>
                                        <input name="company_branch_id" id="company_branch_id" type="text"
                                            class="form-control select2" value="{{ @$company_branch->company_branch_name }}" readonly>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="branch_selection">Branch Selection<span class="text-danger">*</span></label>
                                        {!! Form::select('branch_selection', $branch_selections, @$post->branch_selection ?? 'all', ['class' => 'form-control select2', 'id' => 'branch_selection' ]) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Product Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product_name">Product Name <span class="text-danger">*</span></label>
                                    <input id="product_name" type="text" name="product_name" class="form-control"
                                        value="{{@$post->product_name}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="product_category_id">Product Category <span class="text-danger">*</span></label>
                                    <select name="product_category_id" class="form-control select2"
                                        id="product_category_id" {{ @$action === 'edit' }}>
                                        @foreach (@$product_category as $key => $val)
                                            <option value="{{ $key }}"
                                            {{ $key == @$post->product_category_id ? 'selected' :  '' }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product_short_description">Product Short Description</label>
                                    <input name="product_short_description" type="text" class="form-control"
                                        maxlength="100" value="{{@$post->product_short_description}}"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product_price">Product Price </label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text">RM</span>
                                        </div>
                                        <input id="product_price" name="product_price" class="form-control text-left"
                                            type="text" value="{{@$post->product_price}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product_priority">Product Priority</label>
                                    <input id="product_priority" type="number" name="product_priority"
                                        class="form-control" value="{{@$post->product_priority}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="product_status">Publish</label>
                                    {!! Form::select('is_published', $status, @$post->is_published ?? '0', ['class' => 'form-control select2', 'id' => 'product_status' ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="product_description">Product Description</label>
                                    <textarea id="summernote" name="product_description" type="text" class="form-control"
                                        rows="10">{{ @$post->product_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- testing --}}
                <div class="card">
                    <div id="cardBody" class="card-body">
                        <h4 class="card-title mb-4">Product Highlights<a href="#" onclick="addNewRow(event);" class="btn btn-outline-primary waves-effect waves-light btn-sm" style="margin-left: 15px"><i class="mdi mdi-plus "></i> Add</a></h4>
                        @if ($action == 'edit')
                            @if ($highlights == null)
                                <div class="row" id="originalRow">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="highlight_name">Title</label>
                                            <input name="highlight_name[]" type="text" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="highlight_descr">Value</label>
                                            <input name="highlight_descr[]" type="text" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                            @elseif ($highlights_data != null)
                            @php
                                $highlightsData = json_decode($highlights_data, true);
                                @endphp
                                @foreach (@$highlightsData as $index => $highlight)
                                    <div class="row" id="originalRow">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_name">Title</label>
                                                <input name="highlight_name[]" type="text" class="form-control" value="{{$highlight['highlight_name']}}">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_descr">Value</label>
                                                <input name="highlight_descr[]" type="text" class="form-control" value="{{$highlight['highlight_descr']}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <a type="button"
                                                    class="form-control remove-button" style="border: none"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($highlights as $index => $highlight)
                                    <div class="row" id="originalRow">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_name">Title</label>
                                                <input name="highlight_name[]" type="text" class="form-control"
                                                    value="{{ $highlight->highlight_name }}">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_descr">Value</label>
                                                <input name="highlight_descr[]" type="text" class="form-control"
                                                    value="{{ $highlight->highlight_descr }}">
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <a type="button"
                                                    class="form-control remove-button" style="border: none"><i style="color: red;font-size:22px" class='bx bx-trash'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            @if(empty($highlights))
                                <div class="row" id="originalRow">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="highlight_name">Title</label>
                                            <input name="highlight_name[]" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label for="highlight_descr">Value</label>
                                            <input name="highlight_descr[]" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            @else
                                @php
                                $highlightsData = json_decode($highlights, true);
                                @endphp
                                @foreach (@$highlightsData as $index => $highlight)
                                    <div class="row" id="originalRow">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_name">Title</label>
                                                <input name="highlight_name[]" type="text" class="form-control" value="{{$highlight['highlight_name']}}">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="highlight_descr">Value</label>
                                                <input name="highlight_descr[]" type="text" class="form-control" value="{{$highlight['highlight_descr']}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <a type="button"
                                                    class="form-control remove-button" style="border: none"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
                {{-- testing --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Product Image</h4>
                        <div class="row">
                            <div class="col-sm-12 post-images-filepond">
                                <input id="upload-post-images" class="car-images filepond"
                                    name="post_gallery_images[]" data-allow-reorder="true" type="file" multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($action == 'add')
            <div class="col-xl-3 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Upload Product Files</h4>
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <label for="product_brochure">Product Brochure</label>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input" style="width: 100%;" name="product_brochure" id="product_brochure" accept=".pdf" onchange="updateImageCountAndPreviews(this)" multiple @error('product_brochure') is-invalid @enderror>
                                    <label class="custom-file-label" id = "product_brochure" style=" overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" for="exampleInputFile">Select Product Brochure</label>
                                </div>
                                <small class="text-secondary">&nbsp;&nbsp;*Accept PDF only</small>
                                <ul style="padding: 0;display: none;" id="brochure_checkbox" >
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" id="customNameCheckbox" class="custom-control-input check-all" @if(@$post->spec_sheet_overwrite_name) checked @endif>
                                        <label class="custom-control-label" for="customNameCheckbox">Customize name</label>
                                    </li>
                                </ul>
                                <input type="text" id="customNameInput" name="brochure_overwrite_name" style="display: none;" class="form-control" placeholder="Enter Customized Name" value="{{ @$post->brochure_overwrite_name }}">
                                @error('product_brochure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-12" style="margin-top: 15px">
                                <label for="product_spec_sheet">Product Spec Sheet</label>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input" style="width: 100%;" name="product_spec_sheet" id="product_spec_sheet" accept=".pdf" onchange="updateImageCountAndPreviews2(this)" multiple @error('product_spec_sheet') is-invalid @enderror>
                                    <label class="custom-file-label" id = "product_spec_sheet" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" for="exampleInputFile">Select Product Spec Sheet</label>
                                </div>
                                <small class="text-secondary">&nbsp;&nbsp;*Accept PDF only</small>
                                <ul style="padding: 0;display: none" id="specsheet_checkbox" >
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" id="customNameCheckbox1" class="custom-control-input check-all" @if(@$post->spec_sheet_overwrite_name) checked @endif>
                                        <label class="custom-control-label" for="customNameCheckbox1">Customize name</label>
                                    </li>
                                </ul>
                                <input type="text" id="customNameInput1" name="spec_sheet_overwrite_name" style="display: none;" class="form-control" placeholder="Enter Customized Name" value="{{ @$post->spec_sheet_overwrite_name }}">
                                @error('product_spec_sheet')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if ($action ==='edit')
            <div class="col-xl-3 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Upload Product Files</h4>
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                @php
                                    $productBrochure = $product->getMedia('product_brochure')->last();
                                @endphp
                                <label for="product_brochure">Product Brochure</label>
                                <div id="productBrochureContainer" style="margin-bottom: 10px; display: {{ $productBrochure ? 'flex' : 'none' }};align-items:center;">
                                    <a href="{{$productBrochure?->getUrl()}}" target="_blank"><img id="productBrochurePreview" src="{{ $productBrochure ? $productBrochure->getUrl('thumb'): ''}}" style="max-height:100px;max-width:100px;cursor: pointer;"></a>
                                    <a class="closeButton" id="brochureCloseButton" data-modal-message="Product Brochure"  data-product-id="{{ @$post->product_id }}" data-file-name="product_brochure"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                                </div>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input" style="width: 100%; " name="product_brochure" id="product_brochure" accept=".pdf" onchange="updateImagePreview(this);updateLabelWithFileName(this)" multiple @error('promotion_thumbnail') is-invalid @enderror>
                                    <label class="custom-file-label" id = "product_brochure" style=" overflow: hidden; text-overflow: ellipsis;white-space: nowrap;"for="exampleInputFile">Select Product Brochure</label>
                                </div>
                                <small class="text-secondary">&nbsp;&nbsp;*Accept PDF only</small>
                                <ul style="padding: 0">
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" id="customNameCheckbox" class="custom-control-input check-all" @if(@$post->spec_sheet_overwrite_name) checked @endif>
                                        <label class="custom-control-label" for="customNameCheckbox">Customize name</label>
                                    </li>
                                </ul>
                                <input type="text" id="customNameInput" name="brochure_overwrite_name" style="display: none;" class="form-control" placeholder="Enter Customized Name" value="{{ @$post->brochure_overwrite_name}}">
                                @error('product_brochure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-12" style="margin-top: 15px">
                                @php
                                    $productSpecSheet =$product->getMedia('product_spec_sheet')->last();
                                @endphp
                                <label for="product_spec_sheet">Product Spec Sheet</label>
                                <div id="productSpecSheetContainer" style="margin-bottom: 5px; display: {{ $productSpecSheet ? 'flex' : 'none' }};align-items:center;">
                                    <a href="{{$productBrochure?->getUrl()}}" target="_blank"><img id="productSpecSheetPreview" src="{{ $productSpecSheet ? $productSpecSheet->getUrl('thumb') : '' }}"style="max-height:100px;max-width:100px;cursor: pointer;"></a>
                                    <a class="closeButton" id="specsheetCloseButton" data-modal-message="Product Spec Sheet"  data-product-id="{{ @$post->product_id }}" data-file-name="product_spec_sheet"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                                </div>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input" style="width: 100%;" name="product_spec_sheet" id="product_spec_sheet"  accept=".pdf" onchange="updateImagePreview1(this);updateLabelWithFileName1(this)" multiple @error('product_spec_sheet') is-invalid @enderror>
                                        <label class="custom-file-label"
                                            id = "product_spec_sheet"
                                            style=" overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;"
                                            for="exampleInputFile">Select Product Spec Sheet
                                        </label>
                                </div>
                                <small class="text-secondary">&nbsp;&nbsp;*Accept PDF only</small>
                                <ul style="padding: 0">
                                    <li class="custom-control custom-checkbox">
                                        <input type="checkbox" id="customNameCheckbox1" class="custom-control-input check-all" @if(@$post->spec_sheet_overwrite_name) checked @endif>
                                        <label class="custom-control-label" for="customNameCheckbox1">Customize name</label>
                                    </li>
                                </ul>
                                <input type="text" id="customNameInput1" name="spec_sheet_overwrite_name" style="display: none;" class="form-control" placeholder="Enter Customized Name" value="{{ @$post->spec_sheet_overwrite_name}}">
                                @error('product_spec_sheet')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- branch card --}}
            @if (Auth::user()->user_type->user_type_slug == 'admin' || Auth::user()->roles->value('id') == 3)
                @if (!empty($branch))
                <div class="col-xl-9 col-lg-12 col-md-12" id="company_branch">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Branch <span class="text-danger">*</span></h4>
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <div class="col-md-12">
                                        <ul style="padding: 0">
                                            <li class="custom-control custom-checkbox">
                                                <input type="checkbox" id="check_all" class="custom-control-input check-all">
                                                <label class="custom-control-label" for="check_all">Check All</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul>
                                            @foreach ($branch as $branchId => $branchName)
                                                <li class="custom-control custom-checkbox" style="list-style:none;display:inline-block;width:200px;margin-bottom:10px">
                                                    <input class="custom-control-input check" type="checkbox" name="branch[]" value="{{ $branchId }}" id="{{ $branchId }}"
                                                    @if(@$post->branch && in_array($branchId, $post->branch) || (is_array(@$post->company_branch_id) && in_array($branchId, @$post->company_branch_id)))
                                                    checked
                                                    @endif
                                                    >
                                                    <label class="custom-control-label" for="{{ $branchId }}">{{ $branchName }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit"
                                    class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a href="{{ route('product_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
        </div>
    </form>
{{-- Modal --}}
<div id="brochureModal" class="modal">
    <span class="closebtn" id="closeModal"  style="color: white">&times;</span>
    <img src="" alt="" id="img">
</div>
<div id="specsheetModal" class="modal">
    <span class="closebtn" id="closeModal1"  style="color: white">&times;</span>
    <img src="" alt="" id="img1">
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('product_remove_upload')}}">
                @csrf
                <div class="modal-body">
                    <h4 style="margin-bottom: 10px">Remove This ?</h4>
                    <input type="hidden" name="product_id" id="product_id_modal">
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
            <div style="text-align: center;font-size:20px;margin-top:30px">
                File size exceeds the 50 MB limit.
            </div>
            <div style="text-align: center;margin-bottom:20px;margin-top:20px;">
                <button type="button" style="width:60px" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery-ui.js') }}"></script>

    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-resize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-transform.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-crop.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-edit.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-poster.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-image-exif-orientation.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filepond/filepond.js') }}"></script>
    <script src="{{ URL::asset('assets/js/doka.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/autosize.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/summernote-image-attributes.js') }}"></script>
    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>

    <script src="{{ URL::asset('assets/js/jquery.fancybox.min.js') }}"></script>
    <script>
        var action = "{{ @$action }}";
        $(document).ready(function() {
            $('#product_category_id').select2();
            $('#product_status').select2({
                minimumResultsForSearch: Infinity
            });
            $('#branch_selection').select2({
                minimumResultsForSearch: Infinity
            });

        });

    </script>
    <script>
        $(document).ready(function() {
            var companySelect = $("#company_id");
            var productCategorySelect = $("#product_category_id");
            var branchSelect = $("#company_branch");
            var selection = $("#branch_selection");

            function updateProductCategoryDropdown() {
                if (companySelect.val() === "") {
                    productCategorySelect.prop("disabled", true);
                    productCategorySelect.val("");
                    selection.prop("disabled", true);
                    selection.val('all').trigger('change');
                    branchSelect.hide();
                } else {
                    productCategorySelect.prop("disabled", false);
                    selection.prop("disabled", false);
                    if(action == 'add' &&"{{ Auth::user()->user_type->user_type_slug == 'admin'}}") {
                        selection.val('all').trigger('change');
                    }
                    branchSelect.hide();
                }
            }
            function showBranch(){
                if(selection.val() === "custom") {
                    @if (Auth::user()->user_type->user_type_slug == 'admin') {
                        var companyId = companySelect.val();
                        // Send an Ajax request to get the branches based on the selected company
                        $.ajax({
                            url: "{{ route('get.branches', '') }}/" + companyId,
                            method: 'GET',
                            success: function(data) {
                                var newHtmlContent = `
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Branch <span class="text-danger">*</span></h4>
                                            <div data-repeater-item class="outer">
                                                <div class="form-group row mb-4">
                                                    <div class="col-md-12">
                                                        <ul style="padding: 0">
                                                            <li class="custom-control custom-checkbox">
                                                                <input type="checkbox" id="check_all" class="custom-control-input check-all">
                                                                <label class="custom-control-label" for="check_all">Check All</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <ul>
                                                            ${Object.entries(data).map(([branchId, branchName]) => `
                                                                <li class="custom-control custom-checkbox" style="list-style:none;display:inline-block;width:200px;margin-bottom:10px">
                                                                    <input class="custom-control-input check" type="checkbox" name="branch[]" value="${branchId}" id="${branchId}" ${($('#' + branchId).prop('checked')) ? 'checked' : ''}>
                                                                    <label class="custom-control-label" for="${branchId}">${branchName}</label>
                                                                </li>
                                                            `).join('')}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#company_branch').html(newHtmlContent);
                                branchSelect.show();
                                if ($(".check:not(#check_all)").length === $(".check:checked:not(#check_all)").length) {
                                    $("#check_all").prop("checked", true);
                                }
                            }
                        });
                    }
                    @else
                        branchSelect.show();
                    @endif
                }else{
                    branchSelect.hide();
                }
            }
            companySelect.on("change", updateProductCategoryDropdown);
            selection.on("change",showBranch);
            updateProductCategoryDropdown();
            showBranch();
        });
    </script>
    <script>
        $(document).ready(function() {
            function areAllOthersChecked() {
                return $(".check:not(#check_all)").length === $(".check:checked:not(#check_all)").length;
            }

            $("#check_all").prop("checked", areAllOthersChecked());

            $("body").on("change", ".check", function() {
                $("#check_all").prop("checked", areAllOthersChecked());
            });

            $("body").on("change", "#check_all", function() {
                $(".check").prop("checked", $(this).prop("checked"));
            });
        });
    </script>
    <script type="text/javascript">

        function updateLabelWithFileName(input) {
            const label = document.querySelector('label[id = "product_brochure"]');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = "Select Product Brochure";
            }
        }

        function updateLabelWithFileName1(input) {
            const label = document.querySelector('label[id = "product_spec_sheet"]');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = "Select Product Spec Sheet";
            }
        }

        function updateImagePreview(input) {
            const preview = document.getElementById('productBrochurePreview');
            const container = document.getElementById('productBrochureContainer');
            const modal = document.getElementById("upload_error");
            const button = document.getElementById("brochureCloseButton");
            const maxSize = 50 * 1024 * 1024;
            if (input.files && input.files[0]) {
                if (input.files[0].size > maxSize) {
                    input.value = ''; // Clear the input field
                    $(modal).modal('show');

                } else {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    preview.src = '';
                    container.style.display = 'none';
                    button.style.display = 'none';

                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                preview.src = '';
                container.style.display = 'none';
            }
        }

        function updateImagePreview1(input) {
            const preview = document.getElementById('productSpecSheetPreview');
            const container = document.getElementById('productSpecSheetContainer');
            const modal = document.getElementById("upload_error");
            const button = document.getElementById("specsheetCloseButton");
            const maxSize = 50 * 1024 * 1024;
            if (input.files && input.files[0]) {
                if (input.files[0].size > maxSize) {
                    input.value = ''; // Clear the input field
                    $(modal).modal('show');

                } else {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    preview.src = '';
                    container.style.display = 'none';
                    button.style.display = 'none';

                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                preview.src = '';
                container.style.display = 'none';
            }
        }

        function updateImageCountAndPreviews(input) {
            var checkbox = document.getElementById('brochure_checkbox')
            const modal = document.getElementById("upload_error");
            const maxSize = 50 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                input.value = '';
                $(modal).modal('show');
            }else{
                checkbox.style.display = 'block';
                updateLabelWithFileName(input);
                for (let i = 0; i < input.files.length; i++) {
                    const imageUrl = URL.createObjectURL(input.files[i]);
                    const image = document.createElement("img");
                    image.src = URL.createObjectURL(input.files[i]);
                    image.style.maxWidth = "100px";
                    image.style.maxHeight = "100px";
                    image.style.marginBottom = '10px';
                    image.style.cursor = 'pointer';

                    image.addEventListener('click', function () {
                        showImagePreview(imageUrl);
                    });
                }

            }
        }

        function updateImageCountAndPreviews2(input) {
            var checkbox = document.getElementById('specsheet_checkbox')
            const modal = document.getElementById("upload_error");
            const maxSize = 50 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                input.value = '';
                $(modal).modal('show');
            }else{
                checkbox.style.display = 'block';
                updateLabelWithFileName1(input);
                for (let i = 0; i < input.files.length; i++) {
                    const imageUrl = URL.createObjectURL(input.files[i]);
                    const image = document.createElement("img");
                    image.src = URL.createObjectURL(input.files[i]);
                    image.style.maxWidth = "100px";
                    image.style.maxHeight = "100px";
                    image.style.cursor = 'pointer';

                    image.addEventListener('click', function () {
                        showImagePreview(imageUrl);
                    });
                    // imagePreviews.appendChild(image);
                }
            }
        }

        function addNewRow() {
            event.preventDefault();
            var newRow = document.createElement("div");
            newRow.setAttribute("class", "row");

            var col1 = document.createElement("div");
            col1.setAttribute("class", "col-5");

            var formGroup1 = document.createElement("div");
            formGroup1.setAttribute("class", "form-group");

            var label1 = document.createElement("label");
            label1.setAttribute("for", "highlight_name");
            label1.textContent = "Title";

            var input1 = document.createElement("input");
            input1.setAttribute("name", "highlight_name[]");
            input1.setAttribute("type", "text");
            input1.setAttribute("class", "form-control");

            formGroup1.appendChild(label1);
            formGroup1.appendChild(input1);
            col1.appendChild(formGroup1);

            var col2 = document.createElement("div");
            col2.setAttribute("class", "col-5");

            var formGroup2 = document.createElement("div");
            formGroup2.setAttribute("class", "form-group");

            var label2 = document.createElement("label");
            label2.setAttribute("for", "highlight_descr");
            label2.textContent = "Value";

            var input2 = document.createElement("input");
            input2.setAttribute("name", "highlight_descr[]");
            input2.setAttribute("type", "text");
            input2.setAttribute("class", "form-control");

            formGroup2.appendChild(label2);
            formGroup2.appendChild(input2);
            col2.appendChild(formGroup2);

            var col3 = document.createElement("div");
            col3.setAttribute("class", "col-2");

            var formGroup3 = document.createElement("div");
            formGroup3.setAttribute("class", "form-group");

            var label3 = document.createElement("label");
            label3.innerHTML = "&nbsp;";

            var removeButton = document.createElement("a");
            removeButton.setAttribute("href", "#");
            removeButton.setAttribute("class", "form-control");
            removeButton.style.border = "none";
            var icon = document.createElement("i");
            icon.style.color = "red";
            icon.style.fontSize = "22px";
            icon.className = "bx bx-trash";

            // Append the icon element to the removeButton
            removeButton.appendChild(icon);
            removeButton.addEventListener("click", function(event) {
                event.preventDefault();
                removeRow(this);
            });

            formGroup3.appendChild(label3);
            formGroup3.appendChild(removeButton);
            col3.appendChild(formGroup3);

            newRow.appendChild(col1);
            newRow.appendChild(col2);
            newRow.appendChild(col3);

            document.getElementById("cardBody").appendChild(newRow);
        }


        function removeRow(button) {
            var row = button.closest(".row");
            row.parentNode.removeChild(row);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const removeButtons = document.querySelectorAll(".remove-button");

            removeButtons.forEach(removeButton => {
                removeButton.addEventListener("click", function(event) {
                    event.preventDefault();
                    removeRow(this);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to update the checkbox and input visibility
            function updateCheckboxAndInput() {
                if ($('#customNameInput').val().trim() !== '') {
                    $('#customNameCheckbox').prop('checked', true);
                    $('#customNameInput').show();
                } else {
                    $('#customNameCheckbox').prop('checked', false);
                    $('#customNameInput').hide();
                }
            }

            // Add an event listener to the input field to update the checkbox and input visibility
            $('#customNameInput').on('input', function() {
                updateCheckboxAndInput();
            });

            // Initialize checkbox and input visibility on page load
            updateCheckboxAndInput();

            // Add an event listener to the checkbox
            $('#customNameCheckbox').change(function() {
                // Check if the checkbox is checked
                if ($(this).is(':checked')) {
                    // If checked, show the input field
                    $('#customNameInput').show().focus();
                } else {
                    // If unchecked, hide the input field and clear its value
                    $('#customNameInput').hide().val('');
                }
            });
        });
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
                    const productId = this.getAttribute("data-product-id");

                    // Update the value of the hidden input field in the modal
                    modal.querySelector("#product_id_modal").value = productId;

                    const fileName = this.getAttribute("data-file-name");
                    modal.querySelector("#file_name_modal").value = fileName;

                    // Display the modal
                    $(modal).modal("show");
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to update the checkbox and input visibility
            function updateCheckboxAndInput() {
                if ($('#customNameInput1').val().trim() !== '') {
                    $('#customNameCheckbox1').prop('checked', true);
                    $('#customNameInput1').show();
                } else {
                    $('#customNameCheckbox1').prop('checked', false);
                    $('#customNameInput1').hide();
                }
            }

            // Add an event listener to the input field to update the checkbox and input visibility
            $('#customNameInput1').on('input', function() {
                updateCheckboxAndInput();
            });

            // Initialize checkbox and input visibility on page load
            updateCheckboxAndInput();

            // Add an event listener to the checkbox
            $('#customNameCheckbox1').change(function() {
                // Check if the checkbox is checked
                if ($(this).is(':checked')) {
                    // If checked, show the input field
                    $('#customNameInput1').show().focus();
                } else {
                    // If unchecked, hide the input field and clear its value
                    $('#customNameInput1').hide().val('');
                }
            });
        });
    </script>
    <script>
        var specsheetModal = document.getElementById("specsheetModal");
        var specsheetModalImg = document.getElementById("img1");

        var specsheetImages = document.querySelectorAll(".product-spec-sheet-clickable");

        specsheetImages.forEach(function(img) {
            img.onclick = function(){
                specsheetModal.style.display = "block";
                specsheetModalImg.src = this.src;
            }
        });

        var specsheetCloseButton = document.getElementById("closeModal1");
        specsheetCloseButton.onclick = function() {
            specsheetModal.style.display = "none";
        }
    </script>
    <script>
        var brochureModal = document.getElementById("brochureModal");
        var brochureModalImg = document.getElementById("img");

        var brochureImages = document.querySelectorAll(".product-brochure-clickable");

        brochureImages.forEach(function(img) {
            img.onclick = function(){
                brochureModal.style.display = "block";
                brochureModalImg.src = this.src;
            }
        });

        var brochureCloseButton = document.getElementById("closeModal");
        brochureCloseButton.onclick = function() {
            brochureModal.style.display = "none";
        }
    </script>
    <script type="text/javascript">
        function addField(argument) {
            var myTable = document.getElementById("myTable");
            var currentIndex = myTable.rows.length;
            var currentRow = myTable.insertRow(-1);

            var linksBox = document.createElement("input");
            linksBox.setAttribute("name", "links" + currentIndex);

            var keywordsBox = document.createElement("input");
            keywordsBox.setAttribute("name", "keywords" + currentIndex);

            var violationsBox = document.createElement("input");
            violationsBox.setAttribute("name", "violationtype" + currentIndex);

            // var addRowBox = document.createElement("input");
            // addRowBox.setAttribute("type", "button");
            // addRowBox.setAttribute("value", "Add another line");
            // addRowBox.setAttribute("onclick", "addField();");
            // addRowBox.setAttribute("class", "button");

            var currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(linksBox);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(keywordsBox);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(violationsBox);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(addRowBox);
        }
    </script>


    <script>
        $(document).ready(function() {
            // Function to populate the product category dropdown
            function populateProductCategories(companyId) {
                var productCategoryDropdown = $('#product_category_id');
                productCategoryDropdown.empty();

                $.ajax({
                    url: "{{ route('product_category_dropdown') }}",
                    method: 'GET',
                    data: {
                        company_id: companyId
                    },
                    success: function(data) {
                        productCategoryDropdown.append($('<option>', {
                            value: '',
                            text: 'Please select a product category'
                        }));

                        $.each(data, function(index, category) {
                            productCategoryDropdown.append($('<option>', {
                                value: category.key,
                                text: category.val
                            }));
                        });
                    }
                });
            }

            // Initial state: Disable the product category dropdown if action is 'edit'
            if (action === 'edit') {
                $('#company_id').prop('disabled', true);
                $('#product_category_id').prop('disabled', false);
            }

            // Event listener for the company dropdown change
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                if (companyId) {
                    // Enable the product category dropdown
                    $('#product_category_id').prop('disabled', false);
                    // Populate the product category dropdown
                    populateProductCategories(companyId);
                } else {
                    // No company selected, disable and reset the product category dropdown
                    $('#product_category_id').prop('disabled', true);
                    $('#product_category_id').empty();
                    $('#product_category_id').append($('<option>', {
                        value: '',
                        text: 'Please select a company first'
                    }));
                }
            });
        });
    </script>


    <script>
        $('#product_price').inputmask({
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

        $(document).ready(function(e) {
            $('#car_catalog_type').select2({
                minimumResultsForSearch: Infinity
            });
        });

        var product_id = '{{@$product->product_id ?? " "}}';
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
            formData.append("id", product_id);

            return $.ajax({
                type: 'POST',
                url: "{{route('ajax_upload_product_note_image')}}",
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
        const inputPostImages = document.querySelector('#upload-post-images');
        const pondPostImages = FilePond.create(inputPostImages, {
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            maxFiles: 150,
            maxFileSize: '30MB',
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
            insertAfter: (element) => {

            },
            onwarning: () => {
                var container = document.querySelector('.post-images-filepond');
                var error = container.querySelector('p.filepond--warning');
                if (!error) {
                    error = document.createElement('p');
                    error.className = 'filepond--warning';
                    error.textContent = 'The maximum number of files is ' + pondPostImages.maxFiles;
                    container.appendChild(error);
                }
                requestAnimationFrame(function() {
                    error.dataset.state = 'visible';
                });
                clearTimeout(pondMultipleTimeout);
                pondMultipleTimeout = setTimeout(function() {
                    error.dataset.state = 'hidden';
                }, 5000);
            },
            onupdatefiles: (files) => {},
            onreorderfiles: (files, origin, target) => {},
            onremovefile(error, file) {
                var id = file.serverId;
                if (id) {
                    $.ajax({
                        url: "{{ route('ajax_remove_product_images') }}",
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(e) {
                            if (e.status) {

                            }
                        }
                    })
                }
            },
            files: [
                <?php
                        if(@$product !== null){
                        if($product->hasMedia('product_image') ){
                            foreach(@$product->getMedia('product_image') as $file){
                    ?> {

                    source: '{{ @$file->id }}',
                    options: {
                        type: 'local',
                        file: {
                            name: '{{ @$file->file_name }}',
                            size: '{{ @$file->size }}',
                            type: '{{ @$file->mime_type }}'
                        },
                        metadata: {
                            poster: '{{ @$file ? $file->getUrl() : '' }}'
                        }
                    }
                },
                <?php
                            }
                        }
                    }
                    ?>
            ]
        });

        pondPostImages.setOptions({
            server: {
                process: {
                    url: "{{ route('ajax_upload_product_image') }}",
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
                        var id = '{{ @$post->post_id ?? @$post->id }}';
                        var action = '{{ @$post->post_id ? 2 : 1 }}';
                        formData.append('id', id);
                        formData.append('action', action);
                        formData.append('_token', '{{ csrf_token() }}');
                        return formData;
                    }
                },
                revert: {
                    url: "{{ route('ajax_revert_product_image') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    onload: function(response) {
                        var e = JSON.parse(response);
                        if (e.status) {

                        }
                    },
                },
            }
        });
    </script>
@endsection
