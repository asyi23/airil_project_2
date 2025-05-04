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
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary  waves-effect waves-light mb-2 mr-2" name="submit" value="search">
                            <i class="fas fa-search mr-1"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mb-2 mb-md-0">
    <div class="col-12 text-center font-weight-bold font-size-18">
        {{ $company_name }}
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-2">
        <div class="card">
            <div class="card-body">
                Post
                <div class="report-detail">{{ $records['total_ads'] }}</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Bump
                <div class="report-detail">{{ $records['total_ads_bump'] }}</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Topup 
                <div class="report-detail">{{ $records['total_topup'] }}</div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Spend
                <div class="report-detail"> {{ $records['total_spend'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-10">
        <div id="line_chart_dashed"></div>
    </div>
</div>


@endsection

@section('script')
<script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/daterangepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script>
    $(document).ready(function() {
        var options = {
            chart: {
                height: 450,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#da9700', '#556ee6', '#34c38f', '#f46a6a'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [3, 3, 3, 3],
                curve: 'straight',
                dashArray: [0, 0, 0, 0]
            },
            series: [{
                name: "Post",
                data: {!! json_encode(array_values($records['ads'])) !!},
            }, {
                name: "Bump",
                data: {!! json_encode(array_values($records['bump'])) !!},
            }, {
                name: 'Topup',
                data: {!! json_encode(array_values($records['topup'])) !!},
            }, {
                name: 'Spend',
                data: {!! json_encode(array_values($records['spend'])) !!},
            }],
            title: {
                text: undefined,
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: {!! json_encode(array_values($records['dates'])) !!},
                labels: {
                    show: false,
                },
                tooltip: {
                    enabled: false
                }
            },
            tooltip: {
                y: [{
                    title: {
                        formatter: function formatter(val) {
                            return val;
                        }
                    }
                }, {
                    title: {
                        formatter: function formatter(val) {
                            return val;
                        }
                    }
                }, {
                    title: {
                        formatter: function formatter(val) {
                            return val;
                        }
                    }
                }],
            },
            grid: {
                borderColor: '#f1f1f1'
            }
        };
        var chart = new ApexCharts(
            document.querySelector("#line_chart_dashed"),
            options
        );
        chart.render();

        var start = moment().subtract(30, 'days');
		var end = moment();

		var search_date = '{{ @$date }}';
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