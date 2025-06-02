@extends('layouts.master')

@section('title') Company Listing @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}">
<link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css')}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/assets/libs/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .custom-dropdown-container .select2-container {
        width: 100% !important;
    }

    .modal {
        z-index: 1;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }

    #img {
        margin: auto;
        padding-top: 100px;
        padding-bottom: 100px;
        display: block;
        top: 50%;
        left: 50%;
        max-height: 100%;
        max-width: 80%;
        animation-name: zoom;
        animation-duration: 0.5s;
    }

    @keyframes zoom {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }

    .closebtn {
        position: absolute;
        top: 5px;
        right: 35px;
        color: white !important;
        font-size: 50px !important;
        font-weight: bold !important;
        cursor: pointer;
    }

    .closebtn:hover,
    .closebtn:focus {
        color: #cccccc !important;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        #img {
            width: 100%;
        }
    }

    .modal-lg {
        max-width: 50%;
    }
</style>
@endsection

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-md-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><span>Part Listing&nbsp;</span>
                @canany(['form_detail_manage'])
                <a href="{{ route('form_detail_add',$id )}}" class="btn btn-sm btn-outline-success waves-effect waves-light mr-2 mb-1"><i class="fas fa-plus"></i> Add New Part</a>
                @endcanany
            </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">PART</a>
                    </li>
                    <li class="breadcrumb-item active">Listing</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<!-- end page title -->
<!-- start seacrh page -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" action="{{ $submit }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" id="start_date" class="form-control" name="start_date" value="{{ @$search['start_date'] }}" placeholder="Start Date">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" id="end_date" class="form-control" name="end_date" value="{{ @$search['end_date'] }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="keywords">Keywords</label>
                                        <input type="text" id="keywords" class="form-control" name="keywords" value="{{ @$search['keywords'] }}" placeholder="Keywords">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary  waves-effect waves-light mr-2"
                                        name="submit" value="search">
                                        <i class="fas fa-search mr-1"></i> Search
                                    </button>
                                    <button type="submit" class="btn btn-danger  waves-effect waves-light mr-2"
                                        name="submit" value="reset">
                                        <i class="fas fa-times mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" action="{{ $submit }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department_name">Department Name</label>
                                        <input type="text" id="department_name" class="form-control" name="department_name" placeholder="Department name" value="{{ $form->department_equipment->department->department_name}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department_name">Equipment Name</label>
                                        <input type="text" id="department_name" class="form-control" name="department_name" placeholder="Department name" value="{{ $form->department_equipment->department_equipment_name}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="equipment_name">Part Name</label>
                                        <input type="text" id="equipment_name" class="form-control" name="equipment_name" placeholder="Equipment Name" value="{{ $form->form_name}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <div class="button-container" style="display: flex;gap:10px;">
                            <form action="{{ route('form_detail_download',['id' => $form->form_id, 'start_date' => $search['start_date'] ?? null, 'end_date' => $search['end_date'] ?? null]) }}" method="GET">
                                <button type="submit" class="btn btn-success">Download PDF</button>
                            </form>
                            <form action="{{ route('form_detail_delete_listing',$form->form_id) }}" method="GET">
                                <button type="submit" class="btn btn-warning">Delete Recently</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->

</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>End Date</th>
                                    <th>Order No</th>
                                    <th>Quantity</th>
                                    <th>OUM</th>
                                    <th>Remarks</th>
                                    @canany(['form_detail_manage'])
                                    <th>Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            @php
                            $no = $records->firstItem();
                            @endphp
                            <tbody>
                                @forelse ($records as $rows)
                                <tr>
                                    <th>{{$no++}}</th>
                                    <td>
                                        <b>{{ \Carbon\Carbon::parse(@$rows->form_detail_date)->format('Y-m-d') }}</b>
                                    </td>
                                    <td>
                                        <b>{{ \Carbon\Carbon::parse(@$rows->form_detail_end_date)->format('Y-m-d') }}</b>
                                    </td>
                                    <td>
                                        <b>{{ @$rows->form_detail_order_no }}</b>
                                    </td>
                                    <td>
                                        <b>{{ @$rows->form_detail_quantity }}</b>
                                    </td>
                                    <td>
                                        <b>{{ @$rows->form_detail_oum }}</b>
                                    </td>
                                    <td>
                                        <b>{{ @$rows->form_detail_remark }}</b>
                                    </td>
                                    @canany(['form_detail_manage']) <td>
                                        <div class="button-container" style="display: flex;gap:10px;">
                                            <a href=" {{ route('form_detail_edit', $rows->form_detail_id) }}"
                                                class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
                                            <span data-toggle='modal' data-target='#delete'
                                                data-id="{{ $rows->form_detail_id }}" class='delete'><a
                                                    href='javascript:void(0);'
                                                    class='btn btn-sm btn-outline-danger waves-effect waves-light'>Delete</a></span>
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='7'>No Records!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if (@$records->lastPage() > 1)
                <div class="card-footer" style="background-color: white">
                    {{$records->links('pagination::bootstrap-4')}}
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('form_detail_delete') }}">
                    @csrf
                    <div class="modal-body">
                        <h4>Delete this order no ?</h4>
                        <input type="hidden" , name="form_detail_id" id="form_detail_id">
                        <input type="hidden" , name="action" value="delete">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="logoModal" class="modal">
        <span class="closebtn" style="color: white">&times;</span>
        <img src="" alt="" id="img">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" action="{{ $submit }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-md-flex align-items-center justify-content-between">
                                        <h4 class="mb-0 font-size-18"><span>Total Part : &nbsp;</span>
                                            <b>{{ @$total_record }}</b>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js')}}"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script>
    $(document).ready(function(e) {
        //$("#user_role").hide();
        $('.delete').on('click', function() {
            var id = $(this).attr('data-id');
            console.log(id);
            $(".modal-body #form_detail_id").val(id);
        });
    });
</script>
@endsection