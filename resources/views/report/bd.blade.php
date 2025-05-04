@extends('layouts.master')

@section('title') Business Development Reporting @endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/daterangepicker.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
	<link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
	<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/datatables/datatables-fixedHeader.min.css')}}"> -->
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">Business Development Reporting</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Reporting</a>
					</li>
					<li class="breadcrumb-item active">Business Development Reporting</li>
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
				<div class="row mb-2">
					<div class="col-sm-12">
						<form method="POST" action="{{ route('report_bd') }}">
							@csrf
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>BD</label>
										{!! Form::select('admin_bd_id', $admin_bd, @$search['admin_bd_id'], ['class' => 'form-control select2 select2_active']) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Date</label>
										<input type="text" id="reportrange" class="form-control select_active" name="date" value="{{ @$search['date'] }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Post Percentage (%)</label>
										{!! Form::select('post_percentage', $post_percentage_sel, @$search['post_percentage'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Bump Percentage (%)</label>
										{!! Form::select('bump_percentage', $bump_percentage_sel, @$search['bump_percentage'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Status</label>
										{!! Form::select('dealer_status', $dealer_status_sel, @$search['dealer_status'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>User Type</label>
										{!! Form::select('user_type_id', $user_type_sel, @$search['user_type_id'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Coverage Area</label>
										{!! Form::select('setting_coverage_area_id', $setting_coverage_area_sel, @$search['setting_coverage_area_id'], ['class' => 'form-control select_active']) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group action-button d-md-flex">
										<button type="submit" class="btn btn-primary  waves-effect waves-light mb-2 mr-2" name="submit" value="search">
											<i class="fas fa-search mr-1"></i> Search
                                        </button>
                                        <span class="column-visibility ml-md-auto"></span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="table-container" class="table-responsive font-size-11">
                    <table id="datatable" class="table table-bordered w-100 display nowrap">
                        <thead id="table-header" class="thead-light">
                            <tr align="center">
								<th rowspan="2">No</th>
                                <th rowspan="2">Account<br/>Manager</th>
                                <th rowspan="2">Status</th>
								<th rowspan="2">Dealer</th>
								<th rowspan="2">Company<br/>Code</th>
								<th rowspan="2">Coverage<br/>Area</th>
								<th rowspan="2">Selling<br/>Type</th>
								<th rowspan="2">Total<br/>User</th>
                                <th rowspan="2">Join<br/>Date</th>
                                <th rowspan="2">Total<br/>View</th>
                                <th rowspan="2">Total<br/>Ctr</th>
                                <th rowspan="2">Total<br/>Impression</th>
                                <th colspan="5">Credit</th>
								<th colspan="3">Post</th>
								<th colspan="3">Post Premier</th>
								<th colspan="3">Bump</th>
								<th colspan="3">Bump Premier</th>
								<th colspan="2">Ads Discount Request</th>
								<th rowspan="2">Amount Paid</th>
							</tr>
							<tr align="center">
                                <th>Topup</th>
                                <th>Spend</th>
                                <th>Spend Premier</th>
                                <th>Adjustment</th>
                                <th>Balance</th>
								<th>Previous</th>
                                <th>Current</th>
								<th>%</th>
								<th>Previous</th>
                                <th>Current</th>
								<th>%</th>
                                <th>Previous</th>
                                <th>Current</th>
                                <th>%</th>
                                <th>Previous</th>
                                <th>Current</th>
                                <th>%</th>
								<th>Seen</th>
								<th>Pending</th>
							</tr>
                        </thead>
						<tbody id="table-body" class="detail">
						@if(@$records['result'])
							@php
								$total_dealer = 0;
                                $total_view = 0;
								$total_ctr = 0;
								$total_impression = 0;
								$total_topup = 0;
								$total_spend = 0;
								$total_spend_premier = 0;
								$total_previous_post = 0;
								$total_current_post = 0;
								$total_previous_bump = 0;
								$total_current_bump = 0;
                                $total_previous_post_premier = 0;
								$total_current_post_premier = 0;
								$total_previous_bump_premier = 0;
								$total_current_bump_premier = 0;
								$total_seen = 0;
								$total_pending	 = 0;
								$no = 0;
								$total_amount_paid = 0;
							@endphp
							@foreach($records['result'] as $key=>$row)
								@php
									$adjustment = $row->adjustment;
									if($row->adjustment > 0) {
										$adjustment = '+' . $row->adjustment;
									} else if($row->adjustment < 0) {
										$adjustment = '-' . $row->adjustment;
									}
								@endphp

                                <tr align="center">
									<td>{{ ++$no }}</td>
									<td>{{ $row->account_manager }}</td>
                                    <td>{!! $row->dealer_status == 'active' ? '<span class="text-success">' . ucwords($row->dealer_status) . '</span>' : '<span class="text-danger">' . ucwords($row->dealer_status) . '</span>' !!}</td>
                                    <td style="width: 10%"><a class="popup" href="{{ route('report_bd_detail', [$row->company_id, @$search['date']]) }}">{{ $row->company_name }}</a><br/>{{ $row->user_type_name ?? '' }}</td>
									<td>{{ $row->user_code ?? '' }}</td>
									<td>{{ $row->setting_coverage_area->setting_coverage_area_name ?? '-' }}</td>
									<td>{{ $row->company_selling_type ?? '-'}}</td>
									<td>{{ $row->company_users->count() }}</td>
									<td>{{ date('Y-m-d', strtotime($row->company_approval_date)) }}</td>
                                    <td>{{ $row->total_view ?? 0 }}</td>
                                    <td>{{ $row->total_ctr ?? 0 }}</td>
                                    <td>{{ $row->total_impression ?? 0 }}</td>

                                    <td><a class="popup" href="{{ route('report_bd_credit_history_detail', [$row->company_id, @$search['date'], 'add']) }}">{{ number_format($row->topup, 2) }}</a></td>

                                    {{-- spend --}}
                                    <td><a class="popup" href="{{ route('report_bd_credit_history_detail', [$row->company_id, @$search['date'], 'deduct']) }}">{{ number_format($row->spend, 2) }}</a></td>

                                    {{-- spend premier--}}
                                    <td><a class="popup" href="{{ route('report_bd_credit_history_detail', [$row->company_id, @$search['date'], 'deduct']) }}">{{ number_format($row->spend_premier, 2) }}</a></td>

                                    <td>{{ $adjustment  }}</td>
                                    <td>{{ number_format($row->balance, 2) }}</td>

                                    {{-- post --}}
                                    <td><a class="popup" href="{{ route('report_bd_post_detail', [$row->company_id, $records['date_range_before']]) }}">{{ $row->previous_ads_post }}</a></td>
									<td><a class="popup" href="{{ route('report_bd_post_detail', [$row->company_id, @$search['date']]) }}">{{ $row->current_ads_post }}</a></td>
									<td style="white-space:nowrap">{!! $row->ads_post_percent < 0 ? number_format(abs($row->ads_post_percent), 2) . ' <span><i class="bx bxs-down-arrow text-danger"></i></span>' : ($row->ads_post_percent == 0 ? '0.00' : number_format($row->ads_post_percent, 2) . ' <span><i class="bx bxs-up-arrow text-success"></i></span>') !!}</td>

                                    {{-- post premier --}}
                                    <td><a class="popup" href="{{ route('report_bd_post_detail', [$row->company_id, $records['date_range_before'],'premier']) }}">{{ $row->previous_ads_post_premier }}</a></td>
                                    <td><a class="popup" href="{{ route('report_bd_post_detail', [$row->company_id, @$search['date'],'premier']) }}">{{ $row->current_ads_post_premier }}</a></td>
                                    <td style="white-space:nowrap">{!! $row->ads_post_percent_premier < 0 ? number_format(abs($row->ads_post_percent_premier), 2) . ' <span><i class="bx bxs-down-arrow text-danger"></i></span>' : ($row->ads_post_percent_premier == 0 ? '0.00' : number_format($row->ads_post_percent_premier, 2) . ' <span><i class="bx bxs-up-arrow text-success"></i></span>') !!}</td>

                                    {{-- bump --}}
                                    <td><a class="popup" href="{{ route('report_bd_bump_detail', [$row->company_id, $records['date_range_before']]) }}">{{ $row->previous_ads_bump }}</a></td>
									<td><a class="popup" href="{{ route('report_bd_bump_detail', [$row->company_id, @$search['date']]) }}">{{ $row->current_ads_bump }}</a></td>
									<td style="white-space:nowrap">{!! $row->bump_percent < 0 ? number_format(abs($row->bump_percent), 2) . ' <span><i class="bx bxs-down-arrow text-danger"></i></span>' : ($row->bump_percent == 0 ? '0.00' : number_format($row->bump_percent, 2) . ' <span><i class="bx bxs-up-arrow text-success"></i></span>') !!}</td>

                                    {{-- bump premier --}}
                                    <td><a class="popup" href="{{ route('report_bd_bump_detail', [$row->company_id, $records['date_range_before'],'premier']) }}">{{ $row->previous_ads_bump_premier }}</a></td>
                                    <td><a class="popup" href="{{ route('report_bd_bump_detail', [$row->company_id, @$search['date'],'premier']) }}">{{ $row->current_ads_bump_premier }}</a></td>
                                    <td style="white-space:nowrap">{!! $row->bump_percent_premier < 0 ? number_format(abs($row->bump_percent_premier), 2) . ' <span><i class="bx bxs-down-arrow text-danger"></i></span>' : ($row->bump_percent_premier == 0 ? '0.00' : number_format($row->bump_percent_premier, 2) . ' <span><i class="bx bxs-up-arrow text-success"></i></span>') !!}</td>

									<td>{{ $row->seen ?? 0 }}</td>
									<td>{{ $row->pending ?? 0 }}</td>
									<td>{{ $row->amount_paid }}</td>
								</tr>

								@php
									$total_dealer++;
									$total_view += $row->total_view;
									$total_ctr += $row->total_ctr;
									$total_impression += $row->total_impression;
									$total_topup += $row->topup;
									$total_spend += $row->spend;
									$total_spend_premier += $row->spend_premier;
									$total_previous_post += $row->previous_ads_post;
									$total_current_post += $row->current_ads_post;
									$total_previous_bump += $row->previous_ads_bump;
									$total_current_bump += $row->current_ads_bump;
									$total_previous_post_premier += $row->previous_ads_post_premier;
									$total_current_post_premier += $row->current_ads_post_premier;
									$total_previous_bump_premier += $row->previous_ads_bump_premier;
									$total_current_bump_premier += $row->current_ads_bump_premier;
									$total_seen += $row->seen;
									$total_pending += $row->pending;
									$total_amount_paid += $row->amount_paid;
								@endphp
							@endforeach

						</tbody>
						<tfoot>
							<tr align="center" class="font-weight-bold">
								<td>Total</td>
								<td> - </td>
								<td> - </td>
								<td> {{ $total_dealer }} </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
                                <td>{{ $total_view }}</td>
                                <td>{{ $total_ctr }}</td>
                                <td>{{ $total_impression }}</td>

                                {{-- credit--}}
                                <td> {{ number_format($total_topup,2) }} </td>
                                <td> {{ number_format($total_spend, 2) }} </td>
                                <td> {{ number_format($total_spend_premier, 2) }} </td>
                                <td> - </td>
                                <td> - </td>

                                {{-- post --}}
								<td> {{ $total_previous_post }} </td>
								<td> {{ $total_current_post }} </td>
								<td> - </td>

                                {{-- post premier --}}
                                <td> {{ $total_previous_post_premier }} </td>
                                <td> {{ $total_current_post_premier }} </td>
                                <td> - </td>

                                {{-- bump --}}
								<td> {{ $total_previous_bump }} </td>
								<td> {{ $total_current_bump }} </td>
								<td> - </td>

                                {{-- bump premier --}}
                                <td> {{ $total_previous_bump_premier }} </td>
                                <td> {{ $total_current_bump_premier }} </td>
                                <td> - </td>

								<td>{{ $total_seen }}</td>
								<td>{{ $total_pending }}</td>
								<td>{{ $total_amount_paid }}</td>
							</tr>
						</tfoot>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')

<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<!-- <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>  -->
<script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables-fixed-header.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/js/freeze-table/freeze-table.js')}}"></script>
<script>
	$(document).ready(function(){

		var table = $('#datatable').DataTable({
			paging: false,
			info: false,
			searching: false,
			order: [],
			columnDefs: [
				{
					orderable: false, targets: [0,1,4,13,14]
				}
			],
			lengthChange: false,
			// buttons: ['copy', 'excel', 'pdf', 'colvis']
			buttons: [
				{ extend: 'excel', className: 'waves-effect waves-light mb-2 mr-2 export-btn', text: 'Export' },
				{ extend: 'colvis', className: 'waves-effect waves-light mb-2 colvis_btn' },
			],
			// fixedHeader: {
			// 	header: true,
			// 	headerOffset: 64
			// },
		});
		table.buttons().container().appendTo('.action-button');

		var export_btn = $('.action-button').find('.export-btn');
		var colvis_btn = $('.action-button').find('.colvis_btn');
		$(export_btn).insertBefore('.column-visibility');
		// $('.action-button').append(export_btn);
		// $('.action-button').append(colvis_btn);
		$('.column-visibility').append(colvis_btn);
		$('.dt-buttons').remove();

		$('#datatable th.sorting').click(function(e) {
			var no = 0;
			$('#datatable tbody td:first-child').each(function(){
				no++;
				$(this).text(no);
			});
		});

		var start = moment().subtract(30, 'days');
		var end = moment();

		var search_date = '{{ @$search["date"] }}';
		if(search_date){
			var new_date = search_date.split(' - ');
			start = new_date[0];
			end = new_date[1];
		}

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(7, 'days'), moment()],
			'Last 30 Days': [moment().subtract(30, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			locale: {
            	format: 'YYYY-MM-DD'
        	}
		});

		$(".popup").fancybox({
			'type': 'iframe',
			'width': 1000,
			'height': 700,
			'autoDimensions': false,
			'autoScale': false
		});

		$('.select2').select2({
			width: '100%'
		});

		$('.column-visibility').on('click', '.dt-button-background', ()=>{
			console.log('sss');
				$('.main-content').css('overflow', 'hidden');

		});

		$('.colvis_btn').on('click', ()=>{
			$('.main-content').css('overflow', 'unset');
		})

		$("#datatable").parent().freezeTable({
			'freezeColumn': false,
		});
		$("#datatable").parent().css('overflow-x', 'scroll');
	});
</script>
@endsection
