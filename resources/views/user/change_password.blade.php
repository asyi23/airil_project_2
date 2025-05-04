@extends('layouts.master')

@section('title') {{ $title }}  @endsection

@section('css')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ $title }}</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">User</a>
					</li>
					<li class="breadcrumb-item active">Change Password</li>
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
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{$submit}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Password</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="old_password">Old Password <span class="text-danger">*</span></label>
                                <div id="old_password" class="input-group">
                                    <input name="old_password" type="password" id="old-password-input" class="form-control" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-old-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="new_password">New Password <span class="text-danger">*</span><span
                                    class="bx bxs-info-circle info-tooltip" data-toggle="tooltip"
                                    data-placement="top" title="Minimum 8 character"></span></label>
                                <div id="new_password" class="input-group" >
                                    <input name="new_password" type="password" class="form-control" id="new-password-input" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-new-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password <span
                                    class="text-danger">*</span><span class="bx bxs-info-circle info-tooltip"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Minimum 8 character"></span></label>
                                <div id="confirm_password" class="input-group">
                                    <input name="confirm_password" type="password" class="form-control" id="confirm-password-input" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text  show-hide-confirm-password">
                                            <i class="bx bxs-show font-size-15"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

    <script>
        $(document).ready(function(e) {
            //$("#user_role").hide();
            $('#user_type').on('change', function() {
                if(this.value == 1){
                    $("#user_role").show();
                } else {
                    $("#user_role").hide();
                }
            });
        });
    </script>
    <script>
        $('#old_password .show-hide-old-password').on('click', function() {
            var input = $('#old-password-input');
            var icon = $('.show-hide-old-password i');

            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
                icon.removeClass('bx bxs-show').addClass('bx bxs-hide');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bx bxs-hide').addClass('bx bxs-show');
            }
        });
        $('#new_password .show-hide-new-password').on('click', function() {
            var input = $('#new-password-input');
            var icon = $('.show-hide-new-password i');

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
