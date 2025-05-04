@extends('layouts.master')

@section('title') Setting Banner Listing @endsection

@section('css')
    <link href="{{URL::asset('lightbox2/src/css/lightbox.css')}}" rel="stylesheet" />
    <style>
        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #img {
            margin: auto;
            padding-top: 100px;
            padding-bottom: 100px;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            max-width: 80%;
            animation-name: zoom;
            animation-duration: 0.5s;
        }

        @keyframes zoom {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        .closebtn {
            position: absolute;
            top: 5px;
            right: 35px;
            color: white !important;
            font-size: 50px !important;
            font-weight: bold !important;
            cursor: pointer;
        }

        .closebtn:hover,
        .closebtn:focus {
            color: #cccccc !important;
            text-decoration: none;
            cursor: pointer;
        }
        @media only screen and (max-width: 700px){
        #img {
            width: 100%;
        }
        }
    </style>
@endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3">Setting Banner Listing</span>
                <a href="{{route('setting_banner_add')}}" class="btn btn-sm btn-outline-success waves-effect waves-light mr-2 mb-1" ><i class="fas fa-plus"></i> Add New</a>
			</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Setting Banner</a>
					</li>
					<li class="breadcrumb-item active">Listing</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<form method="POST" action="{{ route('setting_banner_listing') }}">
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Freetext</label>
										<input type="text" class="form-control select_active" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<button type="submit" class="btn btn-primary  waves-effect waves-light mr-2" name="submit" value="search">
										<i class="fas fa-search mr-1"></i> Search
									</button>
									<button type="submit" class="btn btn-danger  waves-effect waves-light mr-2" name="submit" value="reset">
										<i class="fas fa-times mr-1"></i> Reset
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-nowrap">
						<thead class="thead-light">
							<tr>
								<th style="width: 150px">#</th>
								<th style="width: 300px">Thumbnail</th>
								<th style="width: 300px">Name</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
                                $no = $setting_banner->firstItem();
                            ?>
							@if($setting_banner->isNotEmpty())
							@foreach($setting_banner as $banner)
							<tr>
								<td>
									<b>{{ $no++ }}</b>
								</td>
								<td>
									<img src="{{ $banner->getMedia('banner_image')?->last()?->getUrl() }}" height="70" width="100" class="banner-clickable" style="cursor: pointer;background-color:rgb(215, 215, 215)">
								</td>
								<td>
								    <div class="d-flex">
                                        <div class="flex-grow-1 overflow-hidden">
										    {{ $banner->banner_name }}
                                        </div>
                                    </div>
								</td>
                                <td>
                                    <a href="{{route('setting_banner_edit', $banner->banner_id)}}" class="btn btn-sm btn-outline-primary waves-effect waves-light">Edit</a>
                                </td>
							</tr>
							@endforeach
							@else
                            <tr>
								<td>No record found.</td>
							</tr>
                            @endif
						</tbody>
					</table>
				</div>
			</div>
            {{$setting_banner->links() }}
		</div>
	</div>
</div>
<!-- End Page-content -->
<!-- Modal -->
<div id="bannerModal" class="modal">
    <span class="closebtn" style="color: white">&times;</span>
    <img src="" alt="" id="img">
</div>
<!-- End Modal -->
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('lightbox2/src/js/lightbox.js') }}"></script>
<script>
	$(document).ready(function(e) {
		//$("#user_role").hide();
		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #banner_id").val(id);
		});
	});
</script>

<script>
    lightbox.option({
      'resizeDuration': 200,
	  'height':100,
      'wrapAround': true
    })
</script>
<script>
    var modal = document.getElementById("bannerModal");
    var modalImg = document.getElementById("img");

    var images = document.querySelectorAll(".banner-clickable");

    images.forEach(function(img) {
        img.onclick = function(){
            modal.style.display = "flex";
            modalImg.src = this.src;
        }
    });

    var span = document.getElementsByClassName("closebtn")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>
@endsection
