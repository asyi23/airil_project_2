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
            <h4 class="mb-0 font-size-18"><span>Department Listing&nbsp;</span>
                <a href="{{ route('company_add') }}" class="btn btn-sm btn-outline-success waves-effect waves-light mr-2 mb-1"><i class="fas fa-plus"></i> Add New</a>
            </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Department</a>
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
                                        <b>{{ @$rows->department_name }}</b>
                                    </td>
                                    <td>
                                        <div class="button-container" style="display: flex;gap:10px">
                                            <a href="{{ route('company_branch_listing', $rows->department_id) }}" class="btn btn-sm btn-outline-primary mb-2">Manage Equipment </a>
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
        $(document).ready(function() {
            $('.suspend').on('click', function() {
                var companyId = $(this).attr('data-id');
                console.log(companyId);
                $('.modal-body #company_id').val(companyId);
            });
            $('.activate').on('click', function() {
                var companyId = $(this).attr('data-id');
                console.log(companyId);
                $('.modal-body #company_id').val(companyId);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#company_status').select2({
                minimumResultsForSearch: Infinity
            });
        });
        $(document).ready(function() {
            $('#sector_id').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        var modal = document.getElementById("logoModal");
        var modalImg = document.getElementById("img");

        // Get all images with class "company-logo-clickable"
        var images = document.querySelectorAll(".company-logo-clickable");

        // Loop through each image and attach a click event
        images.forEach(function(img) {
            img.onclick = function() {
                modal.style.display = "flex";
                modalImg.src = this.src;
            }
        });

        var span = document.getElementsByClassName("closebtn")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
    <script>
        $('#listingModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var companyId = button.data('company-id');
            $('.notfound').hide();
            var modal = $(this);

            var companyData = $('#company-' + companyId + '-data').html();
            $('#user-listing-data-placeholder').html(companyData);

            $('#search').val('');

            var $userListingRows = $('#company-' + companyId + '-data #user-listing tbody tr');
            var $searchInput = $("#search");

            $.expr[":"].contains = $.expr.createPseudo(function(arg) {
                return function(elem) {
                    return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });

            $("#search").keyup(function() {
                var search = $(this).val().toLowerCase();
                $('#user-listing tbody tr').hide();
                var len = $('#company-' + companyId + '-data #user-listing tbody tr:not(.notfound) ').filter(function() {
                    var cell2Text = $(this).find('td:nth-child(2)').text().toLowerCase().trim();
                    var cell3Text = $(this).find('td:nth-child(3)').text().toLowerCase().trim();
                    var cell4Text = $(this).find('td:nth-child(6)').text().toLowerCase().trim();

                    return (
                        cell2Text.includes(search) ||
                        cell3Text.includes(search) ||
                        cell4Text.includes(search)
                    );
                }).length;

                if (len > 0) {
                    $('table tbody tr:not(.notfound) td:contains("' + search + '"):not(.user_button):not(.user_mobile):not(.role)').each(function() {
                        $(this).closest('tr').show();
                    });
                } else {
                    $('.notfound').show();
                }

            });

            $('#closeModalBtn').click(function() {
                $('#search').val('');
                $("#user-listing tbody tr").show();
                console.log("g");
            });
        });
    </script>
    <!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the input and table body elements
        var searchInput = document.getElementById('search');
        var userTableBody = document.getElementById('user-listing');

        // Add an input event listener to the search input
        searchInput.addEventListener('input', function () {
            var searchTerm = searchInput.value.toLowerCase();

            // Filter the table rows based on the search term
            var filteredRows = Array.from(userTableBody.children).filter(function (row) {
                var rowData = row.textContent.toLowerCase();
                return rowData.includes(searchTerm);
            });

            // Update the table body with the filtered rows
            userTableBody.innerHTML = '';

            if (filteredRows.length > 0) {
                filteredRows.forEach(function (row) {
                    userTableBody.appendChild(row.cloneNode(true));
                });
            } else {
                // Display a message when no results are found
                var noResultRow = document.createElement('tr');
                var noResultCell = document.createElement('td');
                noResultCell.setAttribute('colspan', '7'); // Adjust the colspan based on the number of columns
                noResultCell.textContent = 'No results found!';
                noResultRow.appendChild(noResultCell);
                userTableBody.appendChild(noResultRow);
            }
        });
    });
</script> -->
    @endsection