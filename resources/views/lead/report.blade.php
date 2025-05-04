@extends('layouts.master')

@section('title') Leads Report @endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/assets/libs/toastr/toastr.min.css') }}">
    <style>
        .custom-dropdown-container .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')

<!-- start page title -->
<form method="POST" action="{{ $submit }}">
    @csrf
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-md-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"><span class="mr-3 ">Leads Report</span></h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Leads</a>
					</li>
					<li class="breadcrumb-item active">Report</li>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Freetext</label>
                                    <input type="text" class="form-control" name="freetext" placeholder="Search for..." value="{{ @$search['freetext'] }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Date Range</label>
                                    <div>
                                        <div class="input-daterange input-group" id="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker">
                                            <input type="text" style="width: 75px" class="form-control start_date" name="start_date" placeholder="From" value="{{ @$search['start_date'] ? date('Y-m-d', strtotime(@$search['start_date'])) : $start_date }}" id="start_date" autocomplete="off">
                                            <input type="text" style="width: 75px" class="form-control end_date" name="end_date" placeholder="To" value="{{ @$search['end_date'] ? date('Y-m-d', strtotime(@$search['end_date'])) : $end_date }}" id="end_date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->user_type->user_type_slug == 'admin')
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Company</label>
                                        {!! Form::select('company_id', $company, @$search['company_id'], ['class' => 'form-control select2', 'id' => 'company_id']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        {!! Form::select('branch_id', $company_branch, @$search['branch_id'], ['class' => 'form-control select2', 'id' => 'branch_id']) !!}
                                    </div>
                                </div>
                            @elseif (Auth::user()->roles->value('id') == 3)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        {!! Form::select('branch_id', $branch, @$search['branch_id'], ['class' => 'form-control select2', 'id' => 'branch_id']) !!}
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->roles->value('id') == 3 || Auth::user()->user_type->user_type_slug == 'admin')
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="validationCustom03">User</label>
                                        {!! Form::select('user', $user, @$search['user'], ['class' => 'form-control select2', 'id'=>'user_id']) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group custom-dropdown-container">
                                    <label for="validationCustom03">Lead Type</label>
                                    {!! Form::select('lead_type', $lead_type_sel, @$search['lead_type'], ['class' => 'form-control select2', 'id' => 'lead_type']) !!}
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">Total View</p>
                                        <h4 class="mb-0">{{ number_format(@$view->view) ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">Whatsapp Clicks</p>
                                        <h4 class="mb-0">{{ number_format(@$counter->whatsapp) ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium mb-2">Contacts Clicks</p>
                                        <h4 class="mb-0">{{ number_format(@$counter->contact ?? 0) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>WhatsApp Lead</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
					<table class="table table-nowrap">
						<thead class="thead-light">
							<tr>
								<th scope="col" style="width: 70px;">#</th>
                                <th>Date & Time</th>
								<th>Customer</th>
                                <th>Status</th>
								<th>Details</th>
							</tr>
						</thead>
						<tbody>
                            @php
                                $no = $records->firstItem();
                            @endphp


                            @forelse($records as $rows)

                                <tr>

                                    <th>{{$no++}}</th>
                                    <td>
                                        {!!
                                            date('Y-m-d', strtotime($rows->dealer_view_ctr_created)) . '<br>' .
                                            date('H:i:s', strtotime($rows->dealer_view_ctr_created))
                                        !!}
                                    </td>
                                    <td>
                                        {{ $rows->dealer_view_ctr_type }}
                                    </td>
                                    <td>
                                    @switch($rows->dealer_view_ctr_view_type)
                                            @case('contact')
                                                    {!! "<span class='badge badge-primary font-size-11'>Contact</span>" !!}
                                                @break
                                            @case('whatsapp')
                                                {!! "<span class='badge badge-success font-size-11'>Whatsapp</span>" !!}
                                                    @switch($rows->dealer_view_ctr_whatsapp_read)
                                                    @case(1)
                                                        {!! "<span class='badge badge-success font-size-11'>Read</span>" !!}
                                                        @break
                                                    @default
                                                        {!! "<span class='badge badge-warning font-size-11'>Unread</span>" !!}
                                                    @endswitch
                                                @break
                                    @endswitch
                                        <br>Platform : {{ $rows->dealer_view_ctr_platform }}
                                    </td>
                                    <td>
                                        User Name : {{ $rows->user->user_fullname ?? '-' }}
                                        <br>User Mobile : {{ $rows->user->user_mobile ?? '-' }}
                                        <br>Branch: {{ $rows->user->join_company->company_branch->company_branch_name}} @ {{ $rows->user->join_company->company->company_name ?? '-'}}
                                        @if ($rows->product_id)
                                            <br>Product: {{$rows->product->product_name}}
                                        @endif
                                        @if($rows->car_brand_name)
                                            <br>Car: {{$rows->car_brand_name}} {{$rows->car_model_name}} {{@$rows->car_variant_name}}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan='5'>No Records!</td>
                                </tr>
                            @endforelse
						</tbody>
					</table>
				</div>
            </div>
            @if (@$records->lastPage() > 1)
                <div class="card-footer">
                    {{$records->links()}}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $("#start_date, #end_date").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true, //to close picker once year is selected
    });
</script>
<script>
        $(document).ready(function () {
        $('#lead_type').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>
<!-- form repeater js -->
<script src="{{ URL::asset('/assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/pages/form-repeater.int.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
@endsection
