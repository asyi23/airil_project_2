<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- <p class="mb-2">Product id: <span class="text-primary">#</span></p>
        <p class="mb-4">Billing Name: <span class="text-primary"></span></p> -->

        <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Company Details</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-toggle="tab" href="#tab-2" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Invoice Details</span> 
                        </a>
                    </li>
                    {{-- <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-toggle="tab" href="#tab-3" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Subscription</span>   
                        </a>
                    </li> --}}
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="tab-1" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                    <input readonly name="company_name" type="text" class="form-control" value="{{ @$post->company_name }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company_regno">Company Reg. No.<span class="text-danger">*</span></label>
                                    <input readonly name="company_regno" type="text" class="form-control" value="{{ @$post->company_regno }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_phone">Company Phone<span class="text-danger">*</span></label>
                                    {{-- <input name="company_phone" type="text" class="form-control" value="{{ @$post->company_phone }}"> --}}
                                    <input readonly id="input-mask" name="company_phone" class="form-control input-mask text-left" data-inputmask="'mask': '999-99999999','clearIncomplete':'false','removeMaskOnSubmit':'true'" im-insert="true" style="text-align: right;" value="{{ @$post->company_phone }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_email">Company Email</label>
                                    <input readonly name="company_email" type="email" class="form-control" value="{{ @$post->company_email }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_website">Company Website</label>
                                    <input readonly name="company_website" type="text" class="form-control" value="{{ @$post->company_website }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="company_address">Company Address<span class="text-danger">*</span></label>
                                    <input readonly name="company_address" type="text" class="form-control" value="{{ @$post->company_address }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_postcode">Company Postcode<span class="text-danger">*</span></label>
                                    <input readonly name="company_postcode" type="text" class="form-control" max="5" value="{{ @$post->company_postcode }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_state_id">Company State<span class="text-danger">*</span></label>
                                    {{-- <input name="company_state_id" type="text" class="form-control" value="{{ @$post->company_state_id }}"> --}}
                                    {!! Form::select(
                                        'company_state_id', 
                                        $state_sel, 
                                        @$post->company_state_id,
                                        ['class' => 'form-control state','id' => 'company_state_id','disabled']) 
                                    !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_city_id">Company City<span class="text-danger">*</span></label>
                                    {{-- <input id="company_city_id" name="company_city_id" type="text" class="form-control" value="{{ @$post->company_city_id }}"> --}}
                                    {!! Form::select(
                                        'company_city_id', 
                                        @$post ? $company_city_sel : [],
                                        @$post->company_city_id??'',
                                        ['class' => 'form-control','id' => 'company_city_id','disabled']) 
                                    !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_country">Country<span class="text-danger">*</span></label>
                                    <input readonly name="company_country" type="text" class="form-control" max="5" value="{{ @$post->company_country ?? 'Malaysia' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="company_description">Company Description</label>
                                    <textarea readonly name="company_description" type="text" class="form-control" style="height:150px;" row="10">{{ @$post->company_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-2" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_company_name">Invoice Company Name<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_company_name" type="text" class="form-control" value="{{ @$post->invoice_company_name }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_email">Invoice Email<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_email" type="text" class="form-control" value="{{ @$post->invoice_email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_mobile_no">Invoice Mobile No.<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_mobile_no" type="text" class="form-control" value="{{ @$post->invoice_mobile_no }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_phone">Invoice Phone No.<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_phone" type="text" class="form-control" value="{{ @$post->invoice_phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_address">Invoice Address<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_address" type="text" class="form-control" value="{{ @$post->invoice_address }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_address2">Invoice Address2<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_address2" type="text" class="form-control" value="{{ @$post->invoice_address2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="invoice_postcode">Invoice Postcode<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_postcode" type="text" class="form-control" max="5" value="{{ @$post->invoice_postcode }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="invoice_state_id">Invoice State<span class="text-danger">*</span></label>
                                    {{-- <input name="invoice_state_id" type="text" class="form-control" value="{{ @$post->invoice_state_id }}"> --}}
                                    {!! Form::select(
                                        'invoice_state_id', 
                                        $state_sel, 
                                        @$post->invoice_state_id,
                                        ['class' => 'form-control state','id' => 'invoice_state_id','disabled']) 
                                    !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="invoice_city_id">Invoice City<span class="text-danger">*</span></label>
                                    {{-- <input name="invoice_city_id" type="text" class="form-control" value="{{ @$post->invoice_city_id }}"> --}}
                                    {!! Form::select(
                                        'invoice_city_id', 
                                        @$post ? $invoice_city_sel : [],
                                        @$post->invoice_city_id??'',
                                        ['class' => 'form-control','id' => 'invoice_city_id','disabled']) 
                                    !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="invoice_country">Country<span class="text-danger">*</span></label>
                                    <input readonly name="invoice_country" type="text" class="form-control" max="5" value="Malaysia">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane" id="tab-3" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="row col-sm-12">
                                        <label for="company_subscription_id">Subscription<span class="text-danger">*</span></label>
                                        @foreach ($subscription_sel as $key=> $sub)
                                            <div class="custom-control custom-radio col-sm-12">
                                                <input disabled type="radio" id="company_subscription_id_{{ $key }}" name="company_subscription_id" value="{{ $sub->setting_subscription_id }}" class="custom-control-input"
                                                @if(@$post->company_subscription_id==$sub->setting_subscription_id)
                                                    checked
                                                @endif
                                                >
                                                <label class="custom-control-label" for="company_subscription_id_{{ $key }}">{{ $sub->setting_subscription_name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    <div class="modal-footer">
        {{-- <form method="POST" action="{{ route('company_approval_status') }}">
            @csrf
            <input type="hidden" name="id" value="{{$post->company_id}}">
            @if ($post->is_pending())
                <button type="submit" class="btn btn-success waves-effect waves-light mr-1" name="submit" value="approved">Approve</button>
                <button type="submit" class="btn btn-danger waves-effect waves-light mr-1" name="submit" value="rejected">Reject</button>
            @endif
            @if ($post->is_approved())
                <button type="submit" class="btn btn-danger waves-effect waves-light mr-1" name="submit" value="rejected">Reject</button>
            @endif
            @if ($post->is_rejected())
                <button type="submit" class="btn btn-success waves-effect waves-light mr-1" name="submit" value="approved">Approve</button>
            @endif
        </form> --}}
            <button type="button" class="btn btn-secondary waves-effect waves-light mr-1" data-dismiss="modal">Close</button>
    </div>
</div>