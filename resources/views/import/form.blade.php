@extends('layouts.master')

@section('title') {{ $title }} Import @endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ $title }} Import</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Import</a>
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
        <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Import Details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="import_name">Import Name</label>
                                <input type="text" name="import_name" class="form-control" value="{{ @$post->import_name }}" >
                            </div>     
                            <div class="form-group">
                                <label for="import_file">Import File</label>
                                <div class="custom-file">
                                    <input type="file" name="import_file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a href="{{ route('import_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
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
    
    <script>
        $(document).ready(function() {
            //$("#user_role").hide();
            $('#customFile').on('change', function(e) {
                var fileName = e.target.files[0].name;
                //var output = fileName.substr(0, fileName.lastIndexOf('.')) || fileName;

                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
@endsection
