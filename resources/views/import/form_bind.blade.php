@extends('layouts.master')

@section('title') {{ $title }} Import @endsection

@section('css') 
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
@endsection

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
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Import Data Bind</h4>
                        <?php $no = 1; ?>
                        @foreach(unserialize($import_detail->column) as $key => $row)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >Column {{$no++}}</label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Column Field {{$no}}" required="" value="{{$row}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >&nbsp;</label>
                                        <select name="column_{{ $key }}" class="form-control select2">
                                            <option value="">Please select column</option>
                                            <optgroup label="Car Setting">
                                                @foreach($car_column_sel as $column => $val)
                                                    <option value="{{ $column }}" 
                                                        @if(@$post->{'column_' . $key}) 
                                                            {{ $column == @$post->{'column_' . $key} ? 'selected' : '' }} 
                                                        @else  
                                                            {{ $column == @$import_column_detail['column_' . $key] ? 'selected' : '' }} 
                                                        @endif>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                            </optgroup>

                                            <optgroup label="Specification">
                                                @foreach($spec_sel as $column => $val)
                                                    <option value="{{ $column }}" 
                                                        @if(@$post->{'column_' . $key}) 
                                                            {{ $column == @$post->{'column_' . $key} ? 'selected' : '' }}
                                                        @else 
                                                            {{ $column == @$import_column_detail['column_' . $key] ? 'selected' : '' }} 
                                                        @endif>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                            
                                            <optgroup label="Create New Specification">
                                                @foreach($create_new_spec_sel as $column => $val)
                                                    <option value="{{ $column . '_' . $row }}"
                                                         @if(@$post->{'column_' . $key}) 
                                                            {{ $column . '_' . $row == @$post->{'column_' . $key} ? 'selected' : '' }} 
                                                        @else  
                                                            {{ $column . '_' . $row == @$import_column_detail['column_' . $key] ? 'selected' : '' }} 
                                                        @endif>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                            </optgroup>

                                            <optgroup label="Equipment">
                                                @foreach($equipment_sel as $column => $val)
                                                    <option value="{{ $column }}"
                                                         @if(@$post->{'column_' . $key}) 
                                                            {{ $column == @$post->{'column_' . $key} ? 'selected' : '' }} 
                                                        @else 
                                                            {{ $column == @$import_column_detail['column_' . $key] ? 'selected' : '' }} 
                                                        @endif>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                            </optgroup>

                                            <optgroup label="Create New Equipment">
                                                @foreach($create_new_equipment_sel as $column => $val)
                                                    <option value="{{ $column . '_' . $row }}"
                                                        @if(@$post->{'column_' . $key}) 
                                                            {{ $column . '_' . $row == @$post->{'column_' . $key} ? 'selected' : '' }} 
                                                        @else 
                                                            {{ $column . '_' . $row == @$import_column_detail['column_' . $key] ? 'selected' : '' }} 
                                                        @endif>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                            </optgroup>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('import_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
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
    
@endsection
