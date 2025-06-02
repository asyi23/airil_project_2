@extends('layouts.master')

@section('title') Catalog Listing @endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3">Catalog Listing</span>
				<a href="{{ route('catalog_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
					<i class="mdi mdi-plus mr-1"></i> Add New
				</a>
			</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Catalog</a>
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
						<form method="POST" action="{{ route('admin_listing') }}">
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Freetext</label>
										<input type="text" class="form-control select_active" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
									</div>
								</div>
								<div class="col-md-4">
									<label for="company_id">Catalog Type</label>
									<select name="company_id" class="form-control select2" id="company_id">
										@foreach($catalog_type as $key => $val)
										<option value="{{$key}}" {{ $key == @$user->user_company->company_id ?? @$user->join_company->company_id ? 'selected' : '' }}>{{$val}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Company</label>
										{!! Form::select('company_id', $company, @$search['company_id'], ['class' => 'form-control select_active', 'id' => 'company_id']) !!}
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
								<th>#</th>
								<th>Catalog Name</th>
								@if($user->user_type->user_type_group == 'administrator')
								<th>Company</th>
								@endif
								<th>Catalog Type</th>
								<th>PDF</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = $car_catalog->firstItem();
							?>
							@if($car_catalog->isNotEmpty())
							@foreach($car_catalog as $catalog)
							<?php
							if ($catalog->car_catalog_type == 'brochure') {
								if ($catalog->car_catalog_id == $catalog->company->car_catalog_brochure) {
									$default = "<span class='badge badge-primary font-size-11'>Default</span>";
								} else {
									$is_default = "<span data-toggle='modal' data-target='#default' data-id='" . $catalog->car_catalog_id . "' class='default'><a href='javascript:void(0);' class='btn btn-sm btn-outline-success waves-effect waves-light'>Set as Default</a></span>";
								}
							} else {
								if ($catalog->car_catalog_id == $catalog->company->car_catalog_pricelist) {
									$default = "<span class='badge badge-primary font-size-11'>Default</span>";
								} else {
									$is_default = "<span data-toggle='modal' data-target='#default' data-id='" . $catalog->car_catalog_id . "' class='default'><a href='javascript:void(0);' class='btn btn-sm btn-outline-success waves-effect waves-light'>Set as Default</a></span>";
								}
							}
							?>
							<tr>
								<td>
									<b>{{ $no++ }}</b>
								</td>
								<td>
									{{ $catalog->car_catalog_name }}
									{!! @$default !!}
								</td>
								@if($user->user_type->user_type_group == 'administrator')
								<td>
									{{ $catalog->company->company_name }}
								</td>
								@endif
								<td>
									{{ $catalog->car_catalog_type}}
								</td>
								<td>
									<a href="{{ $catalog->getFirstMediaUrl('catalog_images') }}" class='btn btn-sm btn-outline-success waves-effect waves-light'>Download PDF</a>
								</td>
								<td>
									<a href="{{ $catalog->getFirstMediaUrl('catalog_images') }}" class='btn btn-sm btn-outline-success waves-effect waves-light'>Recently Deleted</a>
								</td>
								<td>
									{!! @$is_default !!}
									<a href=" {{ route('catalog_edit', $catalog->car_catalog_id) }}" class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
									<span data-toggle='modal' data-target='#delete' data-id="{{ $catalog->car_catalog_id }}" class='delete'><a href='javascript:void(0);' class='btn btn-sm btn-outline-danger waves-effect waves-light'>Delete</a></span>
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
		</div>
	</div>
</div>
<!-- End Page-content -->
<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('car_catalog_status') }}">
				@csrf
				<div class="modal-body">
					<h4>Delete this catalog ?</h4>
					<input type="hidden" , name="user_id" id="user_id">
					<input type="hidden" , name="action" value="delete">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="default" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('catalog_default') }}">
				@csrf
				<div class="modal-body">
					<h4>Set as default this catalog ?</h4>
					<input type="hidden" , name="product_id" id="product_id">
					<input type="hidden" , name="action" value="default">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Yes</button>
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
		//$("#user_role").hide();
		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #user_id").val(id);
		});
		$('.default').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #product_id").val(id);
		});
		$('.activate').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #user_id").val(id);
		});
	});
</script>
@endsection