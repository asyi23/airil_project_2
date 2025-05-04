@extends('layouts.master')

@section('title')
    {{ $title }} Brochure
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
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Summernote css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.min.css') }}">
    <style>
        .select2-selection__choice {
            background-color: #556ee6 !important;
            color: white;
            border-radius: 4px !important;

        }

        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #Img {
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
            #Img {
                width: 100%;
            }
        }
        .custom-dropdown-container .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }} Custom Brochure</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Brochure</a>
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
    <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Company Detail</h4>
                        <div class="row">
                            @if (!empty($company_name))
                                <div class="col-sm-6" style="margin-bottom: 10px">
                                    <label for="company_id">Company <span class="text-danger">*</span></label>
                                    <input name="company_id" id="company_id" type="text" class="form-control select2"
                                        value="{{ $company_name }}" disabled>
                                </div>
                            @else
                                <div class="col-sm-6" style="margin-bottom: 10px">
                                    <label for="company_id">Company <span class="text-danger">*</span></label>
                                    <select name="company_id" class="form-control select2" id="company_id">
                                        @foreach ($company as $key => $val)
                                            <option
                                                value="{{ $key }}"{{ $key == @$post->company_id ? 'selected' : ($key == (@$promotion->company->company_id ?? null) ? 'selected' : '') }}>
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if (Auth::user()->roles->value('id') == 4)
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company_branch_id">Company Branch <span
                                            class="text-danger">*</span></label>
                                    <input name="company_branch_id" id="company_branch_id" type="text"
                                        class="form-control select2" value="{{ @$company_branch }}" readonly>
                                </div>
                            </div>
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group custom-dropdown-container">
                                    <label for="is_published">Publish</label>
                                    {!! Form::select('is_published', $status, @$post->is_published ?? '0', ['class' => 'form-control select2', 'id' => 'is_published' ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->user_type->user_type_slug == 'admin' || Auth::user()->roles->value('id') == 3)
                    <div class="card" id="company_branch">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Branch<span
                                class="text-danger">*</span></h4>
                            <div data-repeater-item class="outer" id="branch_data">
                                <div class="form-group row mb-4">
                                    <div class="col-md-12">
                                        <ul style="padding: 0">
                                            <li class="custom-control custom-checkbox">
                                                <input type="checkbox" id="check_all1" class="custom-control-input check-all">
                                                <label class="custom-control-label" for="check_all1">Check All</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul>
                                            @foreach ($branch as $branchId => $branchName)
                                                <li class="custom-control custom-checkbox"
                                                    style="list-style:none;display:inline-block;width:200px;margin-bottom:10px">
                                                    <input class="custom-control-input check check1" type="checkbox"
                                                        name="branch[]" value="{{ $branchId }}"
                                                        id="{{ $branchId }}"
                                                        @if (
                                                            (@$post->branch && in_array($branchId, $post->branch)) ||
                                                                (is_array(@$post->company_branch_id) && in_array($branchId, @$post->company_branch_id))) checked @endif>
                                                    <label class="custom-control-label"
                                                        for="{{ $branchId }}">{{ $branchName }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (@$data)
                    <div class="card" id="card2">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Car Model<span class="text-danger">*</span></h4>
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <div class="col-md-12">
                                        <ul style="padding: 0">
                                            <li class="custom-control custom-checkbox">
                                                <input type="checkbox" id="check_all2" class="custom-control-input check-all">
                                                <label class="custom-control-label" for="check_all2">Check All</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul>
                                            @foreach ($data as $index => $car)
                                                <li class="custom-control custom-checkbox"
                                                    style="list-style:none;display:inline-block;width:150px;margin-bottom:10px">
                                                    <input class="custom-control-input check check2" type="checkbox"
                                                        name="car_model[]" value="{{ $car['car_model_name'] }}"
                                                        id="{{ $car['car_model_name'] }}"
                                                        @if (in_array($car['car_model_name'], $selectedCarModels)) checked @endif>
                                                    <label class="custom-control-label"
                                                        for="{{ $car['car_model_name'] }}">{{ $car['car_model_name'] }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- </form> --}}
                @if (Auth::user()->user_type->user_type_slug == 'admin')
                    <div class="card" id="car_model">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Car Model <span class="text-danger">*</span></h4>
                            <div data-repeater-item class="outer" id="branch_data">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @if ($action === 'edit')
                <div class="col-xl-3 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Upload Custom Brochure</h4>
                            <div id="brochure_media">
                                @php
                                    $Brochure = $brochure->getMedia('brochure_media')->last();
                                @endphp
                                <label for="brochure_media">Custom Brochure</label><span class="text-danger">*</span>
                                <div id="BrochureContainer" style="margin-bottom: 5px; display: {{ $Brochure ? 'flex' : 'none' }};align-items:center">
                                    <a href="{{$Brochure?->getUrl()}}" target="_blank"><img id="BrochurePreview" src="{{ $Brochure ? $Brochure->getUrl('thumb') : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;"></a>
                                    <a class="closeButton" id="brochureCloseButton" data-modal-message="Brochure"  data-brochure-id="{{ @$post->brochure_id }}" data-file-name="brochure_media"style="cursor: pointer;margin-left:20px"><i style="color: red;font-size:18px" class='bx bx-trash'></i></a>
                                </div>
                                <div class="input-group">
                                    <input type="file" class="custom-file-input"
                                        style="width: 100%;" name="brochure_media"
                                        id="brochure_media" accept=".pdf"
                                        onchange=" updateImagePreview(this, 'BrochurePreview','BrochureContainer', 'brochureCloseButton'), updateLabelWithFileName(this, 'brochure_media_label')"
                                        @error('brochure_media') is-invalid @enderror>
                                    <label class="custom-file-label" id="brochure_media_label"
                                        style=" overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;"
                                        for="exampleInputFile">Select  Brochure
                                    </label>
                                </div>
                                <small class="text-secondary">&nbsp;&nbsp;*Accept PDF only</small>
                                @error('brochure_media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($action === 'add')
                <div class="col-xl-3 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Upload Custom Brochure</h4>
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-sm-12">
                                    <div id="brochure_media">
                                        <label for="brochure_media">Custom Brochure</label><span class="text-danger">*</span>
                                        <div class="input-group">
                                            <input type="file" class="custom-file-input"
                                                style="width: 100%;" name="brochure_media"
                                                id="brochure_media" accept=".pdf"
                                                onchange="updateLabelWithFileName(this, 'brochure_media_label')"
                                                multiple @error('brochure_media') is-invalid @enderror>
                                            <label class="custom-file-label" id="brochure_media_label"
                                                style=" overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;"
                                                for="exampleInputFile">Select Brochure
                                            </label>
                                        </div>
                                        <small class="text-secondary">&nbsp;&nbsp;*Accept PDF</small>
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
                </div>
            @endif
            <div class="col-xl-9 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                        <a href="{{ route('brochure_listing') }}" class="btn btn-secondary"
                            type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- Modal --}}
    <div id= "brochureModal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="Img">
    </div>
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{route('brochure_remove_upload')}}">
                    @csrf
                    <div class="modal-body">
                        <h4 style="margin-bottom: 10px">Remove This ?</h4>
                        <input type="hidden" name="brochure_id" id="brochure_id_modal">
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
    <div class="modal fade" id="upload_error" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel"aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="text-align: center;margin-top:30px">
                    <img src="{{URL::asset("assets/images/error.png")}}" style="width: 27%" alt="">
                </div>
                <div style="text-align: center;font-size:20px;margin-top:30px">
                    File size exceeds the 50 MB limit.
                </div>
                <div style="text-align: center;margin-bottom:20px;margin-top:20px;">
                    <button type="button" style="width:60px" class="btn btn-secondary"
                        data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script> --}}
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
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
    <!-- <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script> -->
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


    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>
    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>

    <script src="{{ URL::asset('assets/js/jquery.fancybox.min.js') }}"></script>
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/summernote-image-attributes.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#is_published').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function areAllOthersChecked1() {
                return $(".check1:not(#check_all1)").length === $(".check1:checked:not(#check_all1)").length;
            }

            $("#check_all1").prop("checked", areAllOthersChecked1());

            // Listen for changes on the individual checkboxes in card 1
            $("body").on("change", ".check1", function() {
                // Update the "Check All" checkbox for card 1 accordingly
                $("#check_all1").prop("checked", areAllOthersChecked1());
            });

            // Listen for changes on the "Check All" checkbox for card 1
            $("body").on("change", "#check_all1", function() {
                // Set all other checkboxes in card 1 to the same state as the "Check All" checkbox
                $(".check1").prop("checked", $(this).prop("checked"));
            });

            // Function to check if all other checkboxes are checked for card 2
            function areAllOthersChecked2() {
                return $(".check2:not(#check_all2)").length === $(".check2:checked:not(#check_all2)").length;
            }

            // Set the initial state of "Check All" for card 2 based on whether all other checkboxes are checked
            $("#check_all2").prop("checked", areAllOthersChecked2());

            // Listen for changes on the individual checkboxes in card 2
            $("body").on("change", ".check2", function() {
                // Update the "Check All" checkbox for card 2 accordingly
                $("#check_all2").prop("checked", areAllOthersChecked2());
            });

            // Listen for changes on the "Check All" checkbox for card 2
            $("body").on("change", "#check_all2", function() {
                // Set all other checkboxes in card 2 to the same state as the "Check All" checkbox
                $(".check2").prop("checked", $(this).prop("checked"));
            });
        });
    </script>
    <script>
        // Get the value of the 'action' variable
        var action = "{{ @$action }}";

        // Initial state: Disable the product category dropdown if action is 'edit'
        if (action === 'edit') {
            $('#company_id').prop('disabled', true);
        }

        function updateLabelWithFileName(input, labelId) {
            const label = document.getElementById(labelId);
            const modal = document.getElementById("upload_error");
            const maxSize = 50 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                $(modal).modal('show');
            } else {
                if (input.files.length > 0) {
                    label.textContent = input.files[0].name;
                } else {
                    label.textContent = `Select : 'Brochure'}`;
                }
            }
        }
    </script>
    <script>
        function updateImagePreview(input, previewId, containerId, buttonId) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(containerId);
        const modal = document.getElementById("upload_error");
        const button = document.getElementById(buttonId)
        const maxSize = 50 * 1024 * 1024;

        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                input.value = '';
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
    </script>
    <script>
        if (action === 'edit') {
            $('#company_id').prop('disabled', true);
        }
        function showImagePreview(imageUrl) {
            const modal = document.getElementById("Modal");
            const modalImage = document.getElementById("modalImage");

            modal.style.display = "block";
            modalImage.src = imageUrl;

            const closeButton = document.querySelector(".closebtn");
            closeButton.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Close the modal if the user clicks outside of it
            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        }
    </script>
    <script>
        var brochureModal = document.getElementById("brochureModal");
        var brochureModalImg = document.getElementById("Img");

        var brochureImages = document.querySelectorAll(".brochure-clickable");

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
                    const brochureId = this.getAttribute("data-brochure-id");

                    // Update the value of the hidden input field in the modal
                    modal.querySelector("#brochure_id_modal").value = brochureId;

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
            var companySelect = $("#company_id");
            var branchSelect = $("#company_branch");
            var carModelSelect = $("#car_model");
            var selectedCarModels = <?php echo json_encode($selectedCarModels); ?>;
            function updateBranchAndModel(){
                if (companySelect.val() === ""){
                    branchSelect.hide();
                    carModelSelect.hide();
                }else{
                    // carModelSelect.hide();
                    @if (Auth::user()->user_type->user_type_slug == 'admin') {
                        var companyId = companySelect.val();
                        branchSelect.show();
                        $("#branch_data").hide();
                        carModelSelect.show();
                        $("#model_data").hide();
                        // Send an Ajax request to get the branches based on the selected company
                        $.ajax({
                            url: "{{ route('get.branches', '') }}/" + companyId,
                            method: 'GET',
                            success: function(data) {
                                var newHtmlContent = `
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Branch <span class="text-danger">*</span></h4>
                                        <div data-repeater-item class="outer">
                                            <div class="form-group row mb-4">
                                                <div class="col-md-12">
                                                    <ul style="padding: 0">
                                                        <li class="custom-control custom-checkbox">
                                                            <input type="checkbox" id="check_all1" class="custom-control-input check-all">
                                                            <label class="custom-control-label" for="check_all1">Check All</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-12">
                                                    <ul>
                                                        ${Object.entries(data).map(([branchId, branchName]) => `
                                                            <li class="custom-control custom-checkbox" style="list-style:none;display:inline-block;width:200px;margin-bottom:10px">
                                                                <input class="custom-control-input check1" type="checkbox" name="branch[]" value="${branchId}" id="${branchId}" ${($('#' + branchId).prop('checked')) ? 'checked' : ''}>
                                                                <label class="custom-control-label" for="${branchId}">${branchName}</label>
                                                            </li>
                                                        `).join('')}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#company_branch').html(newHtmlContent);
                                branchSelect.show();
                                if ($(".check1:not(#check_all1)").length === $(".check1:checked:not(#check_all1)").length) {
                                    $("#check_all1").prop("checked", true);
                                }
                            }
                        });
                        $.ajax({
                            url: "{{ route('get.car_model', '') }}/" + companyId,
                            method: 'GET',
                            success: function(data) {
                                var newHtmlContent1 = `
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Car Model <span class="text-danger">*</span></h4>
                                    <div data-repeater-item class="outer">
                                        <div class="form-group row mb-4">
                                            <div class="col-md-12">
                                                <ul style="padding: 0">
                                                    <li class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="check_all2" class="custom-control-input check-all">
                                                        <label class="custom-control-label" for="check_all2">Check All</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <ul>
                                                    ${Object.entries(data).map(([index, carModel]) => `
                                                        <li class="custom-control custom-checkbox" style="list-style:none;display:inline-block;width:150px;margin-bottom:10px">
                                                            <input class="custom-control-input check check2" type="checkbox"
                                                                name="car_model[]" value="${carModel['car_model_name']}"
                                                                id="${carModel['car_model_name']}"
                                                                ${selectedCarModels.includes(carModel['car_model_name']) ? 'checked' : ''}>
                                                            <label class="custom-control-label"
                                                                for="${carModel['car_model_name']}">${carModel['car_model_name']}</label>
                                                        </li>
                                                    `).join('')}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                                $('#car_model').html(newHtmlContent1);
                                carModelSelect.show();
                                if ($(".check2:not(#check_all2)").length === $(".check2:checked:not(#check_all2)").length) {
                                    $("#check_all2").prop("checked", true);
                                }
                            }
                        });
                    }
                    @endif
                }
            }
            companySelect.on("change", updateBranchAndModel);

            updateBranchAndModel();
        })
    </script>
@endsection
