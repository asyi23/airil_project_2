@extends('layouts.master')

@section('title') Sales Transaction Summary Report @endsection

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
			<h4 class="mb-0 font-size-18">Sales Transaction Summary Report</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Report</a>
					</li>
					<li class="breadcrumb-item active">Sales Transaction Summary</li>
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
						<form method="POST" action="{{ $submit }}">
							@csrf
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Year</label>
										{!! Form::select('year', $year_sel, @$search['year'], ['class' => 'form-control select_active'] ) !!}
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
				<div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr align="center">
                                <th>Month</th>
								<th>Subscription</th>
								<th>Subscription Tax</th>
								<th>Subscription Grandtotal</th>
								<th>Topup</th>
								<th>Topup Tax</th>
								<th>Topup Grandtotal</th>
							</tr>
                        </thead>
						<tbody>						
                            @php 
                                $total_topup = 0;
								$total_topup_tax = 0;
                                $total_subscription = 0;
                                $total_subscription_tax = 0;
								$total_subscription_grandtotal = 0;
								$total_topup_grandtotal = 0;
                            @endphp
                            @foreach($months as $month => $month_name)
                                @php 
                                    $topup = isset($records[$month]['topup']) ? $records[$month]['topup'] : 0; 
                                    $subscription = isset($records[$month]['subscription']) ? $records[$month]['subscription'] : 0;
									$topup_tax = isset($records[$month]['topup_tax']) ? $records[$month]['topup_tax'] : 0; 
                                    $subscription_tax = isset($records[$month]['subscription_tax']) ? $records[$month]['subscription_tax'] : 0;  
									$subscription_grandtotal = isset($records[$month]['subscription_grandtotal']) ? $records[$month]['subscription_grandtotal'] : 0;
									$topup_grandtotal = isset($records[$month]['topup_grandtotal']) ? $records[$month]['topup_grandtotal'] : 0;
                                @endphp

                                <tr align="center">
                                    <th>{{ $month_name }}</th>
                                    <td>{{ number_format($subscription,2) }}</td>
									<td>{{ number_format($subscription_tax,2) }}</td>
									<td>{!! $subscription_grandtotal > 0 ? '<a href="' . route('report_subscription', [$month, $search['year']]) . '">' . number_format($subscription_grandtotal, 2) . '</a>' : number_format($subscription_grandtotal, 2) !!}</td>
									<td>{{ number_format($topup,2) }}</td>
									<td>{{ number_format($topup_tax,2) }}</td>
									<td>{!! $topup_grandtotal > 0 ? '<a href="' . route('report_topup') . '">' . number_format($topup_grandtotal, 2) . '</a>' : number_format($topup_grandtotal, 2) !!}</td>                                                                    									
								</tr>

                                @php 
                                    $total_topup += $topup;
                                    $total_subscription += $subscription; 
									$total_topup_tax += $topup_tax;
                                    $total_subscription_tax += $subscription_tax;
									$total_topup_grandtotal += $topup_grandtotal ;
									$total_subscription_grandtotal += $subscription_grandtotal;
                                @endphp 
							@endforeach                        
                        </tbody>	
                        <tfoot>
                            <tr align="center">
                                <td>Total</td>
                                <td>{{ number_format($total_subscription, 2) }}</td>
								<td>{{ number_format($total_subscription_tax, 2) }}</td>
								<td>{{ number_format($total_subscription_grandtotal, 2) }}</td>
                                <td>{{ number_format($total_topup, 2) }}</td>
                                <td>{{ number_format($total_topup_tax, 2) }}</td>
								<td>{{ number_format($total_topup_grandtotal, 2) }}</td>
                            </tr>
                        </tfoot>					
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
					orderable: false, targets: [1]
				}
			],
			lengthChange: false,
			// buttons: ['copy', 'excel', 'pdf', 'colvis']
			buttons: [
				{ 
					extend: 'excel', 
					className: 'waves-effect waves-light mb-2 mr-2 export-btn', 
					text: 'Export',
					messageTop: function () {
						return 'Report Name Sales Transaction Details Report(Subscription)';
					},
				},
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

		// $('#datatable th.sorting').click(function(e) {
		// 	var no = 0;
		// 	$('#datatable tbody td:first-child').each(function(){
		// 		no++;
		// 		$(this).text(no);
		// 	});
		// });

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

		// $(".popup").fancybox({
		// 	'type': 'iframe',
		// 	'width': 1000,
		// 	'height': 700,
		// 	'autoDimensions': false,
		// 	'autoScale': false
		// });

		$('.select2').select2({
			width: '100%'
		});		

		$('.column-visibility').on('click', '.dt-button-background', ()=>{
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