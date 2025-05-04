@extends('layouts.master')

@section('title') Post Tag Listing @endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3 ">Post Tag Listing</span>
			@can('news_manage')
				<a href="{{ $submit_new }}">
					<button type="button" class="btn btn-outline-success waves-effect waves-light btn-sm">
						<i class="mdi mdi-plus mr-1"></i> Add New
					</button>
				</a>
			@endcan
		</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Post Tag</a>
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
										<label for="validationCustom03">Post Category Status</label>
										{!! Form::select('post_tag_status', $post_tag_status_sel, @$search['post_tag_status'], ['class' => 'form-control select_active']) !!}
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
								<th>Tag Name</th>
								<th>Tag Slug</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($records->isNotEmpty())
							<?php $no = $records->firstItem(); ?>
							@foreach($records as $row)
							<?php 
							if ($row->post_tag_status) {
								$status = "<span class='badge badge-success' data-toggle='popover' data-trigger='focus' title='' data-content='{$row->post_tag_created}' data-original-title='Date Created'>Active</span>";
							} else {
								$status = "<span class='badge badge-danger' data-toggle='popover' data-trigger='focus' title='' data-content='{$row->post_tag_created}' data-original-title='Date Created'>Pending</span>";
							}
							?>
							<tr>
								<td>{{ $no++ }}</td>
								<td>
									{{-- {{ $row->post_tag_name }} --}}
									<ul class="list-unstyled">
										@foreach( $lang_setting as $lang)
											<li>{{ @$row->getTranslation('post_tag_name', $lang->setting_language_slug) }}</li>
										@endforeach
									</ul>
								</td>
								<td>{{ $row->post_tag_slug }}</td>
								<td>{!! $status !!}</td>
								<td>
									@can('news_manage')
										<a href="{{ route('post_tag_edit',$row->post_tag_id) }}" class="btn btn-sm btn-outline-primary waves-effect waves-light" >Edit</a>
										{{-- <a href="{{ route('post_tag_delete',$row->post_tag_id) }}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Tag"><i class="mdi mdi-trash-can font-size-18 text-danger"></i></a> --}}
										<span data-toggle='modal' data-target='#delete' data-id='{{ $row->post_tag_id }}' class='delete'><a href='javascript:void(0);' class="btn btn-sm btn-outline-danger waves-effect waves-light">Delete</a></span>
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
<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
			<form method="POST" action="{{ route('post_tag_delete') }}">
				@csrf
				<div class="modal-body">
					<h4>Delete this post tag ?</h4>
					<input type="hidden" name="post_tag_id" id="post_tag_id">
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
<script>
	$(document).ready(function(e) {
		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			$(".modal-body #post_tag_id").val(id);
		});
	});
</script>
@endsection