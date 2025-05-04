@extends('layouts.master-without-nav')

@section('title') Business Development Reporting @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr align="center">
                        <th colspan="5">Ad Bump</th>
                    </tr>
                    <tr align="center">
                        <th>Date</th>
                        <th>Ad Title</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Bump Schedule Time</th>
                    </tr>
                </thead>
                <tbody>    
                    @php 
                        $total = 0;             
                    @endphp      
                    @if($records)  
                        @foreach($records as $row)
                        <tr align="center">
                            <td style="white-space:nowrap">{{ $row->bump_date }}</td>
                            <td>{{ $row->ads_title }}</td>
                            <td>{{ ucfirst($row->user_fullname) }}</td>
                            <td>{{ $row->user_type_name }}</td>
                            <td>{{ date('h:i A', strtotime($row->ads_bump_schedule_time)) }}
                        </tr>
                        @php 
                            $total++;
                        @endphp
                        @endforeach
                    
                </tbody>
                <tfoot>
                    <tr align="center" class="font-weight-bold">
                        <td>Total</td>
                        <td>{{ $total }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>                        
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection