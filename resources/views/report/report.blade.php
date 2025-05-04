@extends('layouts.master')

@section('title') Export  @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/daterangepicker.css')}}" />
@endsection

@section('content')
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">REPORT</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					{{-- <li class="breadcrumb-item">
						<a href="javascript: void(0);">Remove User</a>
					</li>
					<li class="breadcrumb-item active">Form</li> --}}
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
        <form method="POST" action="{{ route('report') }}">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>REPORT</label>
                            <div class="form-group">

                                {{-- <select name="user_id" class="form-control select2 select2_active">
                                    @foreach($bd_sel as $key => $val)
                                        <option value="{{$key}}" {{ $key == @$search['user_id'] ? 'selected' : '' }} >{{$val}}</option>
                                    @endforeach
                                </select> --}}
                                {!! Form::select('report_bd_sel', $report_bd_sel, @$post->bd_sel, ['class' => 'form-control select_active report_type']) !!}
                            </div>

                        </div>
                        <div class="col-md-3 date" style="display: none">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" id="reportrange" class="form-control select_active" name="date" value="{{ @$search['date'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-0">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="submit" value="export">
                                <i class="mdi mdi-export mr-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/moment.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/daterangepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>

    <script>
        $(document).ready(function(){


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

        $('.report_type').on('change', function(){
            var val = $(this).val();
            if(val == 2){
                $('.date').css('display','block');
            }else{
                $('.date').css('display','none');
            }
        });


    </script>
@endsection
