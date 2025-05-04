@extends('layouts.master')

@section('title') {{ $title }} Ads @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }} Ads</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Ads</a>
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
    @endif


    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">{{ $title }} Ads Details</h4>
            <form method="POST" onsubmit="$('#btn_submit').prop('disabled', true)">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="duplicate_from_user_id">Duplicate From</label>
                                    <select name="duplicate_from_user_id" class="form-control select2 select2_active" onchange="ajax_get_ads_list(this.value)"
                                            id="duplicate_from_user_id">
                                        <option value="">Please select user</option>
                                        @foreach($user_sel as $user_type_name => $row)
                                            <optgroup label="{{ $user_type_name }}">
                                                @foreach($row as $key => $val)
                                                    <option
                                                        value="{{ $key }}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{ $val }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="duplicate_to_user_id">Duplicate To</label>
                                    <select name="duplicate_to_user_id" class="form-control select2 select2_active"
                                            id="duplicate_to_user_id">
                                        <option value="">Ads Owner</option>
                                        @foreach($user_sel as $user_type_name => $row)
                                            <optgroup label="{{ $user_type_name }}">
                                                @foreach($row as $key => $val)
                                                    <option
                                                        value="{{ $key }}" {{ $key == @$search['user_id'] ? 'selected' : '' }}>{{ $val }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto mb-4">
                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" id="btn_submit">Submit</button>
                        <a href="{{ route('ads_listing') }}" class="btn btn-secondary" type="button">Cancel</a>
                    </div>
                    <div class="col-12">
                        <div class="form-check d-flex align-items-center mb-2">
                            <input type="checkbox" class="form-check-input mt-0" id="check_all">
                            <label class="mb-0" for="check_all">Select All</label>
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">
                                    Ads
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tbody_ads_list">
                            <tr>
                                <td>No Ads</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/libs/select2/select2.min.js')}}"></script>

    <script>
        function ajax_get_ads_list(user_id){
            $("#check_all").prop('checked', false);
            $('#tbody_ads_list').html('<tr><td>loading...</td></tr>');

            $.post('{{ route("ajax_get_ads_list") }}', {
                'user_id': user_id,
                '_token': '{{csrf_token()}}'
            }, function (data) {
                $('#tbody_ads_list').html(data);
            });
        }

        $("#check_all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
