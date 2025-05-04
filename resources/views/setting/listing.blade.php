@extends('layouts.master')

@section('title') Master Setting Listing @endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Master Setting Listing</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Setting</a>
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
								<th>Setting Name</th>
								<th>Setting Value</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($records->isNotEmpty())
							<?php $i = 1; ?>
							@foreach($records as $row)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $row->setting_description }}</td>
								<td>{{ $row->setting_value }}</td>
								<td>
									@if($row->is_editable == 1)
									<a href="{{ route('setting_edit',$row->setting_id) }}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Setting"><i class="mdi mdi-pencil font-size-18"></i></a>
									@endif
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
			</div>
			<!-- pagination -->
			{{ $records->links() }}
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function(e) {
		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			$(".modal-body #setting_tax_id").val(id);
		});
	});
</script>
@endsection