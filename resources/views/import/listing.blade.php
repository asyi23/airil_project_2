@extends('layouts.master')

@section('title') Import Listing @endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Import Listing</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Import</a>
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
					<div class="col-sm-8">
						<form method="POST" action="{{ $submit }}">
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
					@can('user_manage')
					<div class="col-sm-4">
						<div class="text-sm-right">
							<a href="{{ route('import_add') }}" class="btn btn-success  waves-effect waves-light mt-3 mr-2">
								<i class="mdi mdi-plus mr-1"></i> Add New
							</a>
						</div>
					</div>
					@endcan
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
								<th>Import Name</th>
								<th>Import Files</th>
								<th>Car</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($records->isNotEmpty())
							<?php 	$i = $records->firstItem(); ?>
							@foreach($records as $row)
							<tr>
								<td>{{ $i }}</td>
								<td><b>{{ $row->import_name }}</b></td>
								<td>
									@if($row->getFirstMediaUrl('import_file'))<a href="{{$row->getFirstMediaUrl('import_file')}}" target="_blank"><i class="fas fa-file-csv"></i></a> @endif
									@switch($row->is_executed)
										@case(1)
											&nbsp;<span class='badge badge-success'>Imported</span>
											@break
										@default
											&nbsp;<a href="{{ route('import_execute',$row->import_id) }}" class='badge badge-primary'>Run Import</a>
									@endswitch
								
								</td>
								<td>
									{{$row->total_imported}} / {{$row->total_import}} <br/>
									{{-- @if($row->import_column_field != "" && $row->total_import != $row->total_imported)
									<a href="{{ route('import_car_detail',$row->import_id) }}" class="mr-3 text-primary" >Import into Car Detail</a>
									@endif --}}
										
								</td>

								<td>
									@if($row->import_column_field != "" && $row->total_import != $row->total_imported)
										@if($row->is_cronjob_executed == 1) 
											<span data-toggle='modal' data-target='#active' data-id='{{ $row->import_id }}' class='cronjob_status'>
												<a href="{{ route('change_cronjob_status',$row->import_id) }}" class="btn btn-sm btn-outline-success waves-effect waves-light">Active</a>
											</span>
										@else
											<span data-toggle='modal' data-target='#inactive' data-id='{{ $row->import_id }}' class='cronjob_status'>
												<a href="{{ route('change_cronjob_status',$row->import_id) }}" class="btn btn-sm btn-outline-secondary waves-effect waves-light">Inactive</a>
											</span>
										@endif
									@endif
									
								</td>

								<td>
									@if($row->is_executed == 1 && $row->total_import != $row->total_imported)
									<a href="{{ route('import_detail',$row->import_id) }}" class="mr-3 text-primary" >Link Data</a>
									@endif
									
                                    <span data-toggle='modal' data-target='#delete' data-id='{{ $row->import_id }}' class='delete'><a href='javascript:void(0);' class="btn btn-sm btn-outline-danger waves-effect waves-light">Delete</a></span>
								</td>
							</tr>
							<?php $i++; ?>
							@endforeach
							@else
							<tr>
								<td>No record found.</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
				<!-- pagination -->
				{{ $records->links() }}
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
			<form method="POST" action="{{ route('import_delete') }}">
				@csrf
				<div class="modal-body">
					<h4>Delete this import ?</h4>
					<input type="hidden", name="import_id" id="import_id">
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
			$(".modal-body #import_id").val(id);
		});
	});
</script>
@endsection
