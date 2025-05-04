@extends('layouts.master')

@section('title')
    User Listing
@endsection

@section('css')
    {{-- <link href="{{URL::asset('lightbox2/src/css/lightbox.css')}}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.min.css') }}">
    <link href="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/assets/libs/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
    <style>
        .custom-dropdown-container .select2-container {
            width: 100% !important;
        }

    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-md-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18"><span class="mr-3 ">{{ $type }} Listing</span>
                    @can ('user_manage')
                        <a href="{{ @$submit_new }}">
                            <button type="button" class="btn btn-outline-success waves-effect waves-light btn-sm">
                                <i class="mdi mdi-plus mr-1"></i> Add New
                            </button>
                        </a>
                    @endcan
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">User</a>
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
                            <form method="POST" action="{{ $submit }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03">Freetext</label>
                                            <input type="text" class="form-control select_active" name="freetext"
                                                placeholder="Search for..." value="{{ @$search['freetext'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group custom-dropdown-container">
                                            <label for="validationCustom03">User Status</label>
                                            {!! Form::select('user_status', $user_status_sel, @$search['user_status'], [
                                                'class' => 'form-control select2',
                                                'id' => 'user_status',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group custom-dropdown-container">
                                            <label for="validationCustom03">User Role</label>
                                            {!! Form::select('user_role_id', $user_role, @$search['user_role_id'], [
                                                'class' => 'form-control select2',
                                                'id' => 'user_role_id',
                                            ]) !!}
                                        </div>
                                    </div>
                                    @if (Auth::user()->roles->value('id') == 3)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03"> User Branch</label>
                                            {!! Form::select('branch_id', $branch, @$search['branch_id'], ['class' => 'form-control select2', 'id' => 'branch_id']) !!}									</div>
                                    </div>
                                    @endif
                                    @if ($group_type == 'administrator')
                                        <div class="col-md-4">
                                            <div class="form-group custom-dropdown-container">
                                                <label for="validationCustom03">User Company</label>
                                                {!! Form::select('company_id', $company_sel, @$search['company_id'], [
                                                    'class' => 'form-control select2',
                                                    'id' => 'company_id',
                                                ]) !!}
                                            </div>
                                        </div>
                                    @endif
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
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>User Profile</th>
                                    <th>User Company</th>
                                    <th>User Role</th>
                                    <th>Status</th>
                                    @can('user_manage')
                                        <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $users->firstItem();
                                ?>
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <?php
                                        $status = '';
                                        $assign_permission = '';
                                        $action = '';
                                        switch ($user->user_status) {
                                            case 'active':
                                                $status = "<span class='badge badge-primary font-size-11'>" . ucwords($user->user_status) . '</span>';
                                                if(Auth::user()->roles->value('id') != '4'){
                                                    $assign_permission = "<a href='" . route('user_assign_permission', $user->user_id) . "' class='btn btn-sm btn-outline-primary waves-effect waves-light'>Assign Permission</a>";
                                                }
                                                $action =
                                                    "{$assign_permission}
                                                    <a href='" .route('user_edit', $user->user_id) ."' class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
                                                    <span data-toggle='modal' data-target='#suspend' data-id='$user->user_id' class='suspend'><a href='javascript:void(0);' class='btn btn-sm btn-outline-danger waves-effect waves-light'>Suspend</a></span>";
                                                break;
                                            case 'suspend':
                                                $status = "<span class='badge badge-danger'>" . ucwords($user->user_status) . '</span>';
                                                $action = "<span data-toggle='modal' data-target='#activate' data-id='$user->user_id' class='activate'><a href='javascript:void(0);' class='btn btn-sm btn-outline-success waves-effect waves-light'>Activate</a></span>";
                                                break;
                                            case 'pending':
                                                $status = "<span class='badge badge-warning'>" . ucwords($user->user_status) . '</span>';
                                                break;
                                        }

                                        ?>
                                        <tr>
                                            <td>
                                                {{ $no++ }}
                                            </td>
                                            <td>
                                                <div class="media mb-4">
                                                    @if ($user->hasMedia('user_profile_picture'))
                                                        <img class="d-flex mr-3 rounded-circle"
                                                            src="{{ $user->getFirstMediaUrl('user_profile_picture', 'thumbnail') }}"
                                                            height="50" width="50" />
                                                    @else
                                                        <img class="d-flex mr-3 rounded-circle"
                                                            src="{{ asset('/assets/images/users/avatar-1.jpg') }}"
                                                            height="50" width="50" />
                                                    @endif

                                                    <div class="media-body">
                                                        <b>{{ $user->user_fullname }}</b>
                                                        <small>({{ @$user->username }})
                                                            &nbsp;
                                                            <a href="{{ $user_url . $user->username }}" style="cursor: pointer" target="_blank"><i
                                                                    class="fa-sharp fa-solid fa-share font-size-13 text-info"></i></a>
                                                        </small> <br>
                                                        {{ $user->user_email }}<br />
                                                        {{ $user->user_mobile }}<br />
                                                        @if ($user->user_position)
                                                            Position: {{ $user->user_position }}
                                                        @endif
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                @if ($user->join_company)
                                                    @if ($user->user_type_id == 2 )
                                                        <b>
                                                            {{ $user->join_company->company->company_name ?? '' }}
                                                        </b>
                                                        @if ($user->join_company->company)
                                                            @if ($user->join_company->company->company_status == 'suspend')
                                                                <span class='badge badge-danger font-size-11' style="margin-left:5px">Suspend</span>
                                                            @elseif ( $user->join_company->company->company_status == 'pending')
                                                                <span class='badge badge-warning font-size-11' style="margin-left:5px">Pending</span>
                                                            @endif
                                                        @endif

                                                        <br />
                                                    @endif
                                                @endif
                                                @if ($user->company_branch_name && $user->join_company->company_branch->is_deleted == 0)
                                                    Branch : {{ $user->company_branch_name }}<br/>
                                                @endif
                                                @if($user->company_branch_name && $user->join_company->company_branch->company_branch_status == 'pending')
                                                    Branch Status: <span class='badge badge-warning font-size-11'>Pending</span><br>
                                                @endif

                                            </td>
                                            <td>
                                                @if ($user->user_role_name)
                                                    {{ $user->user_role_name }}
                                                @endif
                                            </td>
                                            <td>
                                                {!! $status !!}
                                            </td>
                                            @can(['user_manage'])
                                                <td>
                                                    <div class="button-container" style="display: flex;gap:10px;">
                                                        {!! $action !!}
                                                    </div>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No record found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination -->
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    <!-- Modal -->
    <div class="modal fade" id="suspend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('user_status') }}">
                    @csrf
                    <div class="modal-body">
                        <h4>Suspend this user ?</h4>
                        <input type="hidden" , name="user_id" id="user_id">
                        <input type="hidden" , name="action" value="suspend">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Suspend</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('user_status') }}">
                    @csrf
                    <div class="modal-body">
                        <h4>Activate this user ?</h4>
                        <input type="hidden" , name="user_id" id="user_id">
                        <input type="hidden" , name="action" value="active">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Activate</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" id="transaction_details">

        </div>
    </div>
    <!-- End Modal -->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/toastr.init.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/lib/jquery.mousewheel.pack.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/fancybox-2.1.7/source/jquery.fancybox.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#user_status').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_type').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_role_id').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#company').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#user_role').select2();
        });
    </script>
    <script>
        $(document).ready(function(e) {
            //$("#user_role").hide();
            $('.suspend').on('click', function() {
                var id = $(this).attr('data-id');
                console.log(id);
                $(".modal-body #user_id").val(id);
            });
            $('.activate').on('click', function() {
                var id = $(this).attr('data-id');
                console.log(id);
                $(".modal-body #user_id").val(id);
            });
        });
    </script>
    <script>
        // Function to copy text to clipboard
        function copyTextToClipboard(text) {
            // Create a temporary input element to copy the text
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }

        // Initialize tooltip for the copy icons on page load
        $(document).ready(function() {
            $('.copyButton').each(function() {
                const $this = $(this);
                const $tooltipText = $this.siblings('.textToCopy').text();

                $this.attr('data-original-title', $tooltipText).tooltip({
                    trigger: 'manual'
                });

                $this.hover(function() {
                    if (!$this.hasClass('copied')) {
                        $this.tooltip('show');
                    }
                }, function() {
                    $this.tooltip('hide');
                });

                $this.click(function() {
                    if (!$this.hasClass('copied')) {
                        copyTextToClipboard($tooltipText);

                        // Change the tooltip text to "Copied" and add a 'copied' class
                        $this.attr('data-original-title', 'Copied').tooltip('show');
                        $this.addClass('copied');

                        // Revert the tooltip to the original content after a delay
                        setTimeout(function() {
                            $this.attr('data-original-title', $tooltipText).tooltip('hide');
                            $this.removeClass('copied');
                        }, 500);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchCompanyBranches(companyId, selectedBranchId) {
                $.ajax({
                    url: "{{ route('ajax_get_company_branch') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        company_id: companyId,
                    },
                    success: function(data) {
                        var companyBranchSelect = $('#company_branch_id');
                        companyBranchSelect.empty();


                        if (Object.keys(data)[0] !== '0') {
                            var defaultOption = $('<option>', {
                                value: '',
                                text: 'All branches',
                            });

                            companyBranchSelect.prepend(defaultOption);
                        }

                        $.each(data, function(key, value) {
                            var option = $('<option>', {
                                value: key,
                                text: value,
                            });

                            if (key == selectedBranchId) {
                                option.attr('selected', 'selected');
                            }

                            companyBranchSelect.append(option);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors here
                        console.error(xhr.responseText);
                    },
                });
            }

            // Trigger the AJAX request on page load
            var initialCompanyId = $('#company_id').val();
            var initialCompanyBranchId = '{{ @$search['company_branch_id'] ?? '' }}';
            if (initialCompanyId) {
                fetchCompanyBranches(initialCompanyId, initialCompanyBranchId);
            }

            // Trigger the AJAX request when the "Company" select dropdown changes
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                if (companyId) {
                    fetchCompanyBranches(companyId, '');
                } else {
                    $('#company_branch_id').empty();
                }
            });
        });
    </script>
@endsection
