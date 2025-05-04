@extends('layouts.master-without-nav')

@section('title') Ads Bump Recreate @endsection

@section('content')
<!-- start page title -->
@if(Session::has('success_msg'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {!! Session::get('success_msg') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Ads Bump Recreate</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Ads Bump Recreate</a>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="setting_faq_title">Faq Title</label>
                                {!! Form::select('ads_bump_day', $ads_bump_day_sel, @$post->ads_bump_day, ['class' => 'form-control'] ) !!}
                            </div>  
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection