@extends('layouts.master')

@section('title')
    Pricelist Listing
@endsection

@section('css')
    <link href="{{ URL::asset('lightbox2/src/css/lightbox.css') }}" rel="stylesheet" />
    <style>
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
                <h4 class="mb-0 font-size-18"><span class="mr-3">Pricelist Listing</span>
                    @can('pricelist_manage')
                        <a href="{{ route('pricelist_add') }}" class="btn btn-outline-success waves-effect waves-light btn-sm">
                            <i class="mdi mdi-plus mr-1"></i> Add New
                        </a>
                    @endcan
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Pricelist</a>
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
                            <form method="POST" action="{{ route('pricelist_listing') }}">
                                @csrf
                                <div class="row">
                                    @if (Auth::user()->user_type->user_type_slug == 'admin' )
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validationCustom03">Company</label>
                                            {!! Form::select('company_id', $company, @$search['company_id'], [
                                                'class' => 'form-control select2',
                                                'id' => 'company_id',
                                            ]) !!}
                                        </div>
                                    </div>
                                    @endif
                                    @if (Auth::user()->user_type->user_type_slug == 'admin' || Auth::user()->roles->value('id')== 3)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="validationCustom03">Branch</label>
                                                @if (Auth::user()->roles->value('id')== 3)
                                                    {!! Form::select('branch_id', $branch, @$search['branch_id'], ['class' => 'form-control select2', 'id' => 'branch_id']) !!}
                                                @else
                                                    {!! Form::select('branch_id', $company_branch, @$search['branch_id'], ['class' => 'form-control select2', 'id' => 'branch_id']) !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="form-group custom-dropdown-container">
                                            <label for="pricelist_status">Status</label>
                                            {!! Form::select('pricelist_status', $status, @$search['pricelist_status'], [
                                                'class' => 'form-control select2',
                                                'id' => 'pricelist_status',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
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
                                    <th>Thumbnail</th>
                                    <th>Car Model Include</th>
                                    @if ($user_type == 'administrator')
                                        <th>Company</th>
                                    @endif
                                    @if(Auth::user()->roles->value('id') == 3)
                                        <th>Branch</th>
                                    @endif
                                    <th>Status</th>
                                    @can(['pricelist_manage'])
                                        <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $pricelists->firstItem();
                                ?>
                                @if ($pricelists->isNotEmpty())
                                    @foreach ($pricelists as $pricelist)
                                        <?php
                                        if ($pricelist->is_published) {
                                            $status = "<span class='badge badge-success' data-toggle='popover' data-trigger='focus' title='' data-original-title='Date Created'>Published</span>";
                                        } else {
                                            $status = "<span class='badge badge-warning' data-toggle='popover' data-trigger='focus' title=''  data-original-title='Date Created'>Draft</span>";
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <b>{{ $no++ }}</b>
                                            </td>
                                            <td>
                                                <div class="flex-shrink-0 mr-4">
                                                    @if ($pricelist->hasMedia('pricelist_media'))
                                                        <img src="{{ $pricelist->getMedia('pricelist_media')->last()?->getUrl('thumb') }}"
                                                        height="70" width="100" class="pricelist-thumbnail-clickable"
                                                        style="cursor: pointer">
                                                    @else
                                                        <img src="{{URL::asset('assets/images/thumbnail_placeholder.png')}}" height="70" width="100" >
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="max-width: 300px; word-wrap: break-word; white-space: normal;">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        @php
                                                            $data = json_decode($pricelist->car_model);
                                                            $brand = $pricelist->company->car_brand->car_brand_name;
                                                            $response = \Illuminate\Support\Facades\Http::get("https://web-api.caricarz.com/new_car_brand_listing", [
                                                                'car_brand_slug' => Str::slug($brand),
                                                            ]);
                                                            $brand_data = $response->json();
                                                            $serveModel = [];
                                                            foreach ($brand_data as $item) {
                                                                $serveModel[] = $item['car_model_name'];
                                                            }
                                                            $diff = array_diff($serveModel, $data);
                                                        @endphp
                                                        @if (empty($diff))
                                                            All car models
                                                        @else
                                                            @foreach ($data as $key => $innerArray)
                                                                {{ $innerArray }}
                                                                @if (!$loop->last)
                                                                    ,&nbsp;
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            @if ($user_type == 'administrator')
                                                <td>
                                                    {{ $pricelist->company?->company_name }}
                                                    <small>({{ @$pricelist->company->sector?->sector_name }})</small>
                                                </td>
                                            @endif
                                            @if (Auth::user()->roles->value('id') == 3)
                                                <td style="max-width: 400px; word-wrap: break-word; white-space: normal;">
                                                    @php
                                                        $branch_ids = $pricelist->company_branch_id;
                                                        $company_branch = $pricelist->company->company_branch->where('is_deleted', 0);
                                                        $branch = [];
                                                        foreach ($company_branch as $item) {
                                                            $branch[] = $item['company_branch_id'];
                                                        }
                                                        $diff = array_diff($branch, $branch_ids);
                                                    @endphp
                                                    @if (empty($diff))
                                                        All branches
                                                    @else
                                                        @foreach ($branch_ids as $branch_id)
                                                            @php
                                                                $company_branch = DB::table('tbl_company_branch')->where('company_branch_id', $branch_id)->first();
                                                            @endphp
                                                            {{ $company_branch->company_branch_name }}
                                                            @if (!$loop->last)
                                                                ,&nbsp;
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                {!! $status !!}
                                            </td>
                                            @can(['pricelist_manage'])
                                                <td>
                                                    <div class="button-container" style="display: flex;gap:10px;">
                                                        <a href=" {{ route('pricelist_edit', $pricelist->pricelist_id) }}"
                                                            class='btn btn-sm btn-outline-primary waves-effect waves-light'>Edit</a>
                                                        <span data-toggle='modal' data-target='#delete'
                                                            data-id="{{ $pricelist->pricelist_id }}" class='delete'><a
                                                                href='javascript:void(0);'
                                                                class='btn btn-sm btn-outline-danger waves-effect waves-light'>Delete</a></span>
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
                </div>
                {{ $pricelists->links() }}
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    <!-- Modal -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('pricelist_status') }}">
                    @csrf
                    <div class="modal-body">
                        <h4>Delete this pricelist ?</h4>
                        <input type="hidden" , name="pricelist_id" id="pricelist_id">
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
    <div id="thumbnailModal" class="modal">
        <span class="closebtn" style="color: white">&times;</span>
        <img src="" alt="" id="img">
    </div>
    <!-- End Modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('lightbox2/src/js/lightbox.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pricelist_status').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function(e) {
            //$("#user_role").hide();
            $('.delete').on('click', function() {
                var id = $(this).attr('data-id');
                console.log(id);
                $(".modal-body #pricelist_id").val(id);
            });
            $('.activate').on('click', function() {
                var id = $(this).attr('data-id');
                console.log(id);
                $(".modal-body #user_id").val(id);
            });
        });
    </script>
    <script>
        var modal = document.getElementById("thumbnailModal");
        var modalImg = document.getElementById("img");

        // Get all images with class "company-logo-clickable"
        var images = document.querySelectorAll(".pricelist-thumbnail-clickable");

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
        lightbox.option({
            'resizeDuration': 200,
            'height': 100,
            'wrapAround': true
        })
    </script>
@endsection
