@extends('layouts.master')

@section('title') Post Listing @endsection

@section('css')
        <link href="{{URL::asset('lightbox2/src/css/lightbox.css')}}" rel="stylesheet" />
@endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"> <span class="mr-3 ">Post Listing</span>
				@can('news_manage')
					<a href="{{ route('post_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
						<i class="mdi mdi-plus mr-1"></i> Add New
					</a>
				@endcan
			</h4>

			<div class="page-title-right d-none d-sm-block">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Post</a>
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
						<form method="POST" action="{{ $submit }}">
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Freetext</label>
										<input type="text" class="form-control select_active" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Post Category</label>
										{!! Form::select('post_category_id', $post_category_sel, @$search['post_category_id'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Post Template</label>
										{!! Form::select('post_template_id', $post_template_sel, @$search['post_template_id'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								{{-- <div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Post Tag</label>
										{!! Form::select('post_tag', $post_tag_sel, @$search['post_tag'], ['class' => 'form-control select_active']) !!}
									</div>
								</div> --}}
								<div class="col-md-4">
									<label for="post_tag">Company</label>
									<select name="post_tag" class="form-control select2 select2_active" id="post_tag">
										@foreach($post_tag_sel as $key => $val)
											<option value="{{$key}}" {{ $key == @$search['post_tag'] ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Post Status</label>
										{!! Form::select('post_status', [''=>'Please select status']+$post_status_sel, @$search['post_status'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Order By Date</label>
										{!! Form::select('post_order_by', $post_order_by_sel, @$search['post_order_by'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Post Pinned</label>
                                        {!! Form::select('post_pinned', $post_pinned_sel, @$search['post_pinned'], ['class' => 'form-control select_active']) !!}
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
								<th scope="col" style="width: 70px;">#</th>
								<th>Thumbnail</th>
								<th>Title</th>
								{{-- <th>Author</th> --}}
								<th>Category</th>
								{{-- <th>Template</th>
								<th>Status</th> --}}
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($records->isNotEmpty())
							<?php $no = $records->firstItem(); ?>
							@foreach($records as $row)
							<?php
							$status = '';
							$assign_permission = '';
							$action = "<a href='".route('post_edit',$row->post_id)."' class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>";
							$action .= "<a href='".route('post_edit',$row->post_id)."' class='btn btn-sm btn-outline-primary waves-effect waves-light' data-post_id='".$row->post_id."' data-toggle='modal' data-target='.edit-status'>Edit Status</a>";
							switch ($row->post_status) {
								case 'published':
									$status = "<span class='badge badge-success font-size-11'>Published</span>";
									break;
								case 'draft':
									$status = "<span class='badge badge-warning'>Draft</span>";
									break;
								case 'deleted':
									$status = "<span class='badge badge-danger'>Deleted</span>";
									break;
							}
							$tag_list = "";
							if ($row->post_tag_link) {
								foreach ($row->post_tag_link as $tag) {
									$tag_list .= "<span class='badge badge-soft-dark' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='{$tag->TagName}'>#{$tag->TagName}</span> ";
								}
							}
							?>
							<tr>
								<td>{{ $no++ }}</td>
								<td>
									{{-- <a href="{{ $row->getFirstMediaUrl('post_thumbnail') }}" data-lightbox="{{$row->getFirstMediaUrl('post_thumbnail')}}">
										<img src="{{ $row->getFirstMediaUrl('post_thumbnail') }}" height="70" width="100">
									</a> --}}

                                    @if(!empty($row->post_cover_url))
                                        <a href="{{ $row->post_cover_url }}" data-lightbox="{{$row->post_cover_url}}">
                                            <img src="{{ $row->post_cover_url }}" width="150"> {{-- height="100" --}}
                                        </a>
                                    @endif
								</td>
								<td class="post-title-tag">
                                    <div class="d-flex">
                                        <div class="my-auto">
                                            <b>{{ Str::limit($row->title, 50) }}</b>
                                        </div>

                                        <div class="ml-1">
                                            <button style="display: {{ ($row->is_pinned) ? 'block' : 'none'}};" id="btn_unpin_{{$row->post_id}}" class="btn btn_unpin text-danger p-0 font-size-18" onclick="pin_post({{$row->post_id}},'unpin')"><i class="mdi mdi-pin-off"></i></button>
                                            <button style="display: {{ ($row->is_pinned) ? 'none' : 'block'}};" id="btn_pin_{{$row->post_id}}" class="btn btn_pin p-0 font-size-18" onclick="pin_post({{$row->post_id}},'pin')"><i class="mdi mdi-pin"></i></button>
                                        </div>
                                    </div>

                                    <small>
                                        @if($row->post_status == 'published' || $row->post_status == 'draft')
                                            <a href="{{ $row->post_preview_url }}"
                                               target="_blank">{{ Str::limit($row->post_slug, 50) }}</a>
                                        @else {{ Str::limit($row->post_slug, 50) }}
                                        @endif
                                    </small>
                                    <br>
                                    {!! $tag_list !!}
									<br><br>

									@if($row->hasMedia('post_media'))
										@foreach ($row->getMedia('post_media') as $key => $thumbnail)
											@if(@$key<3 && @$thumbnail->getCustomProperty('post_media_status') == 1)
												@if(@$thumbnail->custom_properties['post_media_section'] == 'image')
												<a href="{{ $thumbnail->getUrl('full') }}" data-lightbox="{{$row->post_id}}">
													<img src="{{ $thumbnail->getUrl('thumb') }}" height="67"> {{-- width="90" --}}
												</a>
												{{-- @elseif(@$thumbnail->custom_properties['post_media_section'] == 'video')

													<video src="{{ $thumbnail->getUrl() }}" height="67"> --}}

												@endif
											@endif
											<?php $key++ ?>
										@endforeach
									@endif
								</td>
								<td>{{ ucwords($row->post_template->post_template_name ?? '') }}
									<br/>{{ ucwords($row->post_category->post_category_name ?? '') }}
									<br/>{{ ucwords($row->author_name ?? '') }}

								</td>
								<td>
									<b>Created</b> <br/>{{ date('Y-m-d H:i:s', strtotime($row->post_created)) }}<br>
									<b>Updated</b> <br/>{{ date('Y-m-d H:i:s', strtotime($row->post_updated)) }}<br>
									{!! $status !!}
								</td>
								<td>
									@can('news_manage')
										<a href="{{route('post_edit',$row->post_id)}}" class="btn btn-sm btn-outline-primary waves-effect waves-light">Edit</a>
										@if($row->post_status!='deleted')
											<span data-toggle='modal' data-target='#delete' data-id='{{ $row->post_id }}' class='delete'><a href='javascript:void(0);' class="btn btn-sm btn-outline-danger waves-effect waves-light">Delete</a></span>
										@endif
									@endcan
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
			<!-- pagination -->
			{{ $records->links() }}
		</div>
	</div>
</div>
<!-- Modal edit status -->
<div class="modal fade edit-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document" id="edit_status">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Post Status</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="{{ $submit_modal }}">
			@csrf
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group">
							<label for="product_type_id">Post Status</label>
							{{-- {!! Form::select('transaction_status_id', $transaction_status_sel, @$search['transaction_status_id'], ['class' => 'form-control select_active']) !!} --}}
							{!! Form::select('post_status', $post_status_sel, '', ['class' => 'form-control select_active', 'required']) !!}
						</div>
					</div>
					<input type="hidden" name="post_id">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
			<form method="POST" action="{{ route('post_delete') }}">
				@csrf
				<div class="modal-body">
					<h4>Delete this post ?</h4>
					<input type="hidden" name="post_id" id="post_id">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
    	</div>
    </div>
</div>
<!-- End Modal -->
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('lightbox2/src/js/lightbox.js') }}"></script>
<script>
    lightbox.option({
      'resizeDuration': 200,
	  'height':100,
      'wrapAround': true
    })
</script>
<script>
	$(document).ready(function(e) {
		$('.edit-status').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);

			var modal = $(this);
			var post_id = button.data('post_id');
			var post_status = button.data('post_status');

			modal.find(".modal-body select[name='post_status']").val(post_status);
			modal.find(".modal-body input[name='post_id']").val(post_id);
		});

		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id)
			$("#delete .modal-body #post_id").val(id);
		});
	});

	function pin_post(post_id, action){

        document.getElementById('btn_pin_'+post_id).disabled = true;
        document.getElementById('btn_unpin_'+post_id).disabled = true;

        $.ajax({
            type: 'POST',
            url: "{{route('ajax_pin_post')}}",
            data: {
                post_id: post_id,
                action: action,
                _token: '{{csrf_token()}}'
            },
            success: function(respond) {
                if(respond.status){
                    if(action==="pin"){
                        $('.btn_unpin').css("display", "none");
                        $('.btn_pin').css("display", "block");

                        document.getElementById('btn_pin_'+post_id).style.display = 'none';
                        document.getElementById('btn_unpin_'+post_id).style.display = 'block';
                    }else{
                        $('.btn_unpin').css("display", "none");
                        $('.btn_pin').css("display", "block");
                    }

                    document.getElementById('btn_pin_'+post_id).disabled = false;
                    document.getElementById('btn_unpin_'+post_id).disabled = false;
                }
            }
        });
    }
</script>
@endsection
