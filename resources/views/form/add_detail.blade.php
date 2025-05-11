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
                                <label for="department_id">Equipment Name<span class="text-danger">*</span></label>
                                <input type="text" name="equipment_name" maxlength="100" class="form-control" value="{{$department_equipment->department_equipment_name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="department_id">Part Name<span class="text-danger">*</span></label>
                                <input type="text" name="part_name" maxlength="100" class="form-control" value="{{$form->form_name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_date">Form Date<span class="text-danger">*</span></label>
                                <input name="form_detail_date" type="date" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_done_by">End Date<span class="text-danger">*</span></label>
                                <input name="form_detail_done_by" type="date" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_quantity">Quantity<span class="text-danger">*</span></label>
                                <input name="form_detail_quantity" type="text" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_order_no">Order No<span class="text-danger">*</span></label>
                                <input name="form_detail_order_no" type="text" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_remark">Remark<span class="text-danger">*</span></label>
                                <input name="form_detail_remark" type="text" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="form_detail_oum">UOM<span class="text-danger">*</span></label>
                                <input name="form_detail_oum" type="text" maxlength="100" class="form-control">
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
                    <a href="{{ route('form_detail_listing', $form->form_id) }}" class="btn btn-secondary" type="button">Cancel</a>
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
    $(document).ready(function() {
        $('#branch_country_dialcode').select2({
            templateResult: formatCountryOption,
            templateSelection: formatSelectionOption,
            dropdownAutoWidth: true,
        });

        function formatCountryOption(option) {
            if (!option.id) {
                return option.text;
            }

            var countryCode = option.id.toLowerCase();
            var countryName = option.text;
            var dialCode = $(option.element).data('dialcode');

            var $option = $(
                '<span><img src="{{ URL::asset('
                assets / images / flags / ') }}/' + countryCode + '.svg" class="img-flag" width="20" height="20" /> ' +
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
                '<span><img src="{{ URL::asset('
                assets / images / flags / ') }}/' + countryCode + '.svg" class="img-flag" width="20" height="20" /> (+' + dialCode + ')</span>'
            );

            return $option;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#company_branch_status').select2({
            minimumResultsForSearch: Infinity
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
    var company_branch_id = '{{@$post->company_branch_id ?? " "}}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        }
    });
    $('#summernote').each(function(i) {
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
                onImageUpload: function(files) {
                    Swal.fire({
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            $('.swal2-loading').html('<img class="w-100" src="' + '{{ URL::asset('
                                assets / images / image_loading.gif ') }}' + '" />');
                        },
                        animation: false,
                    });
                    var promises = [];
                    $.each(files, function(file) {
                        promises.push(sendFile(files[file], i));
                    });
                    $.when.apply(null, promises).done(function() {
                        Swal.close();
                    });
                },
                onImageUploadError: function(msg) {
                    alert('Invalid image');
                },
                onChange: function(contents, $editable) {
                    //remark: solve below problem, justify after image or hyperlink
                    var paragraph = $('.note-editable').find("p");

                    $.each(paragraph, function(index, text) {
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
        formData.append("id", company_branch_id);

        return $.ajax({
            type: 'POST',
            url: "{{route('ajax_upload_company_branch_note_image')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status) {
                    $('#summernote').eq(i).summernote('insertImage', res.data.url, function($image) {
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
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const startInput = checkbox.parentNode.parentNode.nextElementSibling.querySelector('[name$="[start_time]"]');
                const endInput = checkbox.parentNode.parentNode.nextElementSibling.querySelector('[name$="[end_time]"]');
                startInput.disabled = !checkbox.checked;
                endInput.disabled = !checkbox.checked;
            });
        });
    });
</script>
<script>
    function initAutocomplete() {
        const locationInput = document.getElementById('branch_location');
        const autocomplete = new google.maps.places.Autocomplete(locationInput);

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                console.error('No geometry for selected place');
                return;
            }

            // Update input fields with selected place details
            document.getElementsByName('company_branch_address')[0].value = place.name || '';
            document.getElementsByName('company_branch_city_name')[0].value = '';

            for (const component of place.address_components) {
                const types = component.types;

                if (types.includes('street_number')) {
                    document.getElementsByName('company_branch_address2')[0].value = component.long_name;
                }

                if (types.includes('locality')) {
                    document.getElementsByName('company_branch_city_name')[0].value = component.long_name;
                }

                if (types.includes('postal_code')) {
                    document.getElementsByName('company_branch_postcode')[0].value = component.long_name;
                }

                if (types.includes('administrative_area_level_1')) {
                    const stateName = component.long_name;
                    console.log(stateName)
                    document.getElementsByName('branch_state_name')[0].value = stateName;
                    get_branch_state_by_name(stateName);
                }

                if (types.includes('country')) {
                    const countryName = component.long_name;
                    console.log(countryName)
                    document.getElementsByName('branch_country_name')[0].value = countryName;
                    get_branch_country_by_name(countryName);
                }
            }

            $('#company_branch_latitude').val(place.geometry.location.lat());
            $('#company_branch_longitude').val(place.geometry.location.lng());
        });
    }

    function get_branch_state_by_name(state_name) {
        $.ajax({
            url: "{{ route('ajax_get_branch_state_by_name') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                state_name: state_name,
            },
            success: function(e) {
                if (e) {
                    console.log(e);
                    $("#company_branch_state_id").val(e.state_id).trigger('change');
                } else {
                    $('#company_branch_state_id').val('').trigger('change');
                }
            }
        });
    }

    function get_branch_country_by_name(country_name) {
        $.ajax({
            url: "{{ route('ajax_get_branch_country_by_name') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                country_name: country_name,
            },
            success: function(e) {
                if (e) {
                    console.log(e);
                    $('#company_branch_country_id').val(e.country_id).trigger('change');
                } else {
                    $('#company_branch_country_id').val('').trigger('change');
                }
            }
        });
    }
