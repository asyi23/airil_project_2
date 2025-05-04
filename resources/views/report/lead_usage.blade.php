@extends('layouts.master')

@section('title') Lead Usage Reporting @endsection

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
            <h4 class="mb-0 font-size-18">Lead Usage Reporting</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Reporting</a>
                    </li>
                    <li class="breadcrumb-item active">Lead Usage Reporting</li>
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
                <form method="POST" action="{{ route('report_lead_usage') }}">
                    @csrf
                    <div class="row mb-2">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_brand_id">Company</label>
                                {!! Form::select('company_id', $company_sel, @$search['company_id'], ['class' => 'form-control select2 select2_active']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_brand_id">User Type</label>
                                {!! Form::select('user_type_id', $user_type_sel, @$search['user_type_id'], ['class' => 'form-control select2 select2_active']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_id">User</label>
                                {!! Form::select('user_id', $user_sel, @$search['user_id'], ['class' => 'form-control select2 select2_active']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" id="reportrange" class="form-control select_active" name="date" value="{{ @$search['lead_user_created'] }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group action-button d-md-flex">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light mb-2 mr-2" name="submit" value="search">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                            </div>
                        </div>
                        <div id="table-container" class="table-responsive font-size-11">
                            <table id="datatable" class="table table-bordered w-100 display nowrap">
                                <thead id="table-header" class="thead-light">
                                    <tr align="center">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">User</th>
                                        <th colspan="3">Trade in Request</th>
                                        <th colspan="3">New Car Lead</th>
                                        <th rowspan="2">Total lead</th>
                                    </tr>
                                    <tr align="center">
                                        <th>Free Lead</th>
                                        <th>Lead</th>
                                        <th>Exclusive</th>
                                        <th>Free Lead</th>
                                        <th>Lead</th>
                                        <th>Exclusive</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class="detail">
                                    @if(@$records)
                                    @php
                                    $no = 0;
                                    $total_TradeFree = 0;
                                    $total_TradeLead = 0;
                                    $total_TradeExclusive = 0;
                                    $total_NewFreeLead = 0;
                                    $total_NewLead = 0;
                                    $total_NewExclusive = 0;
                                    $sum_TotalLead =0 ;
                                    @endphp

                                    @foreach($records as $key=>$row)
                                    @php
                                    $TotalLead = 0;
                                    $TotalLead = $records[$key]->TradeFreeLead  + $records[$key]->TradeLead + $records[$key]->TradeExclusive  + $records[$key]->NewFreeLead + $records[$key]->NewLead + $records[$key]->NewExclusive;
                                    @endphp
                                    <tr align="center">
                                        <td>{{ ++$no }}</td>
                                        <td style="width: 10%" class="text-capitalize">{{ $row->username }}<br />{{ $row->company_name }}<br /><span class="badge badge-sm badge-secondary">{{ $row->user_type_name }}</span></td>
                                        <td>{{ $row->TradeFreeLead }}</td>
                                        <td>{{ $row->TradeLead }}</td>
                                        <td>{{ $row->TradeExclusive }}</td>
                                        <td>{{ $row->NewFreeLead }}</td>
                                        <td>{{ $row->NewLead }}</td>
                                        <td>{{ $row->NewExclusive }}</td>
                                        <td>{{ $TotalLead}}</td>
                                    </tr>

                                    @php
                                        $total_TradeFree += $row->TradeFreeLead;
                                        $total_TradeLead += $row->TradeLead;
                                        $total_TradeExclusive += $row->TradeExclusive;
                                        $total_NewFreeLead += $row->NewFreeLead;
                                        $total_NewLead += $row->NewLead;
                                        $total_NewExclusive += $row->NewExclusive;
                                        $sum_TotalLead += $TotalLead;
                                    @endphp

                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                <tr align="center" class="font-weight-bold">
                                    <td>Total</td>
                                    <td> - </td>
                                    <td> {{$total_TradeFree}} </td>
                                    <td> {{$total_TradeLead}} </td>
                                    <td> {{$total_TradeExclusive}} </td>
                                    <td> {{$total_NewFreeLead}} </td>
                                    <td> {{$total_NewLead}} </td>
                                    <td> {{$total_NewExclusive}} </td>
                                    <td> {{$sum_TotalLead }} </td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </form>
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
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            paging: false,
            info: false,
            searching: false,
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0,1,2,3,4,5,6,7,8]
            }],
            lengthChange: false,
            buttons: [{
                    extend: 'excel',
                    className: 'waves-effect waves-light mb-2 mr-2 export-btn',
                    text: 'Export'
                },
            ],
        });
        table.buttons().container().appendTo('.action-button');
        var start = moment().subtract(30, 'days');
        var end = moment();
        var search_date = '{{ @$search["date"] }}';
        if (search_date) {
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

        $("#datatable").parent().css('overflow-x', 'scroll');
    })
</script>
@endsection
