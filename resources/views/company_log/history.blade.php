@extends('layouts.master-without-nav')

@section('content')
<form method="POST" action="{{ $submit }}">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?php
            $year_lists = array();
            for ($i = 2017; $i <= (date('Y') + 1); $i++) {
                $year_lists[$i] = $i;
            }
            ?>
            <div class="form-group">
                {!! Form::select('year', $year_lists, @$search['year'], ['class' => 'form-control']) !!}  
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="form-group">
                <button type="submit" class="btn btn-primary  waves-effect waves-light mb-2 mr-2" name="submit" value="search">
                    <i class="fas fa-search mr-1"></i> Search
                </button>
                <button type="submit" class="btn btn-danger  waves-effect waves-light mb-2 mr-2" name="submit" value="reset">
                    <i class="fas fa-times mr-1"></i> Reset
                </button>
            </div>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr align="center">
                <th scope="col" style="width: 70px;">#</th>
                <th style="width: 100px">Created</th>
                <th>Action</th>
                <th>Description</th>
                <th>Perform by</th>
            </tr>
        </thead>
        <tbody>
            @if($records->isNotEmpty())
                <?php $no = $records->firstItem(); ?>
                @foreach($records as $row)
                 
                <?php 
                $status = '';
                $invoice_no = '-';
                ?>
                <tr align="left">
                    <td>
                        {{ $no++ }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($row->company_log_created)->format('Y-m-d') }}
                        <br>
                        {{ \Carbon\Carbon::parse($row->company_log_created)->format('H:i:s') }}
                    </td>
                    <td>
                        {{ $row->company_log_action }}
                    </td>
                    <td>
                        {{ $row->company_log_description }}
                    </td>
                    <td>
                        {{ optional($row->user)->user_fullname ?? '-' }}
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No record found.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ @$records->links() }}
</div>


@endsection