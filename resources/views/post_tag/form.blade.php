@extends('layouts.master')

@section('title') {{ $title }} Post Tag @endsection

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
			<h4 class="mb-0 font-size-18">{{ $title }} Post Tag</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Post Tag</a>
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
<ul class="nav nav-tabs" role="tablist">
    @foreach ($lang_setting as $key)
        @if( @$key->setting_language_slug == 'en')
            <li class="nav-item">
                <a class="nav-link active" id="{{ @$key->setting_language_slug }}" href="#tag_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="tag_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>
                </a>
            </li>
        @elseif(@$key->setting_language_slug == 'cn')
            <li class="nav-item">
                <a class="nav-link" id="{{ @$key->setting_language_slug }}" href="#tag_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="tag_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" id="{{ @$key->setting_language_slug }}" href="#tag_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="tag_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>
                </a>
            </li>
        @endif
    @endforeach
</ul>
<br />
<h4 class="card-title mb-4">Post Tag Title</h4>
<div class="tab-content">
    @foreach ($lang_setting as $key)
        @if( @$key->setting_language_slug == 'en')
            <div class="tab-pane fade show active" id="tag_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="tag_name">Post Tag Name ({{@$key->setting_language_name}})</label>
                    <input id="tag_name" type="text" name="tag_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['tag_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['tag_name']} }}" maxlength="90">
                </div>
            </div>
        @elseif(@$key->setting_language_slug == 'cn')
            <div class="tab-pane fade" id="tag_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="tag_name">Post Tag Name ({{@$key->setting_language_name}})</label>
                    <input id="tag_name" type="text" name="tag_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['tag_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['tag_name']} }}" maxlength="90">
                </div>
            </div>
        @else
            <div class="tab-pane fade" id="tag_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="tag_name">Post Tag Name ({{@$key->setting_language_name}})</label>
                    <input id="tag_name" type="text" name="tag_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['tag_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['tag_name']} }}" maxlength="90">
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="row">
    <div class="col-12">
        {{-- <form method="POST" action="{{ $submit }}">
            @csrf --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Post Tag Details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            {{-- <div class="form-group">
                                <label for="tag_name">Post Tag Name</label>
                                <input id="tag_name" type="text" name="tag_name" class="form-control" value="{{ @$post->post_tag_name ?? @$post->tag_name }}">
                            </div> --}}
                            <div class="form-group">
                                <label for="tag_slug">Post Tag Slug</label>
                                <input id="tag_slug" type="text" name="tag_slug" class="form-control" value="{{ @$post->post_tag_slug ?? @$post->tag_slug }}" maxlength="90">
                            </div>
                            <div class="form-group" style="margin-bottom: 1px">
                                <label for="post_tag_status">Post Category Status</label>
                                <div>
                                    <input name="post_tag_status" type="checkbox" id="post_tag_status" switch="none" value="1" {{ @$post->post_tag_status ? 'checked' : '' }}/>
                                    <label for="post_tag_status" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a href="{{ route('post_tag_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                            </div>
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
    {{-- <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>  --}}

    <script>
        $(document).ready(function(){

            $('#tag_name').on('change keyup',function(e){
                var tag_name = $(this).val();
                var slug = $('#tag_slug').val(slugify(tag_name)).change();
            });

            function slugify(text) {
                //https://gist.github.com/codeguy/6684588
                return text
                    .toString()                     // Cast to string
                    .toLowerCase()                  // Convert the string to lowercase letters
                    .normalize('NFD')       // The normalize() method returns the Unicode Normalization Form of a given string.
                    .trim()                         // Remove whitespace from both sides of a string
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-');        // Replace multiple - with single -
            }
        })
    </script>

@endsection
