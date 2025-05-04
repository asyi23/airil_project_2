@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/tui-chart/tui-chart.min.css')}}">
<style>
    .tui-chart-chartExportMenu-button {
        display: none;
    }

    .custom-card-h {
        height: 550px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dashboard</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back Airil!</h5>
                            <!-- <p>Skote Dashboard</p> -->
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="avatar-md profile-user-wid mb-4">
                            @if(Auth::user()->hasMedia('user_profile_picture'))
                            <img src="{{Auth::user()->getFirstMediaUrl('user_profile_picture')}}" alt="" class=" rounded-circle" height="72" width="72" style="border: 5px solid #f6f6f6;">
                            @else
                            <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-9">

                        <div class="pt-4">

                            <h5 class="font-size-15 text-truncate">{{{ ucfirst(Auth::user()->user_fullname)  }}}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ isset(AUTH::user()->roles[0]) ? AUTH::user()->roles[0]->name: "" }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection