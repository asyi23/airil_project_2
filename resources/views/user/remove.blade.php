@extends('layouts.master')

@section('title') Remove User Permanently @endsection

@section('css') 
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Remove User Permanently</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Remove User</a>
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
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ $submit }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 mb-2 mb-md-0">
							{!! Form::select('user_type_id', $user_type_sel, @$post['user_type_id'], ['class' => 'form-control select_active', 'id' => 'user_type_id']) !!}
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select name="user_id" class="form-control select2 select2_active" id="user_id">
									{{-- <option value="">Please select user</option> --}}
										@foreach($get_user_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$post['user_id'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									
									{{-- <optgroup label="Dealer">
										@foreach($get_dealer_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$post['user_id'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									</optgroup>
									<optgroup label="Sales Agent">
										@foreach($get_sales_agent_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$post['user_id'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									</optgroup>
									<optgroup label="Broker">
										@foreach($get_broker_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$post['user_id'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
                                    </optgroup>
                                    <optgroup label="Private User">
										@foreach($get_private_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$post['user_id'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									</optgroup> --}}
                                </select>
                            </div>                       
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" name="submit" value="search" class="btn btn-primary waves-effect waves-light mr-1">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> 
    <script>
        $(document).ready(function(e) {
            $('#user_type_id').on('change', function() {
                // $('#user_id').html('<option value="">Please select User</option>');
                $('#user_id').html('');
                $('#user_id').attr('disabled',true);
                $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user_type_sel')}}",
                    data: {
                        user_type_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {
                        if (e.status == true) {
                            $('#user_id').attr('disabled',false);
                            $('#user_id').append('<option value="">Please select user</option>');

                            $.each(e.data, function(key, value) {
                                if(key != ''){
                                    $('#user_id').append('<option value="' + key + '">' + value + '</option>');
                                }
                            });
                            $('#user_id').removeAttr('disabled');
                        }
                    }
                });
            });
        });

    </script>
@endsection