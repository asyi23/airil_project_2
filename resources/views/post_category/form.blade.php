@extends('layouts.master')

@section('title') {{ $title }} Post Category @endsection

@section('css') 
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
        <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ $title }} Post Category</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Post Category</a>
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
<ul class="nav nav-tabs" role="tablist">
    @foreach ($lang_setting as $key => $val)
        {{-- @if( @$key->setting_language_name == 'English')
            <li class="nav-item">
                <a class="nav-link active" id="{{ @$key->setting_language_slug }}" href="#category_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="category_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>    
                </a>
            </li>
        @elseif(@$key->setting_language_name == 'Chinese')
            <li class="nav-item">
                <a class="nav-link" id="{{ @$key->setting_language_slug }}" href="#category_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="category_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>    
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" id="{{ @$key->setting_language_slug }}" href="#category_name_{{ @$key->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="category_name_{{ @$key->setting_language_slug }}" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ @$key->setting_language_name }}</span>    
                </a>
            </li>
        @endif --}}
        <li class="nav-item">
            <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="{{ @$val->setting_language_slug }}" href="#category_name_{{ @$val->setting_language_slug }}" data-toggle="tab" role="tab" aria-controls="category_name_{{ @$val->setting_language_slug }}" aria-selected="true">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">{{ @$val->setting_language_name }}</span>    
            </a>
        </li>
    @endforeach
</ul>
<br/>
<h4 class="card-title mb-4">Post Category Title</h4>
<div class="tab-content">
    @foreach ($lang_setting as $key => $val)
        {{-- @if( @$key->setting_language_name == 'English')
            <div class="tab-pane fade show active" id="category_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="category_name">Post Category Name ({{ @$key->setting_language_name }})</label>
                    <input id="category_name" type="text" name="category_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['category_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['category_name']} }}" maxlength="90">
                </div>
            </div>
        @elseif( @$key->setting_language_name == 'Chinese')
            <div class="tab-pane fade" id="category_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="category_name">Post Category Name ({{ @$key->setting_language_name }})</label>
                    <input id="category_name" type="text" name="category_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['category_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['category_name']} }}" maxlength="90">
                </div>
            </div>
        @else
            <div class="tab-pane fade" id="category_name_{{ @$key->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$key->setting_language_slug }}">
                <div class="form-group">
                    <label for="category_name">Post Category Name ({{ @$key->setting_language_name }})</label>
                    <input id="category_name" type="text" name="category_name_{{ @$key->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$key->setting_language_slug]['category_name']} ?? @$post->{$arr_title[$key->setting_language_slug]['category_name']} }}" maxlength="90">
                </div>
            </div>
        @endif --}}
        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="category_name_{{ @$val->setting_language_slug }}" role="tabpanel" aria-labelledby="{{ @$val->setting_language_slug }}">
            <div class="form-group">
                <label for="category_name">Post Category Name ({{ @$val->setting_language_name }})</label>
                <input id="category_name" type="text" name="category_name_{{ @$val->setting_language_slug }}" class="form-control" value="{{ @$post->{$arr_title[$val->setting_language_slug]['category_name']} ?? @$post->{$arr_title[$val->setting_language_slug]['category_name']} }}" maxlength="90">
            </div>
            <div class="form-group">
                <label>Post Category Label Image</label>
                @if (@$post->post_category_label_image[$val->setting_language_id])
                    <a href="{{ $post->post_category_label_image[$val->setting_language_id] }}" class="iframe" data-fancybox-type="image">
                        <br/>
                        <img src="{{ $post->post_category_label_image[$val->setting_language_id] }}" class="img-fluid" width="200">	
                    </a>
                @endif
                <input type="file" name="post_category_label_image_{{ @$val->setting_language_slug }}" class="form-control" />
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-12">
        {{-- <form method="POST" action="{{ $submit }}">
            @csrf --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Post Category Details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            {{-- <div class="form-group">
                                <label for="post_category_name">Post Category Name</label>
                                <input id="category_name" type="text" name="post_category_name" class="form-control" value="{{ @$post->post_category_name ?? @$post->category_name }}">
                            </div> --}}
                            <div class="form-group">
                                <label for="category_slug">Post Category Slug</label>
                                <input id="category_slug" type="text" name="category_slug" class="form-control" value="{{ @$post->post_category_slug ?? @$post->category_slug }}">
                            </div>
                            <div class="form-group">
                                <label for="post_category_priority">Post Category Priority</label>
                                {{-- <input type="text" name="post_category_priority" class="form-control" value="{{ @$post->post_category_priority ?? @$post->category_priority }}"> --}}
                                <input id="input-repeat" name="post_category_priority" min="1" step="1" class="form-control input-mask" data-inputmask="'mask': '9', 'repeat': 9, 'greedy': false" value="{{ @$post->post_category_priority ?? @$post->post_category_priority }}">
                            </div>
                            <div class="form-group" style="margin-bottom: 1px">
                                <label for="post_category_status">Post Category Status</label>
                                <div>
                                    <input name="post_category_status" type="checkbox" id="post_category_status" switch="none" value="1" {{ @$post->post_category_status ? 'checked' : '' }}/>
                                    <label for="post_category_status" data-on-label="On" data-off-label="Off"></label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label>Post Category Label Image</label>
                                @if (optional(@$post_category)->hasMedia('post_category_label'))
                                    <a href="{{ $post_category->post_category_label->getUrl() }}" class="iframe" data-fancybox-type="image">
                                        <br/>
                                        <img src="{{ $post_category->post_category_label->getUrl() }}" class="img-fluid" width="200">	
                                    </a>
                                @endif
                                <input type="file" name="post_category_label_image" class="form-control" />
                            </div> --}}
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('post_category_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
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

    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>

    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js')}}"></script>

    <!-- form mask init-->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js')}}"></script>

    <script>
        $(document).ready(function(){

            $('#category_name').on('change keyup',function(e){
                var category_name = $(this).val();
                console.log(category_name);
                var slug = $('#category_slug').val(slugify(category_name)).change();
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


            $(".iframe").fancybox({
            maxWidth: 800,
            maxHeight: 500,
            fitToView: true,
            width: '100%',
            height: '100%',
            autoSize: false,
            closeClick: false,
            openEffect: 'elastic',
            closeEffect: 'elastic',
            afterLoad: function () {
                if (this.type == "iframe") {
                    $.extend(this, {
                        iframe: {
                            preload: false
                        }
                    })
                }
            }
        });
        })
    </script>
    
@endsection