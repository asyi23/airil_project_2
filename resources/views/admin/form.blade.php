@extends('layouts.master')

@section('title') {{ $title }} Admin @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
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
    #profileImg{
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
    #profileImg{
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
            <h4 class="mb-0 font-size-18">{{ $title }} Admin</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Admin</a>
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
                <h4 class="card-title mb-4">Admin Access</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_email">Email<span class="text-danger">*</span></label>
                            <input name="user_email" type="email" maxlength="90" class="form-control" value="{{ @$post->user_email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($action == 'edit')
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                                <div id="password" class="input-group">
                                    <input name="password" type="password" id="password-input" class="form-control" value="xxxxxxxx">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                                <div id="confirm_password" class="input-group">
                                    <input name="confirm_password" type="password" id="confirm-password-input" class="form-control" value="xxxxxxxx">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-confirm-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($action == 'add')
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                                <div id="password" class="input-group">
                                    <input name="password" type="password" id="password-input" class="form-control" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password<span class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip" data-toggle="tooltip" data-placement="top" title="Minimum 8 character"></span></label>
                                <div id="confirm_password" class="input-group">
                                    <input name="confirm_password" type="password" id="confirm-password-input" class="form-control" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-confirm-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Admin Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_fullname">Full Name<span class="text-danger">*</span></label>
                            <input name="user_fullname" type="text" maxlength="90" class="form-control" value="{{ @$post->user_fullname}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="combined_input">Mobile No.<span class="text-danger">*</span></label>
                            <div class="combined-input">
                                <select id="user_country_dialcode" name="user_country_dialcode" class="form-control combined-left select2">
                                    @foreach ($countries as $countryAbb => $countryData)
                                    <option value="{{ $countryAbb }}" @if($countryAbb == @$post->user_country_dialcode) selected @elseif ($countryAbb == @$country_abb) selected @elseif ($countryAbb === 'MY') selected @endif  data-dialcode="{{ $countryData['dialcode'] }}">
                                            {{ $countryData['country_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="gap"></div>
                                <input id="user_input-mask" oninput="validateInput(this)" name="user_mobile" class="form-control input-mask text-left combined-right" maxlength="45" data-inputmask="'mask': '9999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{@$post->user_mobile}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($action ==='add')
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container" id="user_role">
                            <label class="control-label">Admin Role</label>
                            {!! Form::select('user_role_id', $user_role_sel, old('user_role_id', @$post->user_role_id ?: 2), ['class' => 'form-control select2', 'id' => 'user_role_id']) !!}
                        </div>
                    </div>
                    @endif
                    @if ($action ==='edit')
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container" id="user_role">
                            <label class="control-label">Admin Role</label>
                            {!! Form::select('user_role_id', $user_role_sel, isset($post->user_role_id) ? $post->user_role_id :@$user->roles , ['class' => 'form-control select2', 'id' => 'user_role_id']) !!}
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-6">
                        <div class="form-group custom-dropdown-container">
                            <label class="control-label">Gender</label>
                            {!! Form::select('user_gender', $user_gender_sel, @$post->user_gender, ['class' => 'form-control select2', 'id'=>'user_gender']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_dob">Date of Birth</label>
                            <div class="input-group">
                                <input name="user_dob" class="form-control input-mask" id="datepicker" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true"data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" value="{{ @$post->user_dob}}" placeholder="yyyy-mm-dd">
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_nric">NRIC</label>
                            <input id="user_nric" name="user_nric" class="form-control input-mask text-left" data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{ @$post->user_nric}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_nationality">Nationality</label>
                            <input name="user_nationality" type="text" class="form-control" value="{{ @$post->user_nationality ?? 'Malaysian' }}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Address Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_address">Address 1</label>
                            <input name="user_address" type="text" maxlength="90" class="form-control" value="{{ @$post->user_address}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_address2">Address 2</label>
                            <input name="user_address2" type="text" maxlength="90" class="form-control" value="{{ @$post->user_address2 }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="user_postcode">Postcode</label>
                            <input name="user_postcode" maxlength="45" class="form-control input-mask text-left" data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true" style="text-align: right;" value="{{ @$post->user_postcode}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="user_city">City</label>
                            <input name="user_city" type="text" class="form-control" value="{{ @$post->user_city}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="user_state">State</label>
                            {!! Form::select('user_state_id',@$user_state_sel, @$post->user_state_id ?? [''=>'Please select state'],['class' => 'form-control state select2','id' => 'user_state_id'])!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($action ==='edit')
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profile Picture</h4>
                <div class="row">
                    <div class="col-sm-12">
                        @php
                            $user_profile = $user->getMedia('user_profile_picture')->last();

                        @endphp
                        <div id="userProfileContainer"style="margin-bottom: 10px; display: {{ $user_profile ? 'block' : 'none' }};width:100px;height:100px;overflow:hidden;" >
                            <img id="userProfilePreview"
                            src="{{$user_profile ? $user_profile->getUrl() : ''  }}"
                            height="100" width="100" style="cursor: pointer;" class="profile-clickable">
                        </div>
                        <div class="input-group">
                            <input type="file" class="custom-file-input" style="width: 100%;"
                                name="user_profile_picture" id="user_profile_picture" accept=".jpeg,.png,.jpg,.gif" onchange="updateImagePreview(this);updateLabelWithFileName(this)" multiple
                                @error('user_profile_picture') is-invalid @enderror>
                            <label class="custom-file-label"
                                id="profile_label"
                                style=" overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;"
                                for="exampleInputFile">Select Profile Picture
                            </label>
                        </div>
                    </div>
                    @error('user_profile_picture')
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
    <div class="col-xl-3 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profile Picture</h4>
                <div class="row">
                    <div id="imagePreviews" style="margin-bottom: 10px;margin-left:12px;" ></div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" style="width: 100%; margin-bottom:10px;"
                                    name="user_profile_picture" id="user_profile_picture" accept=".jpeg,.png,.jpg,.gif" onchange="updateImageCountAndPreviews(this)" multiple
                                    @error('user_profile_picture') is-invalid @enderror>
                                <label class="custom-file-label"
                                    id="user_profile_picture"
                                    style=" overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;"
                                    for="exampleInputFile">Select Profile Picture</label>
                            </div>
                        </div>
                    </div>
                    @error('user_profile_picture')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                        <a href="{{ route('admin_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{{-- Modal --}}
<div id="profileModal" class="modal">
    <span class="closebtn" id="closeModal1" style="color: white">&times;</span>
    <img src="" alt="" id="profileImg">
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
    $(document).ready(function () {
        $('#user_gender').select2({
        minimumResultsForSearch: Infinity
    });
    });
    $(document).ready(function () {
        $('#user_role_id').select2({
        minimumResultsForSearch: Infinity
    });
    });
</script>
<script>
    function updateImagePreview(input) {
        const preview = document.getElementById('userProfilePreview');
        const container = document.getElementById('userProfileContainer');
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
    const label = document.querySelector('label[id = "profile_label"]');
    if (input.files.length > 0) {
        label.textContent = input.files[0].name;
    } else {
        label.textContent = "Select Profile Picture";
    }
}
</script>
<script>
    var Profilemodal = document.getElementById("profileModal");
    var ProfilemodalImg = document.getElementById("profileImg");

    var Profileimages = document.querySelector(".profile-clickable");

    Profileimages.onclick = function(){
        Profilemodal.style.display = 'flex';
        ProfilemodalImg.src = this.src;
    }

    var profileCloseButton = document.getElementById("closeModal1");
    profileCloseButton.onclick = function() {
        Profilemodal.style.display = "none";
    }
</script>
<script>
    function updateLabelWithFileName1(input) {
        const label = document.querySelector('label[id = "user_profile_picture"]');
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = "Select Profile Picture";
        }
    }
    function updateImageCountAndPreviews(input) {
        const imagePreviews = document.getElementById("imagePreviews");
        const modal = document.getElementById("upload_error");
        const maxSize = 10 * 1024 * 1024;
        if (input.files[0].size > maxSize) {
            input.value = '';
            $(modal).modal('show');
        }else{
            imagePreviews.innerHTML = "";
            updateLabelWithFileName1(input);
            for (let i = 0; i < input.files.length; i++) {
                const imageUrl = URL.createObjectURL(input.files[i]);
                const image = document.createElement("img");
                image.src = URL.createObjectURL(input.files[i]);
                image.style.maxWidth = '100px';
                image.style.maxHeight = '100px';
                image.style.cursor = "pointer";

                image.addEventListener('click', function () {
                        showImagePreview(imageUrl);
                });

                imagePreviews.appendChild(image);
            }
        }
    }
    function showImagePreview(imageUrl) {
            const modal = document.getElementById("profileModal");
            const modalImage = document.getElementById("profileImg");

            modal.style.display = "flex";
            modalImage.src = imageUrl;

            const closeButton = document.querySelector("#closeModal1");
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
<script>
    $(document).ready(function () {
        $('#user_country_dialcode').select2({
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
    $(document).ready(function(e) {
        $('.state').on('change', function() {
            var state_id = $(this).val();
            var state_type = this.id;

            if (state_type == 'user_state_id') {
                city_type = '#user_city_id';
            }

            $(city_type).html('');
            $(city_type).attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_city_sel')}}",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if (e.status) {
                        $(city_type).attr('disabled', false);
                        $(city_type).append('<option value>Please select city</option>');
                        $.each(e.data, function(k, v) {
                            $(city_type).append('<option value=' + k + '>' + v + '</option>');
                        });
                    }
                }
            });
        });

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
    $('#password .show-hide-password').on('click', function() {
        var input = $('#password-input');
        var icon = $('.show-hide-password i');

        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            icon.removeClass('bx bxs-show').addClass('bx bxs-hide');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bx bxs-hide').addClass('bx bxs-show');
        }
    });

    $('#confirm_password .show-hide-confirm-password').on('click', function() {
        var input = $('#confirm-password-input');
        var icon = $('.show-hide-confirm-password i');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            icon.removeClass('bx bxs-show').addClass('bx bxs-hide');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bx bxs-hide').addClass('bx bxs-show');
        }
    });
</script>
@endsection
