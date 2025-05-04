@extends('layouts.master')

@section('title') Admin Listing @endsection
@section('css')
<style>
    .custom-dropdown-container .select2-container {
        width: 100% !important;
    }
</style>
@endsection
@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3">Admin Listing</span>
					<a href="{{ route('admin_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
							<i class="mdi mdi-plus mr-1"></i> Add New
					</a>
			</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Admin</a>
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
									<div class="form-group custom-dropdown-container">
										<label for="validationCustom03">Admin Status</label>
										{!! Form::select('user_status', $user_status_sel, @$search['user_status'], ['class' => 'form-control select2', 'id'=>'user_status']) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="validationCustom03">Admin Role</label>
										{!! Form::select('user_role_id', $user_role_sel, @$search['user_role_id'], ['class' => 'form-control select2', 'id' => 'user_role_id']) !!}
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
								<th style="400px">Admin Profile</th>
								<th style="300px">Role</th>
								<th style="width: 150px">Status</th>
                                @can(['admin_manage'])
								<th>Action</th>
                                @endcan
							</tr>
						</thead>
						<tbody>
							<?php
                                $no = $users->firstItem();
                            ?>
							@if($users->isNotEmpty())
							@foreach($users as $user)
							<?php
							$status = '';
							$assign_permission = '';
							$action = '';

							switch ($user->user_status) {
								case 'active':
									$status = "<span class='badge badge-primary font-size-11'>".ucwords($user->user_status)."</span>";
									$assign_permission = "<a href='" . route('assign_permission', $user->user_id) . "' class='btn btn-sm btn-outline-primary waves-effect waves-light'>Assign Permission</a>";
									$action = "{$assign_permission}
                                            <a href='" . route('admin_edit', $user->user_id) . "' class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
											<span data-toggle='modal' data-target='#suspend' data-id='$user->user_id' class='suspend'><a href='javascript:void(0);' class='btn btn-sm btn-outline-danger waves-effect waves-light'>Suspend</a></span>";
									break;
								case 'suspend':
									$status = "<span class='badge badge-danger'>".ucwords($user->user_status)."</span>";
									$action = "<span data-toggle='modal' data-target='#activate' data-id='$user->user_id' class='activate'><a href='javascript:void(0);' class='btn btn-sm btn-outline-success waves-effect waves-light'>Activate</a></span>";
									break;
								case 'pending':
									$status = "<span class='badge badge-warning'>".ucwords($user->user_status)."</span>";
									break;
							}

							?>
							<tr>
								<td>
									{{ $no++ }}
								</td>
								<td>
									<div class="media mb-4">
										@if ($user->hasMedia('user_profile_picture'))
											<img class="d-flex mr-3 rounded-circle" src="{{$user->getFirstMediaUrl('user_profile_picture', 'thumbnail')}}" height="50" width="50"/>
										@else
											<img class="d-flex mr-3 rounded-circle" src="{{url('assets/images/users/avatar-1.jpg')}}" height="50" width="50"/>
										@endif
										<div class="media-body">
											<b>{{ $user->user_fullname }}</b>
										     <br>
											{{ $user->user_email}}<br />
											{{ $user->user_mobile }}
										</div>
									</div>
								</td>
								<td>
									{{ $user->user_role_name }}
								</td>
								<td>
									{!! $status !!}
								</td>
                                @can(['admin_manage'])
                                <td>
                                    <div  class="button-container" style="display: flex;gap:10px;">
                                        {!! $action !!}
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
				{{ $users->links() }}
			</div>
		</div>
	</div>
</div>
<!-- End Page-content -->
<!-- Modal -->
<div class="modal fade" id="suspend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('admin_status') }}">
				@csrf
				<div class="modal-body">
					<h4>Suspend this admin ?</h4>
					<input type="hidden" , name="user_id" id="user_id">
					<input type="hidden" , name="action" value="suspend">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Suspend</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="POST" action="{{ route('admin_status') }}">
				@csrf
				<div class="modal-body">
					<h4>Activate this admin ?</h4>
					<input type="hidden" , name="user_id" id="user_id">
					<input type="hidden" , name="action" value="active">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Activate</button>
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
    $(document).ready(function () {
        $('#user_status').select2({
        minimumResultsForSearch: Infinity
    });
    });
</script>
<script>
    $(document).ready(function () {
        $('#user_role_id').select2({
        minimumResultsForSearch: Infinity
    });
    });
</script>
<script>
	$(document).ready(function(e) {
		//$("#user_role").hide();
		$('.suspend').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #user_id").val(id);
		});
		$('.activate').on('click', function() {
			var id = $(this).attr('data-id');
			console.log(id);
			$(".modal-body #user_id").val(id);
		});
	});
</script>
@endsection
