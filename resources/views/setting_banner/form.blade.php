@extends('layouts.master')

@section('title') {{ $title }} Admin @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
<style>
    .modal {
        z-index: 1;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
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
    #bannerImg{
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
            <h4 class="mb-0 font-size-18">{{ $title }} Banner</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Setting Banner</a>
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
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Banner Detail</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="banner_name">Banner Name<span class="text-danger">*</span></label>
                            <input name="banner_name" type="text" maxlength="90" class="form-control" value="{{ @$post->banner_name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($action ==='edit')
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Banner Image</h4>
                <div class="row">
                    <div class="col-sm-6">
                        @php
                            $banner = $setting_banner->getMedia('banner_image')->last();
                        @endphp
                        <div id="BannerImgContainer"style="margin-bottom: 10px; display: {{ $banner ? 'block' : 'none' }};overflow:hidden;" >
                            <img id="BannerImgPreview"
                            src="{{$banner ? $banner->getUrl() : ''  }}"
                            height="70" width="100" style="margin-bottom: 5px;cursor: pointer;background-color: rgb(215, 215, 215)" class="banner-clickable">
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;" accept=".jpeg,.png,.jpg,.gif"
                                name="banner_image" id="banner_image" onchange="updateImagePreview(this);updateLabelWithFileName(this)" multiple
                                @error('banner_image') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="banner_image"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Banner Image
                            </label>
                        </div>
                    </div>
                    @error('banner_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($action ==='add')
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Banner Image</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div id="imagePreviews"></div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;" accept=".jpeg,.png,.jpg,.gif"
                                        name="banner_image" id="banner_image" onchange="updateImageCountAndPreviews(this)" multiple
                                        @error('banner_image') is-invalid @enderror>
                                    <label class="custom-file-label"
                                        id="banner_image"
                                        style=" overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;"
                                        for="exampleInputFile">Select Banner Image</label>
                                </div>
                            </div>
                        @error('banner_image')
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
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                        <a href="{{ route('setting_banner_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{{-- Modal --}}
<div id="bannerModal" class="modal">
    <span class="closebtn" id="closeModal" style="color: white">&times;</span>
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
{{-- EndModal --}}
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

<!-- form mask -->
<script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>

<!-- form mask init -->
<script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>
<script>
    function updateImagePreview(input) {
        const preview = document.getElementById('BannerImgPreview');
        const container = document.getElementById('BannerImgContainer');
        const modal = document.getElementById("upload_error");
        const maxSize = 10 * 1024 * 1024;
        if (input.files && input.files[0]) {
            if (input.files[0].size > maxSize) {
                input.value = '';
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
    function updateLabelWithFileName(input) {
    const label = document.querySelector('label[id = "banner_image"]');
    if (input.files.length > 0) {
        label.textContent = input.files[0].name;
    } else {
        label.textContent = "Select Banner Image";
    }
}
</script>
<script>
    var Bannermodal = document.getElementById("bannerModal");
    var BannermodalImg = document.getElementById("bannerImg");

    var Bannerimages = document.querySelector(".banner-clickable");

    Bannerimages.onclick = function(){
        Bannermodal.style.display = 'flex';
        BannermodalImg.src = this.src;
    }

    var BannerCloseButton = document.getElementById("closeModal");
    BannerCloseButton.onclick = function() {
        Bannermodal.style.display = "none";
    }
</script>
<script>
    function updateLabelWithFileName1(input) {
        const label = document.querySelector('label[id = "banner_image"]');
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = "Select Banner Image";
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
            updateLabelWithFileName1(input);
            for (let i = 0; i < input.files.length; i++) {
                const imageUrl = URL.createObjectURL(input.files[i]);
                const image = document.createElement("img");
                image.src = URL.createObjectURL(input.files[i]);
                image.style.maxWidth = '150px';
                image.style.Height = '90px';
                image.style.marginBottom = '5px';
                image.style.cursor = "pointer";

                image.addEventListener('click', function () {
                        showImagePreview(imageUrl);
                });

                imagePreviews.appendChild(image);
            }
        }
    }
    function showImagePreview(imageUrl) {
            const modal = document.getElementById("bannerModal");
            const modalImage = document.getElementById("bannerImg");

            modal.style.display = "flex";
            modalImage.src = imageUrl;

            const closeButton = document.querySelector("#closeModal");
            closeButton.addEventListener("click", function() {
                modal.style.display = "none";
            });

            window.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        }
</script>
@endsection
