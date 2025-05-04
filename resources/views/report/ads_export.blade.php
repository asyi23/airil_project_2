@extends('layouts.master')

@section('title') Ads Export  @endsection

@section('css') 
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">ADS EXPORT</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					{{-- <li class="breadcrumb-item">
						<a href="javascript: void(0);">Remove User</a>
					</li>
					<li class="breadcrumb-item active">Form</li> --}}
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
        <form method="POST" action="{{ route('ads_export') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
    
                                {{-- <select name="user_id" class="form-control select2">
                                    @foreach($bd_sel as $key => $val)
                                        <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }} >{{$val}}</option>
                                    @endforeach
                                </select> --}}
                                {!! Form::select('ads_export_sel', $export_sel, @$post->bd_sel, ['class' => 'form-control']) !!}
                            </div>                       
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="submit" value="export">
                                    <i class="mdi mdi-export mr-1"></i>Export
                                </button>
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
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> 
@endsection