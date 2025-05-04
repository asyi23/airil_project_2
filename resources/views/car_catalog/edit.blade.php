@extends('layouts.master')

@section('title') {{ $title }} Catalog @endsection

@section('css')

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

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fancybox.min.css')}}">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ $title }} Catalog</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Catalog</a>
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
<form method="POST" action="{{ $submit }}">
@csrf
<div class="row">
    <div class="col-12">
        {{-- <form method="POST" action="{{ $submit }}">
            @csrf --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Catalog Details</h4>
                    <div class="row">
                        @if(!empty($merchant_company))
                        <div class="col-sm-6">
							<label for="company_id">Company</label>
                                <input name="type" id="type" type="text" class="form-control select2" value="{{ $merchant_company }}" readonly>
						</div>                       
                        @else
                        <div class="col-sm-6">
							<label for="company_id">Company</label>
							<select name="company_id" class="form-control select2" id="company_id">
								@foreach($company as $key => $val)
									<option value="{{$key}}" {{ $key == @$user->user_company->company_id ?? @$user->join_company->company_id ? 'selected' : '' }}>{{$val}}</option>
								@endforeach
							</select>
						</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="car_catalog_name">Catalog Name</label>
                                <input id="car_catalog_name" type="text" name="car_catalog_name" class="form-control" value= "{{ $catalog->car_catalog_name }}">
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="car_catalog_type">Catalog Type</label>
                                <select name="car_catalog_type" class="form-control select2" id="car_catalog_type" value= "{{ $catalog->car_catalog_type }}">>
                                @foreach($catalog_type_dropdown as $key => $val)
                                    <option value="{{$key}}" {{ $key == @$catalog->car_catalog_type ? 'selected' : '' }}>{{$val}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control company-custom-checkbox" id="field_ads_check_box_disabled">
                        <input type="checkbox" checked class="company-custom-control-input"
                            name="is_default" id="is_default"
                            value="0" {{ @$post->is_registration_card ? 'checked' : '' }}>
                            <label class="company-custom-control-label" for="is_default">
                            Set as default</label>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pricelist Picture <span class="text-danger">*</span></h4>
                    <div class="row">
                        <div class="col-sm-12 car-images-filepond">
                            <input id="upload-car-images" class="filepond car-images" name="car_images[]"
                            data-allow-reorder="true" type="file" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('catalog_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</div>
</form>
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
    <script>
        $(document).ready(function(e) {
            $('#car_catalog_type').select2({
            minimumResultsForSearch: Infinity
        });       
        });
    </script>
@endsection
