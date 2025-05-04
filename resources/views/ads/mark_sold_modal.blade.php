<!-- modal -->
<div class="modal-content">
    <div class="modal-header">
        <div class="modal-title">
            <h5>Mark As Sold</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="form_execute_action">
            @csrf
            <input type="hidden" name="action" value="sold_selected"/>

            @if($ads->isNotEmpty())
                <div class="row">
                    @foreach($ads as $key => $value)
                        <div class="col-4 my-2 pt-0">
                            <div class="img-wrap cars-cover-img border">
                                @if($value->cover_photo)
                                    <img src="{{ $value->cover_photo->getUrl('thumb') }}" width="100%" alt="">
                                @else
                                    <img src="{{ asset('images/no_image_available.png') }}" width="100%" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col-8 my-2">
                            <span class="font-weight-bolder mb-2">{{$value->ads_title}}</span><br>
                            <span id="ads_id">#{{sprintf("%08d", $value->ads_id)}}</span>
                            <input type="hidden" name="mark_sold_selection[{{$value->ads_id}}][ads_id]"
                                   value="{{$value->ads_id}}"/>

                            @if($value->ads_category->setting_ads_category_id == 5)
                                <div class="row mt-2">
                                    <div class="col-md-7">
                                        <label class="font-weight-bold mb-0">Sold As</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   onclick="$('#error_{{$value->ads_id}}').html('').hide();check_sold_as_premier({{$value->ads_id}},true)"
                                                   name="mark_sold_selection[{{$value->ads_id}}][value]"
                                                   id="selection[{{$value->ads_id}}][1]" value=1>
                                            <label class="form-check-label" for="selection[{{$value->ads_id}}][1]">Premier</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   onclick="$('#error_{{$value->ads_id}}').html('').hide();check_sold_as_premier({{$value->ads_id}},false)"
                                                   name="mark_sold_selection[{{$value->ads_id}}][value]"
                                                   id="selection[{{$value->ads_id}}][2]" value=0>
                                            <label class="form-check-label" for="selection[{{$value->ads_id}}][2]">Standard</label>
                                        </div>
                                        <input style="display: none" type="radio"
                                               name="mark_sold_selection[{{$value->ads_id}}][value]" id="selection"
                                               value='' checked>

                                        <div class="sold_as_premier_container_{{ $value->ads_id }}" style="display: none;">
                                        <label class="font-weight-bold mt-2 mb-0">Warranty Company</label>
                                        {!! Form::select('mark_sold_selection['.$value->ads_id.'][warranty_company]', ['' => 'Please Select Warranty Company'] + $warranty_company, null, ['class' => 'form-control p-1','onclick' => '$("#error_'.$value->ads_id.'").html("").hide();']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-2 mt-md-0">
                                        <div class="sold_as_premier_container_{{ $value->ads_id }}" style="display: none;">
                                            <style>
                                                .filepond--drop-label label{
                                                    font-size: 14px !important;
                                                }
                                                .filepond--root {
                                                    min-height: 100px !important;
                                                }
                                            </style>
                                            <label class="font-weight-bold mb-0">Warranty Cover</label>
                                            <input type="file" id="sold_as_premier_upload_{{ $value->ads_id }}" class="filepond mb-0" name="warranty_cover">
                                            <input type="hidden" id="input_warranty_cover_{{ $value->ads_id }}" name="mark_sold_selection[{{$value->ads_id}}][warranty_cover]">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="mark_sold_selection[{{$value->ads_id}}][value]" value="0" />
                            @endif
                            <small id="error_{{$value->ads_id}}" class="text-danger error"></small>
                        </div>

                    @endforeach
                </div>
            @endif
            <input type="hidden" name="btn_submit" value="execute_action"/>
        </form>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary submit">Confirm</button>
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
    $('.submit').on('click', function (e) {

        $('.error').html('').hide();

        e.preventDefault();
        $('.submit').prop('disabled', true);
        $('#close').prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: "{{route ('ajax_submit_mark_as_sold') }}",
            data: $('#form_execute_action').serialize(),
            success: function (response) {
                if (response.status) {
                    location.replace("{{ route('ads_listing') }}");
                } else {
                    if (response.data.error) {
                        $('#close').prop('disabled', true);
                        $('.submit').prop('disabled', true);
                        $.each(response.data.error, function (key, value) {

                            const ads_id = key.split(".")[1];
                            const field_error = $('#error_' + ads_id);
                            let error_message = field_error.html();

                            if(error_message){
                                error_message += '<br>' + value;

                            }else {
                                error_message = value;
                            }

                            field_error.html(error_message).show();
                        });
                    }

                    $('.submit').prop('disabled', false);
                    $('#close').prop('disabled', false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.submit').prop('disabled', false);
                $('#close').prop('disabled', false);
            },
        });
    });

    function check_sold_as_premier(id,show){
        if(show){
            $('.sold_as_premier_container_'+id).show();
        }else {
            $('.sold_as_premier_container_'+id).hide();
        }
    }

    @if($ads->isNotEmpty())
        @foreach($ads as $ad)
            FilePond.create(document.querySelector('#sold_as_premier_upload_{{ $ad->ads_id }}'), {
                acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
                maxFileSize: '5MB',
                imagePreviewHeight: 80,
                allowImageResize: true,
                imageResizeTargetWidth: 1200,
                imageResizeMode: 'contain',
                styleButtonRemoveItemPosition: 'right',
                styleImageEditButtonEditItemPosition: 'bottom right',
                allowImageEdit: true,
            }).setOptions({
                server: {
                    process: {
                        url: "{{ route('ajax_upload_media_temp') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {},
                        onload: (response) => {
                            const result = JSON.parse(response);
                            if (result.temp_file_id) {
                                $('#error_{{$ad->ads_id}}').html('').hide();
                                $('#input_warranty_cover_{{ $ad->ads_id }}').val(result.temp_file_id);
                                return result.temp_file_id;
                            }
                        },
                        ondata: (formData) => {
                            formData.append('id', {{ $ad->ads_id }});
                            formData.append('encrypt', '{{ md5($ad->ads_id . ENV('ENCRYPTION_CODE')) }}');
                            formData.append('collection', 'warranty_cover');
                            formData.append('_token', '{{csrf_token()}}');
                            return formData;
                        }
                    },
                    revert: {
                        url: "{{ route('ajax_revert_media') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        onload: function (response) {
                            const result = JSON.parse(response);
                            if (result.status) {
                                $('#input_warranty_cover_{{ $value->ads_id }}').val(null);
                                return null;
                            }
                        },
                    },
                }
            });
        @endforeach
    @endif

</script>
