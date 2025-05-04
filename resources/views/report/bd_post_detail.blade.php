@extends('layouts.master-without-nav')

@section('title') Business Development Reporting @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr align="center">
                        <th colspan="4">Ads Post</th>
                    </tr>
                    <tr align="center">
                        <th>Date</th>
                        <th>Ads Title</th>
                        <th>User</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id="history_detail">    
                    @php 
                        $total = 0;             
                    @endphp      
                    @if($records)  
                        @foreach($records as $row)
                    
                        <tr align="center">
                            <td style="white-space:nowrap">{{ date('Y-m-d', strtotime($row->ads_date_display)) }}</td>
                            <td>{{ $row->ads_title }}</td>
                            <td>{{ ucfirst($row->user_fullname) }}</td>
                            <td>{{ $row->user_type_name }}</td>
                        </tr>
                        @php 
                            $total++;
                        @endphp
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr align="center" class="font-weight-bold">
                        <td>Total</td>
                        <td>{{ $total }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection