@extends('layouts.master')

@section('title') {{ $title }} Company @endsection

@section('css') 
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ $title }} Company</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Company</a>
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
                    <h4 class="card-title mb-4">Admin Details</h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="admin name">ADMIN NAME <span class="text-danger">*</span></label>
                                {!! Form::select('user_id', $admin_sel, @$post->user_id, ['class' => 'form-control', 'id' => 'user_id']) !!}
                            </div>                       
                            
                            <div class="row">
								<div class="col-lg-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
										
									</button>
									<a href="{{ route('company_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
								</div>
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
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script> 
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script> 

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> 

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script> 
    
@endsection