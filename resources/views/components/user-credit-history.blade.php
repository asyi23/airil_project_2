<div id="user_credit_history">
    <div class="table-responsive">
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr align="center">
                    <th colspan="6">User Credit History Log</th>
                </tr>
                <tr align="center">
                    <th>Date</th>
                    <th>Action</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Description</th>
                    <th>Admin</th>
                </tr>
                
            </thead>
            <tbody id="history_detail">            
                @foreach($userHistory as $row)
                <?php 
                    switch($row->user_wallet_history_action){
                        case 'add':
                            $amount = '+ ' . $row->credit;
                        break;
                        case 'deduct':
                            $amount = '- ' . $row->credit;
                        break;
                        case 'transfer':
                        case 'adjustment':
                            $credit_before = $row->user_credit_before;
                            $credit_after = $row->user_credit_after;
                            if($credit_after > $credit_before) {
                                $amount = '+ ' . $row->credit;
                            }else {
                                $amount = '- ' . $row->credit;
                            }
                        break;
                        
                    }                
                ?>
                <tr align="center">
                    <td>{{ $row->user_credit_date }}</td>
                    <td>{{ ucfirst($row->user_wallet_history_action) }}</td>
                    <td>{!! $amount !!}</td>
                    <td>{{ $row->user_credit_after }}</td>
                    <td>{{ ucfirst($row->user_credit_description) }}</td>
                    <td>{{ optional($row->admin)->user_fullname }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(e) {
        var input_name = '{{ $userId }}';
        $('#' + input_name).on('change', function() {
            $.ajax({
                    type: 'POST',
                    url: "{{route('ajax_get_user_credit_history_by_user_id')}}",
                    data: {
                        user_id: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function(e) {  
                        if(e.status){
                            // console.log(e.data);
                            var amount;
                            $('#history_detail').html('');
                            $.each( e.data, function( key, val ) {
                                switch(val['user_wallet_history_action']){
                                    case 'add':
                                        amount = '+ ' + val['credit'];
                                    break;
                                    case 'deduct':
                                        amount = '- ' + val['credit'];
                                    break;
                                    case 'transfer':
                                    case 'adjustment':
                                        $credit_before = val['user_credit_before'];
                                        $credit_after = val['user_credit_after'];
                                        if($credit_after > $credit_before) {
                                            amount = '+ ' + val['credit'];
                                        }else {
                                            amount = '- ' + val['credit'];
                                        }
                                    break;
                                }
                                
                                var date = val['user_credit_date'];
                                var admin = val['admin'] ? val['admin']['user_fullname'] : '';
                                var action = val['user_wallet_history_action'];
                                var description = val['user_credit_description'];

                                $('#history_detail').append('<tr align="center"><td>' + date + '</td><td>' + action + '</td><td>' + amount + '</td><td>' + val['user_credit_after'] + '</td><td>' + description + '</td><td>' + admin + '</td></tr>');

                            });
                        } else {
                            $('#history_detail').append('<tr><td>No record found</td></tr>');
                        }
                    }
                });
        });
    });

</script>