@extends('layouts.master-without-nav')

@section('title') Business Development Reporting @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/daterangepicker.css')}}" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ $submit }}">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                    <input type="text" id="reportrange" class="form-control" name="date" value="{{ @$search['date'] }}" placeholder="Date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::select('user_id', $user_sel, @$search['user_id'] , ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  waves-effect waves-light mb-2 mr-2" name="submit" value="search">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr align="center">
                        <th colspan="5">Ad Credit Summary</th>
                    </tr>
                    <tr align="center">
                        <th>User</th>
                        <th>Topup</th>
                        <th>Spend</th>
                        <th>Spend Premier</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                @if($credit_summary)
                <tbody>
                    @php
                        $total_topup = 0;
                        $total_spend = 0;
                        $total_spend_premier = 0;
                        $total_balance = 0;
                    @endphp

                    @foreach($credit_summary as $val)
                    <tr align="center">
                        <td style="white-space:nowrap">{{ ucfirst($val->user_fullname) }}</td>
                        <td>{{ number_format($val->topup,2) }}</td>
                        <td>{{ number_format($val->spend, 2) }}</td>
                        <td>{{ number_format($val->spend_premier, 2) }}</td>
                        <td>{{ number_format($val->balance, 2) }}</td>
                    </tr>
                        @php
                            $total_topup += $val->topup;
                            $total_spend += $val->spend;
                            $total_spend_premier += $val->spend_premier;
                            $total_balance += $val->balance;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr align="center" class="font-weight-bold">
                        <td>Total</td>
                        <td>{{ number_format($total_topup, 2) }}</td>
                        <td>{{ number_format($total_spend, 2) }}</td>
                        <td>{{ number_format($total_spend_premier, 2) }}</td>
                        <td>{{ number_format($total_balance, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr align="center">
                        <th colspan="6">Ad Credit History</th>
                    </tr>
                    <tr align="center">
                        <th>Date</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Credit</th>
                        <th>Credit Type</th>
                        <th>Description</th>
                    </tr>
                </thead>
                @if(count($records) > 0)
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($records as $row)
                    <tr align="center">
                        <td style="white-space:nowrap">{{ $row->user_credit_history_date }}</td>
                        <td>{{ ucfirst($row->user_fullname) }}</td>
                        <td>{{ $row->user_type_name }}</td>
                        <td>{{ $row->credit }}</td>
                        <td>{{ ucfirst($row->user_credit_type_name) }}</td>
                        <td>{{ $row->user_credit_description }}</td>
                    </tr>
                        @php
                            $total += $row->credit;
                        @endphp
                    @endforeach
                </tbody>
                @else
                <tr>
                    <td colspan="6">No record found.</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr align="center">
                    <th colspan="6">Ad Credit History Premier</th>
                </tr>
                <tr align="center">
                    <th>Date</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Credit</th>
                    <th>Credit Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                @if(count($records_premier) > 0)
                    <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($records_premier as $row)
                        <tr align="center">
                            <td style="white-space:nowrap">{{ $row->user_credit_history_date }}</td>
                            <td>{{ ucfirst($row->user_fullname) }}</td>
                            <td>{{ $row->user_type_name }}</td>
                            <td>{{ $row->credit }}</td>
                            <td>{{ ucfirst($row->user_credit_type_name) }}</td>
                            <td>{{ $row->user_credit_description }}</td>
                        </tr>
                        @php
                            $total += $row->credit;
                        @endphp
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td colspan="6">No record found.</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script>
    $(document).ready(function() {

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
    });
</script>
@endsection
