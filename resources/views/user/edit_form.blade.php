@extends('layouts.master')

@section('title') {{ $title }} User @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ $title }} User </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">User </a>
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
                    <h4 class="card-title mb-4">User Details</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user_email">Email<span class="text-danger">*</span></label>
                                <input name="user_email" type="email" class="form-control" value="{{ @$post->user_email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="user_fullname">Full Name<span class="text-danger">*</span></label>
                                <input name="user_fullname" type="text" class="form-control" value="{{ @$post->user_fullname }}">
                            </div>
                            <div class="form-group">
                                <label for="user_mobile">Mobile No<span class="text-danger">*</span></label>
                                <input name="user_mobile" type="number" class="form-control" value="{{ @$post->user_mobile }}">
                            </div>
                            <div class="form-group">
                                <label for="user_nric">NRIC<span class="text-danger">*</span></label>
                                <input name="user_nric" type="text" class="form-control" value="{{ @$post->user_nric }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="user_nationality">Nationality<span class="text-danger">*</span></label>
                                <input name="user_nationality" type="text" class="form-control" value="{{ @$post->user_nationality }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Gender<span class="text-danger">*</span></label>
                                {!! Form::select('user_gender', $user_gender_sel, @$post->user_gender, ['class' => 'form-control','id' => 'user_gender']) !!}
                            </div>
                            <div class="form-group">
                                <label for="user_dob">Date of Birth<span class="text-danger">*</span></label>
                                <div class="input-group-append">
                                    <input name="user_dob" type="text" class="form-control" id="datepicker" placeholder="yyyy-mm-dd" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" value="{{ @$post->user_dob }}">
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">User Type<span class="text-danger">*</span></label>
                                {!! Form::select('user_type_id', $user_type_sel, @$post->user_type_id , ['class' => 'form-control','id' => 'user_type','disabled']) !!}
                            </div>
                            {{-- <div class="form-group" id="user_role" @if(@$post->user_type_id != 1) style="display:none" @endif>
                                <label class="control-label">User Role</label>
                                {!! Form::select('user_role_id', $user_role_sel, (@$post->user_role_id?$post->user_role_id:@$user_role->id), ['class' => 'form-control', 'id' => 'user_role']) !!}
                            </div> --}}
                            <div id="company_details" @if(@$post->user_type_id!=2 ?? true) style="display:none"@endif>
                                <div class="form-group">
                                    <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                    <input name="company_name" type="text" class="form-control" value="{{ @$post->company_name ?? @$post->user_company->company_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_regno">Company Reg. No.<span class="text-danger">*</span></label>
                                    <input name="company_regno" type="text" class="form-control" value="{{ @$post->company_regno ?? @$post->user_company->company_regno }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="company_phone">Company Phone<span class="text-danger">*</span></label>
                                    <input id="input-mask" name="company_phone" class="form-control input-mask text-left" data-inputmask="'mask': '999-99999999','clearIncomplete':'true','removeMaskOnSubmit':'true'" im-insert="true" style="text-align: right;" value="{{ @$post->company_phone ?? @$post->user_company->company_phone }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_email">Company Email<span class="text-danger">*</span></label>
                                    <input name="company_email" type="email" class="form-control" value="{{ @$post->company_email ?? @$post->user_company->company_email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="company_website">Company Website</label>
                                    <input name="company_website" type="text" class="form-control" value="{{ @$post->company_website ?? @$post->user_company->company_website }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_address">Company Address<span class="text-danger">*</span></label>
                                    <input name="company_address" type="text" class="form-control" value="{{ @$post->company_address ?? @$post->user_company->company_address }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_postcode">Company Postcode<span class="text-danger">*</span></label>
                                    <input name="company_postcode" type="text" class="form-control" max="5" value="{{ @$post->company_postcode ?? @$post->user_company->company_postcode }}">
                                </div>
                                <div class="form-group">
                                    <label for="company_state_id">Company State<span class="text-danger">*</span></label>
                                    {{-- <input name="company_state_id" type="text" class="form-control" value="{{ @$post->company_state_id }}"> --}}
                                    {!! Form::select(
                                    'company_state_id',
                                    $state_sel,
                                    @$post->company_state_id ?? @$post->user_company->company_state_id,
                                    ['class' => 'form-control state','id' => 'company_state_id'])
                                    !!}
                                </div>
                                <div class="form-group">
                                    <label for="company_city_id">Company City<span class="text-danger">*</span></label>
                                    {{-- <input id="company_city_id" name="company_city_id" type="text" class="form-control" value="{{ @$post->company_city_id }}"> --}}
                                    {!! Form::select(
                                    'company_city_id',
                                    @$post ? $city_sel : [],
                                    @$post->company_city_id ?? @$post->user_company->company_city_id ?? '',
                                    ['class' => 'form-control','id' => 'company_city_id'])
                                    !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Identification Card Copy</label>
                                    @if (@$has_ic)
                                        <a target="_blank" href="{{ route('download_user_document_ic',$user_document->getFirstMedia('user_ic')->model_id) }}" class="form-text text-primary">Download</a>
                                    @else
                                        <input name="ic" type="file" class="form-control">
                                        <small class="form-text text-muted">Only .jpeg, .png, .jpg, .pdf, .doc, .docx, .xls and .xlsx file extension are allowed.</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">SSM Copy</label>
                                    @if (@$has_business_card)
                                        <a target="_blank" href="{{ route('download_user_document_card',$user_document->getFirstMedia('user_business_card')->model_id) }}" class="form-text text-primary">Download</a>
                                    @else
                                        <input name="business_card" type="file" class="form-control">
                                        <small class="form-text text-muted">Only .jpeg, .png, .jpg, .pdf, .doc, .docx, .xls and .xlsx file extension are allowed.</small>
                                    @endif
                                </div>
                            </div>
                            <div id="sales_agent_details" @if(@$post->user_type_id!=3 ?? true) style="display:none"@endif>
                                <div class="form-group">
                                    <label for="sales_agent_company_regno">Company Reg. No.<span class="text-danger">*</span></label>
                                    {{-- {{ dd($post->toArray()) }} --}}
                                    <input readonly name="sales_agent_company_regno" type="text" class="form-control" 
                                        value="{{ @$post->company_regno ?? @$post->sales_agent_company_regno ?? @$post->user_company->company_regno ?? @$post->join_company->company->company_regno }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Identification Card Copy</label>
                                    @if (@$has_ic)
                                        <a target="_blank" href="{{ route('download_user_document_ic',$user_document->getFirstMedia('user_ic')->model_id) }}" class="form-text text-primary">Download</a>
                                    @else
                                        <input name="sa_ic" type="file" class="form-control">
                                        <small class="form-text text-muted">Only .jpeg, .png, .jpg, .pdf, .doc, .docx, .xls and .xlsx file extension are allowed.</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">SSM Copy</label>
                                    @if (@$has_business_card)
                                        <a target="_blank" href="{{ route('download_user_document_card',$user_document->getFirstMedia('user_business_card')->model_id) }}" class="form-text text-primary">Download</a>
                                    @else
                                        <input name="sa_business_card" type="file" class="form-control">
                                        <small class="form-text text-muted">Only .jpeg, .png, .jpg, .pdf, .doc, .docx, .xls and .xlsx file extension are allowed.</small>
                                    @endif
                                </div>
                            </div>
                            <div id="broker_details" @if(@$post->user_type_id!=4 ?? true) style="display:none"@endif>
                                <div class="form-group">
                                    <label for="broker_ic">Identification Card Copy<span class="text-danger">*</span></label>
                                    @if (@$has_ic)
                                        <a target="_blank" href="{{ route('download_user_document_ic',$user_document->getFirstMedia('user_ic')->model_id) }}" class="form-text text-primary">Download</a>
                                    @else
                                        <input name="broker_ic" type="file" class="form-control">
                                        <small class="form-text text-muted">Only .jpeg, .png, .jpg, .pdf, .doc, .docx, .xls and .xlsx file extension are allowed.</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <input name="password" type="password" class="form-control" value="{{ @$post->password }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a href="{{ route('user_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user_address">Address 1</label>
                                <input name="user_address" type="text" class="form-control" value="{{ @$post->user_address }}">
                            </div>
                            <div class="form-group">
                                <label for="user_address2">Address 2</label>
                                <input name="user_address2" type="text" class="form-control" value="{{ @$post->user_address2 }}">
                            </div>
                            <div class="form-group">
                                <label for="user_postcode">Postcode</label>
                                <input name="user_postcode" type="text" class="form-control" value="{{ @$post->user_postcode }}">
                            </div>
                            <div class="form-group">
                                <label for="user_city">City</label>
                                <input name="user_city" type="text" class="form-control" value="{{ @$post->user_city }}">
                            </div>
                            <div class="form-group">
                                <label for="user_state">State</label>
                                <input name="user_state" type="text" class="form-control" value="{{ @$post->user_state }}">
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
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- Plugins js -->
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>

<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>

<script>
    $(document).ready(function(e) {
        //$("#company_details").hide();
        //$("#sales_agent_details").hide();
        $('#user_type').on('change', function() {
            if (this.value == 2) {
                $("#company_details").show();
                $("#sales_agent_details").hide();
                $("#broker_details").hide();
            } else if (this.value == 3) {
                $("#company_details").hide();
                $("#sales_agent_details").show();
                $("#broker_details").hide();
            } else if (this.value == 4) {
                $("#company_details").hide();
                $("#sales_agent_details").hide();
                $("#broker_details").show();
            } else {
                $("#user_role").hide();
                $("#company_details").hide();
                $("#sales_agent_details").hide();
                $("#broker_details").hide();
            }
        });
        $('.state').on('change', function() {
            var state_id = $(this).val();
            var state_type = this.id;

            if (state_type == 'company_state_id') {
                city_type = '#company_city_id';
            } else if (state_type == 'invoice_state_id') {
                city_type = '#invoice_city_id';
            }

            $(city_type).html('');
            $(city_type).attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_city_sel')}}",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if (e.status) {
                        $(city_type).attr('disabled', false);
                        $(city_type).append('<option value>Please select city</option>');
                        $.each(e.data, function(k, v) {
                            $(city_type).append('<option value=' + k + '>' + v + '</option>');
                        });
                    }
                }
            });
        });
    });
</script>
@endsection