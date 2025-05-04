@extends('layouts.master')

@section('title') {{$type}} Role Listing @endsection

@section('content')

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3 ">{{@$type}} Role Listing</span>
				@can('admin_role_manage')
				    @if(@$type == 'Admin')
					<a href="{{ route('admin_role_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
						<i class="mdi mdi-plus mr-1"></i> Add New
					</a>
					@endif
                @endcan
                @can('user_role_manage')
                    @if(@$type == 'User')
                    <a href="{{ route('user_role_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
                        <i class="mdi mdi-plus mr-1"></i> Add New
                    </a>
                    @endif
                @endcan
			</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">{{@$type}} Role</a>
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
				<!-- <div class="row mb-2"> -->
				<div class="table-responsive">
					<table class="table table-nowrap">
						<thead class="thead-light">
							<tr>
								<th scope="col" style="width: 70px;">#</th>
								<th>Role Title</th>
                                @if(@$type == 'Admin')
								<th>Total Admin</th>
                                @else
								<th>Total User</th>
                                @endif
                                @canany(['admin_role_manage','user_role_manage'])
								<th>Action</th>
                                @endcanany
							</tr>
						</thead>
						<tbody>
							<?php $num = 1; ?>
							@foreach($roles as $role)
							<tr>
								<td>{{ $num }}</td>
								<td>{{ $role->name }}</td>
								<td>{{ $user_role_count[$role->id] }}</td>
                                @canany(['admin_role_manage','user_role_manage'])
								<td>
									@can('admin_role_manage')
									    @if(@$type == 'Admin')
									    <a href="{{ route('admin_role_edit',$role->id) }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
										    Edit & Assign Permission
									    </a>
									    @endif
                                    @endcan
                                    @can(['user_role_manage'])
										@if(@$type == 'User')
									    <a href="{{ route('user_role_edit',$role->id) }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
										    Edit & Assign Permission
									    </a>
										@endif
									@endcan
								</td>
                                @endcanany
							</tr>
							<?php $num++; ?>
							@endforeach
						</tbody>
					</table>
				</div>


			</div>
		</div>
	</div>
</div>
<!-- End Page-content -->
@endsection
