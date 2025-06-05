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

    @media only screen and (max-width: 700px) {
        #img {
            width: 100%;
        }
    }

    .note-editor.note-frame .note-editing-area .note-editable,
    .note-editor.note-frame .note-editing-area .note-codable {
        color: #000000 !important;
    }
</style>
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $title }} Department Equipment</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Department Equipment</a>
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

<form method="POST" action="{{$submit}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Form Details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department_equipment_id">Department Equipment<span class="text-danger">*</span></label>
                                <input type="text" name="department_equipment_id" maxlength="100" class="form-control" value="{{$form->department_equipment->department_equipment_name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_name">Form Name<span class="text-danger">*</span></label>
                                <input name="form_name" type="text" maxlength="100" class="form-control" value="{{ @$form->form_name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                    <a href="{{ route('form_listing', $form->form_id) }}" class="btn btn-secondary" type="button">Cancel</a>
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
<div class="modal fade" id="upload_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
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