@extends('layouts.master')

@section('title') Product Category Listing @endsection

@section('css')
        <link href="{{URL::asset('lightbox2/src/css/lightbox.css')}}" rel="stylesheet" />
@endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3">Product Category Listing</span>
					<a href="{{ route('product_category_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
							<i class="mdi mdi-plus mr-1"></i> Add New
					</a>
			</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Product Category</a>
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
						<form method="POST" action="{{ route('product_category_listing') }}">
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Freetext</label>
										<input type="text" class="form-control select_active" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
									</div>
								</div>
                                @if($user->user_type->user_type_group == 'administrator')
								<div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="validationCustom03">Company</label>
                                        {!! Form::select('company_id', $company, @$search['company_id'], ['class' => 'form-control select2', 'id' => 'company_id']) !!}
                                    </div>
						        </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group custom-dropdown-container">
                                        <label for="product_category_status">Status</label>
                                        {!! Form::select('product_category_status', $status, @$search['product_category_status'], ['class' => 'form-control select2', 'id' => 'product_category_status']) !!}
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
								<th>Product Category Name</th>
								<th>Product Category Priority</th>
								<th>Assigned Product</th>
								@if(@$user_type == 'administrator')
                                <th>Company</th>
								@endif
								<th>Status</th>
                                @can(['product_category_manage'])
                                <th>Action</th>
                                @endcan
							</tr>
						</thead>
						<tbody>
							<?php
                                $no = $product_category->firstItem();
                            ?>
							@if($product_category->isNotEmpty())
							@foreach($product_category as $product_categorys)
							<?php
								if ($product_categorys->is_published) {
									$status = "<span class='badge badge-success' data-toggle='popover' data-trigger='focus' title='' data-original-title='Date Created'>Published</span>";
								} else {
									$status = "<span class='badge badge-warning' data-toggle='popover' data-trigger='focus' title=''  data-original-title='Date Created'>Draft</span>";
								}
							?>
							<tr>
								<td>
									<b>{{ $no++ }}</b>
								</td>
                                <td>
								    <div class="d-flex">
                                        <div class="flex-grow-1 overflow-hidden">
										    {{ $product_categorys->product_category_name }}
                                        </div>
                                    </div>
								</td>
								<td>
								    {{ $product_categorys->product_category_priority }}
								</td>
								<td>
								    {{ $product_categorys->assigned_product }}
								</td>
								@if(@$user_type == 'administrator')
                                <td>
								    {{ $product_categorys->company?->company_name }}
								</td>
								@endif
								<td>
								{!! $status !!}
								</td>
                                @can(['product_category_manage'])
								<td>
                                    <div class="button-container" style="display: flex;gap:10px;">
                                        <a href=" {{ route('product_category_edit', $product_categorys->product_category_id) }}" class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
                                        <span data-toggle='modal' data-target='#delete' data-id="{{ $product_categorys->product_category_id }}" class='delete'><a href='javascript:void(0);' class='btn btn-sm btn-outline-danger waves-effect waves-light'>Delete</a></span>
								    </div>
                                </td>
                                @endcan
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
            {{ $product_category->links() }}
		</div>
	</div>
</div>
<!-- End Page-content -->
<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('product_category_status') }}">
				@csrf
				<div class="modal-body">
					<h4>Delete this product category ?</h4>
					<input type="hidden" , name="product_category_id" id="product_category_id">
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
<!-- End Modal -->
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('lightbox2/src/js/lightbox.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#product_category_status').select2({
        minimumResultsForSearch: Infinity
    });
    });

</script>
<script>
	$(document).ready(function(e) {
		//$("#user_role").hide();
		$('.delete').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #product_category_id").val(id);
		});
		$('.activate').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #user_id").val(id);
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
@endsection
