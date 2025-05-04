@extends('layouts.master')

@section('title') {{ $title }} Promotion @endsection

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
    <!-- Summernote css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.min.css')}}">
    <style>
        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #modalImage {
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
        #thumbnailImg{
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
        #bannerImg{
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
        #modalImage {
            width: 100%;
        }
        #thumbnailImg{
            width: 100%;
        }
        #bannerImg{
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
			<h4 class="mb-0 font-size-18">{{ $title }} Promotion</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Promotion</a>
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
                <h4 class="card-title mb-4">Company Detail</h4>
                <div class="row">
                    @if(!empty($company_name))
                    <div class="col-sm-6">
                        <label for="company_id">Company <span class="text-danger">*</span></label>
                            <input name="type" id="type" type="text" class="form-control select2" value="{{ $company_name }}" readonly>
                    </div>
                    @else
                    <div class="col-sm-6">
                        <label for="company_id">Company <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control select2" id="company_id">
                            @foreach($company as $key => $val)
                                <option value="{{$key}}"{{ $key == @$post->company_id ? 'selected' : ($key == (@$promotion->company->company_id ?? null) ? 'selected' : '') }}>{{$val}}</option>
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
                <h4 class="card-title mb-4">Promotion Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="promotion_name">Promotion Name <span class="text-danger">*</span></label>
                            <input id="promotion_name" type="text" name="promotion_name" class="form-control" value="{{ @$post->promotion_name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="promotion_short_description">Promotion Short Description </label>
                            <input id="promotion_short_description" type="text" name="promotion_short_description" class="form-control" value="{{ @$post->promotion_short_description }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="is_published">Publish </label>
                            {!! Form::select('is_published', $status, @$post->is_published ?? '0', ['class' => 'form-control select2', 'id' => 'is_published' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="promotion_description">Promotion Description</label>
                            <textarea id="summernote" name="promotion_description" type="text" class="form-control" >{{ @$post->promotion_description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->user_type->user_type_slug == 'admin' || Auth::user()->roles->value('id') == 3)
             @if (!empty($branch))
                <div class="card" id="company_branch">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Branch</h4>
                        <div data-repeater-item class="outer">
                            <div class="form-group row mb-4">
                                <div class="col-md-12">
                                    <ul style="padding: 0">
                                        <li class="custom-control custom-checkbox">
                                            <input type="checkbox" id="check_all" class="custom-control-input check-all" >
                                            <label class="custom-control-label" for="check_all" >Check All</label>
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
                                                    @endif>
                                                <label class="custom-control-label" for="{{ $branchId }}" >{{ $branchName }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    {{-- </form> --}}
    </div>
    @if ($action ==='edit')
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Upload Promotion Banner & Thumbnail</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        @php
                            $promotionThumbnail = $promotion->getMedia('promotion_thumbnail')->last();
                        @endphp
                        <label for="promotion_thumbnail">Promotion Thumbnail</label>
                        <div id="promotionThumbnailContainer" style="margin-bottom: 5px; display: {{ $promotionThumbnail ? 'block' : 'none' }};overflow:hidden;">
                            <img id="promotionThumbnailPreview" src="{{ $promotionThumbnail ? $promotionThumbnail->getUrl(): ''}}" style="max-height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;" class="promotion-thumbnail-clickable" >
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="promotion_thumbnail" id="promotion_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this);updateLabelWithFileName(this)" multiple @error('promotion_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"
                                id = "promotion_thumbnail"
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
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        @php
                            $promotionBanner =$promotion->getMedia('promotion_banner')->last();
                        @endphp
                        <label for="promotion_banner">Promotion Banner</label>
                        <div id="promotionBannerContainer" style="margin-bottom: 5px; display: {{ $promotionBanner ? 'block' : 'none' }};overflow:hidden;">
                            <img id="promotionBannerPreview" src="{{ $promotionBanner ? $promotionBanner->getUrl() : '' }}"style="max-height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;" class="promotion-banner-clickable">
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="promotion_banner" id="promotion_banner" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview1(this);updateLabelWithFileName1(this)" multiple @error('promotion_banner') is-invalid @enderror>
                            <label class="custom-file-label"
                                id = "promotion_banner"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Promotion Banner
                            </label>
                        </div>
                        @error('promotion_thumbnail')
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
    @if ($action ==='add')
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Upload Promotion Banner & Thumbnail</h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <label for="promotion_thumbnail">Promotion Thumbnail</label>
                        <div id="imagePreviews" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="promotion_thumbnail" id="promotion_thumbnail" accept=".jpeg,.png,.jpg,.gif" onchange="updateImageCountAndPreviews(this)" multiple @error('promotion_thumbnail') is-invalid @enderror>
                            <label class="custom-file-label"id = "promotion_thumbnail" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" for="exampleInputFile">Select Promotion Thumbnail</label>
                        </div>
                        @error('promotion_thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <label for="promotion_banner">Promotion Banner</label>
                        <div id="imagePreviews2" style="padding-bottom: 5px;"></div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;" name="promotion_banner" id="promotion_banner"  accept=".jpeg,.png,.jpg,.gif" onchange="updateImageCountAndPreviews2(this)" multiple @error('promotion_banner') is-invalid @enderror>
                            <label class="custom-file-label"
                                id = "promotion_banner"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Promotion Banner
                            </label>
                        </div>
                        @error('promotion_banner')
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
    <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                <a href="{{ route('promotion_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
            </div>
        </div>
    </div>
</div>
</form>
{{-- Modal --}}
<div id="Modal" class="modal">
    <span class="closebtn" style="color: white">&times;</span>
    <img src="" alt="" id="modalImage">
</div>
<div id="thumbnailModal" class="modal">
    <span class="closebtn" id="closeModal" style="color: white">&times;</span>
    <img src="" alt="" id="thumbnailImg">
</div>
<div id="bannerModal" class="modal">
    <span class="closebtn" id="closeModal1"  style="color: white">&times;</span>
    <img src="" alt="" id="bannerImg">
</div>
<div class="modal fade" id="upload_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div style="text-align: center;margin-top:30px">
                <img src="{{URL::asset("assets/images/error.png")}}" style="width: 27%" alt="">
            </div>
            <div style="text-align: center;font-size:20px;margin-top:30px">
                File size exceeds the 10 MB limit.
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
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/summernote-image-attributes.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#is_published').select2({
                minimumResultsForSearch: Infinity
            });
            $('#branch_selection').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    @php
        $promotionId = $promotion->promotion_id ?? null;
    @endphp
    <script>
        // Get the value of the 'action' variable
        var action = "{{ @$action }}";

        // Initial state: Disable the product category dropdown if action is 'edit'
        if (action === 'edit') {
            $('#company_id').prop('disabled', true);
        }
    </script>
    <script>
       var id = '{{$promotionId}}';
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
            formData.append("id", id);

            return $.ajax({
                type: 'POST',
                url: "{{route('ajax_upload_promotion_note_image')}}",
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
        if (action === 'edit') {
            $('#company_id').prop('disabled', true);
        }
        function updateLabelWithFileName(input) {
            const label = document.querySelector('label[id = "promotion_thumbnail"]');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = "Select Promotion Thumbnail";
            }
        }
        function updateLabelWithFileName1(input) {
        const label = document.querySelector('label[id = "promotion_banner"]');
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = "Select Promotion Banner";
        }
    }
        function updateImageCountAndPreviews(input) {
            const imagePreviews = document.getElementById("imagePreviews");
            const modal = document.getElementById("upload_error");
            const maxSize = 10 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                $(modal).modal('show');
            }else{
                imagePreviews.innerHTML = ""; // Clear existing previews
                updateLabelWithFileName(input);
                for (let i = 0; i < input.files.length; i++) {
                    const imageUrl = URL.createObjectURL(input.files[i]);
                    const image = document.createElement("img");
                    image.src = URL.createObjectURL(input.files[i]);
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

        function updateImageCountAndPreviews2(input) {
            const imagePreviews = document.getElementById("imagePreviews2");
            const modal = document.getElementById("upload_error");
            const maxSize = 10 * 1024 * 1024;
            if (input.files[0].size > maxSize) {
                $(modal).modal('show');
            }else{
                imagePreviews.innerHTML = ""; // Clear existing previews
                updateLabelWithFileName1(input);
                for (let i = 0; i < input.files.length; i++) {
                    const imageUrl = URL.createObjectURL(input.files[i]);
                    const image = document.createElement("img");
                    image.src = URL.createObjectURL(input.files[i]);
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
        function showImagePreview(imageUrl) {
            const modal = document.getElementById("Modal");
            const modalImage = document.getElementById("modalImage");

            modal.style.display = "flex";
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
        function updateImagePreview(input) {
            const preview = document.getElementById('promotionThumbnailPreview');
            const container = document.getElementById('promotionThumbnailContainer');
            const modal = document.getElementById("upload_error");
            const maxSize = 10 * 1024 * 1024;
            if (input.files && input.files[0]) {
                if (input.files[0].size > maxSize) {
                    input.value = ''; // Clear the input field
                    $(modal).modal('show');

                } else {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    container.style.display = 'block';

                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                preview.src = '';
                container.style.display = 'none';
            }
        }
        function updateImagePreview1(input) {
            const preview = document.getElementById('promotionBannerPreview');
            const container = document.getElementById('promotionBannerContainer');
            const modal = document.getElementById("upload_error");
            const maxSize = 10 * 1024 * 1024;
            if (input.files && input.files[0]) {
                if (input.files[0].size > maxSize) {
                    input.value = ''; // Clear the input field
                    $(modal).modal('show');

                } else {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    container.style.display = 'block';

                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                preview.src = '';
                container.style.display = 'none';
            }
        }
    </script>
    <script>
        var thumbnailModal = document.getElementById("thumbnailModal");
        var thumbnailModalImg = document.getElementById("thumbnailImg");

        var thumbnailImages = document.querySelector(".promotion-thumbnail-clickable");

        thumbnailImages.onclick = function() {
            thumbnailModal.style.display = "flex";
            thumbnailModalImg.src = this.src;
        }

        var thumbnailCloseButton = document.getElementById("closeModal");
        thumbnailCloseButton.onclick = function() {
            thumbnailModal.style.display = "none";
        }
    </script>
    <script>
        var bannerModal = document.getElementById("bannerModal");
        var bannerModalImg = document.getElementById("bannerImg");

        var bannerImages = document.querySelector(".promotion-banner-clickable");

        bannerImages.onclick = function() {
            bannerModal.style.display = "flex";
            bannerModalImg.src = this.src;
        }

        var bannerCloseButton = document.getElementById("closeModal1");
        bannerCloseButton.onclick = function() {
            bannerModal.style.display = "none";
        }
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
    <script>
        $(document).ready(function() {
            var companySelect = $("#company_id");
            var branchSelect = $("#company_branch");
            var selection = $("#branch_selection");

            function enableSelection() {
                if (companySelect.val() === "") {
                    selection.prop("disabled", true);
                    selection.val('all').trigger('change');
                    branchSelect.hide();
                }else{
                    selection.prop("disabled", false);
                    if(action == 'add' &&"{{ Auth::user()->user_type->user_type_slug == 'admin'}}") {
                        selection.val('all').trigger('change');
                    }
                    branchSelect.hide();
                }
            }
            function updateBranchDropdown() {
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
            companySelect.on("change", enableSelection);
            selection.on("change",updateBranchDropdown);
            enableSelection();
            updateBranchDropdown();
        });
    </script>
@endsection
