<div>
    <h4 class="card-title mb-4">Credit Balance</h4>

    <div id="user_credit_details">
    @if($userCredit)
        <h3 id="user_credit">{{ @$userCredit->user_credit }}</h3>
        @if(@$userCredit->user->company_credit_expired_status != 'Active')
        <span class="badge badge-danger">{{ @$userCredit->user->company_credit_expired_status }}</span>
        @else
        <span class="badge badge-success">{{ @$userCredit->user->company_credit_expired_status }}</span>
        @endif
        <p>Credit expired at: <span id="company_credit_expired">{{ @$userCredit->user->company_credit_expired }}</span></p>
    @else
        <h3> - </h3>
    @endif
    </div>
</div>

<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        var input_name = '{{ $userIdField }}';
        $('#' + input_name).on('change', function() {
            var user_id = $(this).val();
            $('#user_credit_details').html('');
            $('#credit_balance_after').html('');
            $.ajax({
                type: 'POST',
                url: "{{route('ajax_get_user_credit')}}",
                data: {
                    user_id: user_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(e) {
                    if(e.status){
                        var status;
                        switch(e.data['company_credit_expired_status']){
                            case 'Expired':
                                status = '<span class="badge badge-danger">' + e.data['company_credit_expired_status'] +'</span>';
                            break;
                            case 'Active':
                                status = '<span class="badge badge-success">' + e.data['company_credit_expired_status'] +'</span>';
                            break;
                        }
                        $('#user_credit_details').append('<h3 id="user_credit">' + e.data['user_credit'] + ' <span class="mr-2"><img class="mr-2" src="{{ URL::asset('images/Group_5513.svg') }}"></span>' + '</h3>' + status + '<p>Credit expired at: <span id="company_credit_expired">' + e.data['company_credit_expired']);
                    } else {
                        $('#user_credit_details').html('<h3> - </h3>');
                    }
                }
            });
        });
    });

</script>
