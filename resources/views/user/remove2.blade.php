@extends('layouts.master')

@section('title') Remove User Permanently @endsection

@section('css') 
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Remove User Permanently</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Remove User</a>
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
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ $submit }}">
            @csrf        
            @if($user)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Note</h4>
                        <div class="form-group">
                            <label for="user_remove_history_remark">Remark</label>
                            <textarea id="user_remove_history_remark" class="form-control" name="user_remove_history_remark" rows="10" maxlength="255"></textarea>
                        </div>      
                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            <a href="{{ route('user_remove_step_1') }}" class="btn btn-secondary" type="button">Cancel</a>
                        </div>                                       
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User Details</h4>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="company-profile-rounded-box m-0">
                                    <div class="company-profile-outer" style="background-image: url({{ @$user->hasMedia('user_profile_photo_crop') ? $user->getFirstMediaUrl('user_profile_photo_crop') : URL::asset('assets/images/placeholder_user_profile.jpg') }})" ></div>
                                </div>                            
                            </div>
                            <div class="col-sm-5">                                                        
                                <div class="form-group">
                                    <div class="font-weight-bold">User Fullname</div>
                                    <div>{{ $user->user_fullname }}</div>
                                </div>
                                <div class="form-group">
                                    <div class="font-weight-bold">Username</div>
                                    <div>{{ $user->username }}</div>
                                </div>
                                <div class="form-group">
                                    <span class="font-weight-bold">{{ @$user->user_type->user_type_name }}</span>
                                </div>
                                <div class="form-group">
                                    <img src="/assets/images/credit_icon.svg">
                                    <span class="d-none d-xl-inline-block mt-2">
                                    <span>{{ $user->user_credit ? $user->user_credit->user_credit : 0 }}</span>
                                </div>
                            </div>
                            <div class="col-sm-5">                                                        
                                <div class="form-group">
                                    <div class="font-weight-bold">User Email</div>
                                    <div>{{ $user->user_email }}</div>
                                </div>
                                <div class="form-group">
                                    <div class="font-weight-bold">User Mobile</div>
                                    <div>{{ $user->user_mobile ? $user->user_mobile : ' - ' }}</div>
                                </div>
                                @if($user->user_type_id == 5)
                                <div class="form-group">
                                    <div class="font-weight-bold">User Ad</div>
                                    <div>{{ $user->ads ? $user->ads->count() : 0 }}</div>
                                </div> 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(($user->user_application_status_id == 2 || $user->user_application_status_id == 3) && ($user->user_type_id == 2 || $user->user_type_id == 4) && $user->user_company)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Company Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Name</div>
                                    <div class="font-size-16 ">{{ $user->user_company->company_name ?? ' - ' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Reg. No.</div>
                                    <div class="">{{ $user->user_company->company_regno ?? ' - ' }}</div>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Phone</div>
                                    <div class="">{{ $user->user_company->company_phone ? '+' . $user->user_company->company_phone : ' - ' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Email</div>
                                    <div class="" type="email">{{ $user->user_company->company_email ?? ' - ' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Website</div>
                                    <div class="" type="email">{{ $user->user_company->company_website ?? ' - ' }}</div>
                                </div>
                            </div>
                        </div>     
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Address</div>
                                    <div class="">{{ $user->user_company->company_address ?? ' - ' }}</div>

                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company Postcode</div>
                                    <div class="">{{ $user->user_company->company_postcode ?? ' - ' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Company State</div>
                                    <div class="">{{ $user->user_company->company_state ?? ' - ' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group"> 
                                    <div class="font-weight-bold">Company City</div>
                                    <div class="">{{ $user->user_company->company_city ?? ' - ' }}</div>
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="font-weight-bold">Country</div>
                                    <div class="">{{ @$user->user_nationality ?? ' - ' }}</div>
                                </div>
                            </div>                       
                        </div>  
                    </div>
                </div> 
                @endif
                @if(($user->user_application_status_id == 2 || $user->user_application_status_id == 3) && $user->join_company)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Company Users</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Ad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                    ?>
                                    @if(optional($user->user_company)->company_user)
                                        @foreach($user->user_company->company_user as $company_user)
                                        <?php
                                        $status = '';
                                        switch ($company_user->company_user_status) {
                                            case 'approved':
                                                $status = "<span class='badge badge-success'>".ucwords($company_user->company_user_status)."</span>";
                                            break;
                                            case 'rejected':
                                                $status = "<span class='badge badge-danger'>".ucwords($company_user->company_user_status)."</span>";
                                            break;
                                            case 'pending':
                                                $status = "<span class='badge badge-warning'>".ucwords($company_user->company_user_status)."</span>";
                                            break;
                                            case 'remove':
                                                $status = "<span class='badge badge-secondary'>".ucwords($company_user->company_user_status)."</span>";
                                            break;
                                        }

                                        ?>
                                        <tr>
                                            <td>
                                                {{ $no++ }}
                                            </td>
                                            <td>
                                                <div class="media mb-4">
                                                    <div class="media-body">
                                                        <b>{{ $company_user->user->user_fullname }}</b><br />
                                                        {{ $company_user->user->user_email}}<br />
                                                        {{ $company_user->user->user_mobile }}<br />
                                                        Credit: 
                                                        @if (@$company_user->user->user_credit->user_credit_id)
                                                            @can('user_manage')
                                                                <a class="popup" data-fancybox-type="" href="{{ route('user_credit_history', $company_user->user->user_credit->user_credit_id) }}">
                                                            @endcan
                                                            {{ $company_user->user->user_credit->user_credit ?? 0 }}</a>
                                                        @else
                                                            Not Available
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <b>{{ $company_user->user->user_type->user_type_name }}</b><br />
                                            </td>
                                            <td>
                                                {!! $status !!}
                                            </td>
                                            <td>                                            
                                                {{ $company_user->user->ads ? $company_user->user->ads->count() : 0 }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <?php
                                        $status = '';
                                        switch ($user->join_company->company_user_status) {
                                            case 'approved':
                                                $status = "<span class='badge badge-success'>Approved</span>";
                                            break;
                                            case 'rejected':
                                                $status = "<span class='badge badge-danger'>Rejected</span>";
                                            break;
                                            case 'pending':
                                                $status = "<span class='badge badge-warning'>Pending</span>";
                                            break;
                                            case 'remove':
                                                $status = "<span class='badge badge-secondary'>Removed</span>";
                                            break;
                                        }

                                        ?>
                                        <tr>
                                            <td>
                                                {{ $no++ }}
                                            </td>
                                            <td>
                                                <div class="media mb-4">
                                                    <div class="media-body">
                                                        <b>{{ $user->user_fullname }}</b><br />
                                                        {{ $user->user_email}}<br />
                                                        {{ $user->user_mobile }}<br />
                                                        Credit: 
                                                        @if (@$user->user_credit->user_credit_id)
                                                            @can('user_manage')
                                                                <a class="popup" data-fancybox-type="" href="{{ route('user_credit_history', $user->user_credit->user_credit_id) }}">
                                                            @endcan
                                                            {{ $user->user_credit->user_credit ?? 0 }}</a>
                                                        @else
                                                            Not Available
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <b>{{ $user->user_type->user_type_name }}</b><br />
                                            </td>
                                            <td>
                                                {!! $status !!}
                                            </td>
                                            <td>                                            
                                                {{ $user->ads ? $user->ads->count() : 0 }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
        @endif
        </form>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>
    
    <script>
        $(document).ready(function() {
            $(".popup").fancybox({
                'type': 'iframe',
                'width': 1000,
                'height': 700,
                'autoDimensions': false,
                'autoScale': false
            });
        })
    </script>
@endsection