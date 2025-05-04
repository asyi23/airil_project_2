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
                <a href="{{ route('form_add',$id )}}" class="btn btn-sm btn-outline-success waves-effect waves-light mr-2 mb-1"><i class="fas fa-plus"></i> Add New Form</a>
            </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Form</a>
                    </li>
                    <li class="breadcrumb-item active">Listing</li>
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
                <div class="row">
                    <div class="col">
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department_name">Department Name</label>
                                        <input type="text" id="department_name" class="form-control" name="department_name" placeholder="Department name" value="{{ $department_equipment->department->department_name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department_name">Equipment Name</label>
                                        <input type="text" id="department_name" class="form-control" name="department_name" placeholder="Department name" value="{{ $department_equipment->department_equipment_name}}" readonly>
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
                        <table id="tech-companies-1" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
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
                                        <b>{{ @$rows->form_name }}</b>
                                    </td>
                                    <td>
                                        <div class="button-container" style="display: flex;gap:10px">
                                            <a href="{{ route('form_detail_listing', $rows->form_id) }}" class="btn btn-sm btn-outline-primary mb-2">Manage Form </a>
                                            <span><a href=" {{ route('form_edit', $rows->form_id) }}"
                                                    class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a></span>
                                            <span data-toggle='modal' data-target='#delete'
                                                data-id="{{ $rows->form_id }}" class='delete'><a
                                                    href='javascript:void(0);'
                                                    class='btn btn-sm btn-outline-danger waves-effect waves-light'>Delete</a></span>
                                        </div>
                                    </td>
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

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('form_delete') }}">
                    @csrf
                    <div class="modal-body">
                        <h4>Delete this part ?</h4>
                        <input type="hidden" , name="department_equipment_id" id="department_equipment_id">
                        <input type="hidden" , name="action" value="delete">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Page-content -->
        <div class="modal fade" id="suspend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{ route('company_status')}}">
                        @csrf
                        <div class="modal-body">
                            <h4 style="margin-bottom: 10px">Suspend this company ?</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="company_remark" style="font-size: 14px">Remark<span class="text-danger">*</span></label>
                                        <input id="company_remark" name="company_remark" type="text" class="form-control input-mask text-left" im-insert="true" style="text-align: right;margin-bottom:-10px;" required>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="company_id" id="company_id">
                            <input type="hidden" name="action" value="suspend">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Suspend</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{ route('company_status') }}">
                        @csrf
                        <div class="modal-body">
                            <h4>Activate this company ?</h4>
                            <input type="hidden" name="company_id" id="company_id">
                            <input type="hidden" , name="action" value="activate">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Activate</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="listingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Listing</h5>
                        <span class="close" id="closeModalBtn" data-dismiss="modal" style="cursor: pointer;font-weight:bold;font-size:30px;">&times;</span>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="company-id-input" value="">
                        <input type="search" class="form-control" name="search" id="search" placeholder="Search by Full Name/Username/Email/Branch" style="margin-bottom: 10px">
                        <div id="user-listing-data-placeholder"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="logoModal" class="modal">
            <span class="closebtn" style="color: white">&times;</span>
            <img src="" alt="" id="img">
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