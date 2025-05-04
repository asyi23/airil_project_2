@extends('layouts.master')

@section('title') Dealer Expenses Reporting @endsection

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
			<h4 class="mb-0 font-size-18">Dealer Expenses Reporting</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Reporting</a>
					</li>
					<li class="breadcrumb-item active">Dealer Expenses</li>
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
										<label>Company</label>
										{!! Form::select('company_id', $company_sel, @$search['company_id'], ['class' => 'form-control select2 select2_active']) !!}  
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
										<label>Admin BD</label>
										{!! Form::select('admin_id', $admin_sel, @$search['admin_id'], ['class' => 'form-control select2 select2_active']) !!}  
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
								<th>Company Name</th>
								<th>Company Code</th>
								<th>Selling Type</th>
								<th>User Name</th>
                                <th>User Type</th>
                                <th>Ads Post</th>
                                <th>Bump</th>
                                <th>Ads Upgrade</th>
                                <th>Total Credit Used</th>
                                <th>Commission</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Assigned Admin</th>
							</tr>
                        </thead>
						<tbody id="table-body" class="detail">
						@if(@$records)
                            @foreach($records as $row)

                                @php 
                                    $commission = number_format($row->total_credit_used * ($setting_commission_rate / 100), 2);
                                @endphp

                                <tr align="center">
									<td>{{ $row->company_name }}</td>
									<td>{{ $row->user_code }}</td>
									<td>{{ App\Repositories\CompanyRepository::selling_type($row->company_selling_type) ?? '-'}}</td>
									<td>{{ $row->user_fullname }}</td>
                                    <td>{{ $row->user_type_name }}</td>
                                    <td>{{ $row->total_ads }}</td>
                                    <td>{{ $row->total_ads_bump }}</td>
                                    <td>{{ $row->total_ads_upgrade }}</td>
                                    <td>{{ number_format($row->total_credit_used, 2) }}</td>
                                    <td>{{ $commission }}</td>
                                    <td>{{ $row->setting_state_name }}</td>
                                    <td>{{ $row->setting_city_name }}</td>								                                                                                                          
                                    <td>{{ $row->assigned_admin }}</td>                                                                        									
								</tr>
							@endforeach
                        
						</tbody>
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
					header:false,
					// customize: function ( xlsx ) {
					// 	var sheet = xlsx.xl.worksheets['sheet1.xml'];
					// 	//Bold Header Row
					// 	$('row[r=3] c', sheet).attr( 's', '2' );
					// 	//Make You Input Cells Bold Too
					// 	$('c[r=A1]', sheet).attr( 's', '2' );
					// 	$('c[r=A2]', sheet).attr( 's', '2' );
					// },
					customizeData: function(data){
						var desc = [];
						desc.push((['', '']));
						if('{{ @$search["admin_id"] }}') {
							desc.push(['Admin BD', '{{ $admin_sel[@$search["admin_id"]] }}']);
						}
						if('{{ @$search["company_id"] }}') {
							desc.push(['Company', '{{ $company_sel[@$search["company_id"]] }}']);
						}
						if('{{ @$search["date"] }}') {
							desc.push(['Date', '{{ @$search["date"] }}']);
						}
						
						data.body.unshift(data.header);
						for (var i = 0; i < desc.length; i++) {
							data.body.unshift(desc[i]);
						};
					}
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