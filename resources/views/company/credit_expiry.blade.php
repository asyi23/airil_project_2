@extends('layouts.master')

@section('title') {{ $title }} Company Credit Expiry @endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $title }} Company</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Company</a>
                    </li>
                    <li class="breadcrumb-item active">Form</li>
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
        <form method="POST" action="{{ $submit }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title mb-4">Company Credit Expiry</h4> -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="company_name">Company Credit Expiry</label>
                                <div>{{ @$company->company_credit_expired }}</div>
                            </div>
                            <div class="form-group">
                                <label for="company_name">Days</label>
                                <input name="days" type="number" class="form-control days" maxlength="4" />
                            </div>
                            <div class="form-group">
                                <label for="company_name">New Company Credit Expiry</label>
                                <div class="new-company-credit-expiry"> - </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('company_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.days').on('keyup', function() {
            $('.new-company-credit-expiry').text('-');
            if($(this).val() && $(this).val() < 100000) {
                var d = '{{ @$company->company_credit_expired < now() ? now() : @$company->company_credit_expired }}';
                var date = new Date(d);

                date.setDate(date.getDate() + parseInt($(this).val())); 
                var two_digit_month = ('0' + (date.getMonth()+1)).slice(-2);
                var two_digit_day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                var display_date = date.getFullYear() + '-' + two_digit_month + '-' + two_digit_day; 
                // alert(display_date);
                
                $('.new-company-credit-expiry').text(display_date);
            }
        })
    });
</script>
@endsection