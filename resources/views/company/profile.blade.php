@extends('layouts.master')
@section('title')
    Company {{ $title }}
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">

    <style>
        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #Img,#img2,#img3,#img4,#img5,#img6,#img7, #img8, #img9{
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
            #Img,#img2,#img3,#img4,#img5,#img6,#img7,#img8, #img9 {
                width: 100%;
            }
        }


        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 140px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-md-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18"><span>Company Profile&nbsp;</span>
                    @can('company_manage_all')
                        <a href="{{ route('company_profile_edit', $company_id) }}"
                        class="btn btn-sm btn-outline-success waves-effect waves-light mr-2 mb-1"><i
                            class="fa-sharp fa-solid fa-pen"></i> Edit Profile</a>
                    @endcan
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Company</a>
                        </li>
                        <li class="breadcrumb-item active">Profile</li>
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

    <div class="row">
        <div class=" col-md-8 col-sm-12 d-md-none">
            @if ($post->hasMedia('company_banner'))
                <div class="card card-company-banner">
                    <div id="banner-cover" style="img-wrap">
                        <img class="card-img-top img-banner"
                            src="{{ $post->getFirstMedia('company_banner')->getUrl('') }}">
                    </div>
                </div>
            @else
                <div class="card card-company-banner">
                    <div id="banner-cover" style="img-wrap">
                        <img class="card-img-top img-banner" src="{{ URL::asset('assets/images/CompanyBanner.jpg') }}">
                    </div>
                </div>
            @endif
        </div>
        <div class=" col-md-4 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title my-0">Company</h3>
                </div>
                <div class="card-body border-top">
                    @if($post->hasMedia('company_logo'))
                    @php
                        $companylogo = $post->getMedia('company_logo')->last();
                    @endphp
                    <div class="text-center mx-auto mb-4" style="display: flex;align-items:center;justify-content:center;">
                        <div style="margin-bottom: 5px; display: {{ $companylogo ? 'block' : 'none' }};overflow:hidden;">
                            <img  src="{{ $companylogo ? $companylogo->getUrl() : '' }}"  style="max-height:100px;max-width:150px;" >
                        </div>
                    </div>
                    @else
                    <div class="text-center mx-auto mb-4" style="display: flex;align-items:center;justify-content:center;">
                        <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background-color: rgb(160, 160, 160); border-radius: 8px; font-size: 24px; color: white;">
                            {{ ucfirst(substr($post->company_name, 0, 1)) }}
                        </div>
                    </div>
                    @endif
                    <div style="align-items: center;display:flex;justify-content:center;margin-top:-10px">
                        <h5 style="font-weight:bold;">{{ $post->company_name }}</h5>
                    </div>
                    @if ( $post->company_register_number)
                    <div style="align-items: center;display:flex;justify-content:center;">
                        <h6>({{ $post->company_register_number }})</h6>
                    </div>
                    @endif
                    <div style="align-items: center;display:flex;justify-content:center;margin-bottom:5px">
                        @if ($post->company_status == 'active')
                            <span
                                class='badge badge-primary font-size-11'>{{ ucfirst($post->company_status) }}</span><br>
                        @else
                            <span
                                class='badge badge-warning font-size-11'>{{ ucfirst($post->company_status) }}</span><br>
                        @endif
                    </div>
                    <div style="align-items: center;display:flex;justify-content:center;margin-bottom:-10px">
                        <p>Join since {{ $year }}</p>
                    </div>
                </div>
                <div class="card-body border-top px-0">
                    <ul class="list-group list-group-flush font-size-15 text-dark">
                        <h6 class="list-group-item border-0 pt-0">Company Details</h6>
                        <li class="list-group-item border-0 pt-0">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="bx bxs-factory text-muted font-size-13"></i></li>
                                <li class="list-inline-item"><span class="font-size-13">{{ $sector }}</span></li>
                            </ul>
                        </li>
                        @if ($sector == 'Automotive')
                            <li class="list-group-item border-0 pt-0">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="bx bxs-car text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">{{ $carbrand }}</span>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if ($post->company_email!= null)
                            <li class="list-group-item border-0 pt-0">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="bx bxs-envelope text-muted font-size-13"></i>
                                    </li>
                                    <li class="list-inline-item"><span
                                            class="font-size-13">{{ $post->company_email }}</span></li>
                                </ul>
                            </li>
                        @endif
                        @if ($post->company_phone)
                            <li class="list-group-item border-0 pt-0">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="bx bxs-phone text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span
                                            class="font-size-13">+{{ $post->company_phone }}</span></li>
                                </ul>
                            </li>
                        @endif
                        @if ($post->company_website != null)
                            <li class="list-group-item border-0 pt-0" style="margin-bottom: -20px">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="bx bx-world text-muted font-size-13"></i>
                                    </li>
                                    <li class="list-inline-item">
                                        <a
                                            href="{{ strpos($post->company_website, 'http') === 0 ? $post->company_website : 'http://' . $post->company_website }}"
                                            target="_blank" style="text-decoration: none; color: #374255;"
                                            class="font-size-13">{{ $post->company_website }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class=" col-md-8 col-sm-12 ">
            @if ($post->hasMedia('company_banner'))
                <div class="card card-company-banner d-md-block d-sm-none d-none">
                    <div id="banner-cover" style="img-wrap">
                        <img class="card-img-top img-banner"
                            src="{{ $post->getFirstMedia('company_banner')->getUrl('') }}">
                    </div>
                </div>
            @else
                <div class="card card-company-banner d-md-block d-sm-none d-none">
                    <div id="banner-cover" style="img-wrap">
                        <img class="card-img-top img-banner"
                            src="{{ URL::asset('assets/images/CompanyBanner.jpg') }}">
                    </div>
                </div>
            @endif
            @if ($post->company_description != null)
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title my-0">Company Description</h3>
                    </div>
                    <div class="card-body border-top">
                        <div style="font-size: 14px; line-height: 1.5; text-align: justify;margin-top:-20px">
                            <p>{!! $post->company_description !!}
                                <style>
                                    div iframe[src*="youtube.com"] {
                                        width: 100%;
                                        height: 300px;
                                    }
                                </style>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if ($post->hasMedia('company_thumbnail')|| $post->hasMedia('promotion_thumbnail')||$post->hasMedia('catalog_thumbnail')||$post->hasMedia('pricelist_thumbnail')||$post->hasMedia('brochure_thumbnail')|| $post->hasMedia('general_thumbnail'))
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title my-0">Company Uploads</h3>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            @if($post->hasMedia('company_thumbnail'))
                            <div class="col-sm-4">
                                @php
                                    $companyThumbnail = $post->getMedia('company_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="bx bxs-buildings text-muted font-size-13"></i>
                                    </li>
                                    <li class="list-inline-item"><span class="font-size-13">Company Thumbnail</span></li>
                                </ul>
                                <br>
                                <div id="companyThumbnailContainer" style="margin-bottom: 5px; display: {{ $companyThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="companyThumbnailPreview" src="{{ $companyThumbnail ? $companyThumbnail->getUrl(): ''}}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="company-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                            @if($post->hasMedia('promotion_thumbnail'))
                            <div class="col-sm-4">
                                @php
                                    $promotionThumbnail = $post->getMedia('promotion_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="fa-solid fa-bullhorn text-muted font-size-13"></i>
                                    </li>
                                    <li class="list-inline-item"><span class="font-size-13">Promotion Thumbnail</span></li>
                                </ul>
                                <br>
                                <div id="promotionThumbnailContainer" style="margin-bottom: 5px; display: {{ $promotionThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="promotionThumbnailPreview" src="{{ $promotionThumbnail ? $promotionThumbnail->getUrl(): ''}}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="promotion-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                            @if ($post->hasMedia('catalog_thumbnail') && $sector == 'Automotive')
                            <div class="col-sm-4">
                                @php
                                    $catalogThumbnail = $post->getMedia('catalog_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="bx bxs-car text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">Car Catalog Thumbnail</span>
                                    </li>
                                </ul>
                                <br>
                                <div id="CatalogThumbnailContainer" style="margin-bottom: 5px; display: {{ $catalogThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="CatalogThumbnailPreview" src="{{ $catalogThumbnail ? $catalogThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="catalog-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                            @if ($post->hasMedia('pricelist_thumbnail') && $sector == 'Automotive')
                            <div class="col-sm-4">
                                @php
                                    $pricelistThumbnail = $post->getMedia('pricelist_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="bx bx-dollar text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">Pricelist Thumbnail</span>
                                    </li>
                                </ul>
                                <br>
                                <div id="PricelistThumbnailContainer" style="margin-bottom: 5px; display: {{ $pricelistThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="PricelistThumbnailPreview" src="{{ $pricelistThumbnail ? $pricelistThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="pricelist-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                            @if ($post->hasMedia('brochure_thumbnail') && $sector == 'Automotive')
                            <div class="col-sm-4">
                                @php
                                    $brochureThumbnail = $post->getMedia('brochure_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="bx bxs-spreadsheet text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">Brochure Thumbnail</span>
                                    </li>
                                </ul>
                                <br>
                                <div id="BrochureThumbnailContainer" style="margin-bottom: 5px; display: {{ $brochureThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="BrochureThumbnailPreview" src="{{ $brochureThumbnail ? $brochureThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="brochure-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                            @if ($post->hasMedia('general_thumbnail') && $sector == 'General')
                            <div class="col-sm-4">
                                @php
                                    $generalThumbnail = $post->getMedia('general_thumbnail')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i
                                            class="bx bxs-purchase-tag-alt text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">General Thumbnail</span></li>
                                </ul>
                                <br>
                                <div id="GeneralThumbnailContainer" style="margin-bottom: 5px; display: {{ $generalThumbnail ? 'block' : 'none' }};overflow:hidden;">
                                    <img id="GeneralThumbnailPreview" src="{{ $generalThumbnail ? $generalThumbnail->getUrl() : '' }}"  style="height:90px;max-width:150px;margin-top: 5px;cursor: pointer;margin-left:3px" class="general-thumbnail-clickable">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if ($sector == 'Automotive' && ($post->hasMedia('pricelist_media') || $post->hasMedia('brochure_media')))
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title my-0">Company Pricelist & Brochure</h3>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        @if ($post->hasMedia('pricelist_media'))
                            <div class="col-sm-4">
                                @php
                                    $companyPricelist = $post->getMedia('pricelist_media')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i class="bx bx-dollar text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">Company Pricelist</span></li>
                                </ul>
                                <br>
                                <div id="PricelistContainer" style="margin-bottom: 5px; display: {{ $companyPricelist ? 'block' : 'none' }};overflow:hidden;">
                                    <a href="{{$companyPricelist?->getUrl()}}" target="_blank"><img id="PricelistPreview" src="{{ $companyPricelist ? $companyPricelist->getUrl('thumb') : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;margin-left:3px"></a>
                                </div>
                            </div>
                        @endif
                        @if ($post->hasMedia('brochure_media'))
                            <div class="col-sm-4">
                                @php
                                    $companyBrochure = $post->getMedia('brochure_media')->last();
                                @endphp
                                <ul class="list-inline font-size-15 text-dark mb-0">
                                    <li class="list-inline-item"><i
                                            class="bx bxs-spreadsheet text-muted font-size-13"></i></li>
                                    <li class="list-inline-item"><span class="font-size-13">Company Brochure</span></li>
                                </ul>
                                <br>
                                <div id="BrochureContainer" style="margin-bottom: 5px; display: {{ $companyBrochure ? 'block' : 'none' }};overflow:hidden;">
                                    <a href="{{$companyBrochure?->getUrl()}}" target="_blank"><img id="BrochurePreview" src="{{ $companyBrochure ? $companyBrochure->getUrl('thumb') : '' }}"  style="height:90px;max-width:150px;margin-bottom:5px;cursor: pointer;float: left;margin-left:3px"></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
    {{-- Modal --}}
    <div id="Modal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="Img">
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
    <div class="modal fade" id="listingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Listing</h5>
                    <span class="close" id="closeModalBtn" data-dismiss="modal" style="cursor: pointer;font-weight:bold;font-size:30px;">&times;</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="company-id-input" value="">
                    <input type="search" class="form-control" name= "search" id="search" placeholder="Search by Full Name/Username/Email" style="margin-bottom: 10px">
                    <div id="user-listing-data-placeholder">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End Modal --}}
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/cropperjs/cropperjs.min.js') }}"></script>

    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
    {{-- Google API --}}
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYLGBeUbCmMZAnmLpiV7tpVgXA_Xf34Qs&libraries=places&callback=initMap">
    </script>
    <script>
        function copyTextToClipboard(text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }

        // Initialize tooltip for the copy icons on page load
        $(document).ready(function() {
            $('.copyButton').each(function() {
                const $this = $(this);
                const $tooltipText = $this.closest('ul').find('.textToCopy').val();

                $this.attr('data-original-title', $tooltipText).tooltip({
                    trigger: 'manual'
                });


                $this.click(function() {
                    if (!$this.hasClass('copied')) {
                        copyTextToClipboard($tooltipText);

                        $this.attr('data-original-title', 'Copied').tooltip('show');
                        $this.addClass('copied');

                        setTimeout(function() {
                            $this.attr('data-original-title', $tooltipText).tooltip('hide');
                            $this.removeClass('copied');
                        }, 500);
                    }
                });
            });
        });
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
        function openModal(backgroundImage) {
            var modal = document.getElementById("Modal");
            var modalImg = document.getElementById("Img");

            modal.style.display = "block";
            modalImg.src = backgroundImage.slice(4, -1).replace(/"/g, '');

            var closeModal = document.getElementById("closeModal");
            closeModal.onclick = function() {
                modal.style.display = "none";
            }
        }
    </script>
    <script>
        $('#listingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var companyId = button.data('company-id');
            var modal = $(this);

            var companyData = $('#company-' + companyId + '-data').html();
            $('#user-listing-data-placeholder').html(companyData);

            $('#search').val('');

            var $userListingRows = $("#user-listing tbody tr");
            var $searchInput = $("#search");

            $searchInput.on("keyup", function () {
                var searchText = $searchInput.val().toLowerCase();

                $userListingRows.each(function () {
                    var fullName = $(this).find("td:eq(1)").text().toLowerCase();
                    var userEmail = $(this).find("td:eq(2)").text().toLowerCase();

                    if (fullName.includes(searchText) || userEmail.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#closeModalBtn').click(function() {
                $('#search').val('');
                $userListingRows.show();
            });
        });
    </script>
@endsection