</script>

<script>
    function updateLabelAndDisplayImages(input, labelId, imagePreviewsId) {
        const label = document.querySelector(`label[id="${labelId}"]`);
        const imagePreviews = document.getElementById(imagePreviewsId);
        const modal = document.getElementById("upload_error");
        const maxSize = 10 * 1024 * 1024;
        var messageContainer = $("#fileSizeExceedMessage");


        if (input.files[0].size > maxSize) {
            input.value = '';
            messageContainer.text("File size exceeds the 10 MB limit.");
            $(modal).modal('show');
        } else {
            imagePreviews.innerHTML = '';

            // Update the label with the selected file name
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = `Select ${label.textContent.split(' ')[1]}`;
            }

            for (let i = 0; i < input.files.length; i++) {
                const imageUrl = URL.createObjectURL(input.files[i]);
                const image = document.createElement('img');
                image.src = imageUrl;
                image.style.maxWidth = '150px';
                image.style.maxHeight = '90px';
                image.style.marginBottom = '5px';
                image.style.cursor = 'pointer';

                image.addEventListener('click', function() {
                    showImagePreview(imageUrl);
                });

                imagePreviews.appendChild(image);
            }
        }
    }

    // Attach the event listeners
    document.addEventListener("DOMContentLoaded", function() {
        const fileInputs = document.querySelectorAll('.file-input');

        fileInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const labelId = this.getAttribute('data-label-id');
                const imagePreviewsId = this.getAttribute('data-image-previews-id');
                updateLabelAndDisplayImages(this, labelId, imagePreviewsId);
            });
        });
    });
    // Open the modal and set the modalImg source
    function showImagePreview(imageUrl) {
        var modal = document.getElementById("Modal");
        var modalImg = document.getElementById("img");
        modal.style.display = "flex";
        modalImg.src = imageUrl;
    }

    // Close the modal when the close button is clicked
    document.getElementById("closeModal").addEventListener("click", function() {
        var modal = document.getElementById("Modal");
        modal.style.display = "none";
    });
</script>
{{-- Google API --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initAutocomplete" async defer></script>
@endsection