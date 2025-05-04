<!-- modal -->
<div class="modal-content">
    <div class="modal-header">
        <div class="modal-title">
            <h5>Assign Admin</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="form_execute_action">
            @csrf

            <input type="hidden" name="action" value="company_selected"/>
            @if ($records->isNotEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="admin name">ADMIN NAME <span class="text-danger">*</span></label>
                            {!! Form::select('user_id', $admin_sel, @$post->user_id, ['class' => 'form-control', 'id' => 'user_id']) !!}
                            <small id="error" class="text-danger error"></small>
                        </div>
                    </div>
                </div>
                @foreach($records as $company)
                    <input type="hidden" name="company_id[]" value="{{ $company->company_id }}"/>
                @endforeach
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
            url: "{{route ('ajax_submit_assign_admin') }}",
            data: $('#form_execute_action').serialize(),
            success: function (response) {
                if (response.status) {
                    location.replace("{{ route('company_listing') }}");
                } else {
                    if (response.data.error) {
                        $('#close').prop('disabled', true);
                        $('.submit').prop('disabled', true);
                        $.each(response.data.error, function (key, value) {
                            const field_error = $('#error');
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
</script>
