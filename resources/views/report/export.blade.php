
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename = BD-Performance-Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_clean();
flush();
?>
    <table>
        <thead>
            <tr>
                <th colspan="7">Dealer</th>
                <th colspan="6">Agent</th>

            </tr>
            <tr>
                <th>User Fullname</th>
                <th>Today new signup</th>
                <th>This week new sign up</th>
                <th>This month new signup</th>
                <th>Today published car</th>
                <th>This week published car</th>
                <th>This month published car</th>

                {{-- <th>User Fullname</th> --}}
                <th>Today new signup</th>
                <th>This week new sign up</th>
                <th>This month new signup</th>
                <th>Today published car</th>
                <th>This week published car</th>
                <th>This month published car</th>
            </tr>


        </thead>
        <tbody>
            {{-- <?php
                $total_dealer_today_new_signup = 0;
                $total_dealer_this_week_new_signup = 0;
                $total_dealer_this_month_new_signup = 0;
                $total_dealer_today_published_car = 0;
                $total_dealer_this_week_published_car = 0;
                $total_dealer_this_month_published_car = 0;

                $total_agent_today_new_signup = 0;
                $total_agent_this_week_new_signup = 0;
                $total_agent_this_month_new_signup = 0;
                $total_agent_today_published_car = 0;
                $total_agent_this_week_published_car = 0;
                $total_agent_this_month_published_car = 0;
            ?> --}}
            @foreach($report as $key =>$val)
            <tr>
                <td>{{ $val->user_fullname }}</td>
                <td>{{ $val->dealer_today_new_signup }}</td>
                <td>{{ $val->dealer_this_week_new_signup }}</td>
                <td>{{ $val->dealer_this_month_new_signup }}</td>
                <td>{{ $val->dealer_today_published_car }}</td>
                <td>{{ $val->dealer_this_week_published_car }}</td>
                <td>{{ $val->dealer_this_month_published_car }}</td>
                {{-- <td>{{ $val->user_fullname }}</td> --}}
                <td>{{ $val->agent_today_new_signup }}</td>
                <td>{{ $val->agent_this_week_new_signup }}</td>
                <td>{{ $val->agent_this_month_new_signup }}</td>
                <td>{{ $val->agent_today_published_car }}</td>
                <td>{{ $val->agent_this_week_published_car }}</td>
                <td>{{ $val->agent_this_month_published_car }}</td>
            </tr>

            {{-- <?php
                $total_dealer_today_new_signup += $val->dealer_today_new_signup[$key];
                $total_dealer_this_week_new_signup += $val->dealer_this_week_new_signup[$key];
                $total_dealer_this_month_new_signup += $val->dealer_this_month_new_signup[$key];
                $total_dealer_today_published_car += $val->dealer_today_published_car[$key];
                $total_dealer_this_week_published_car += $val->dealer_this_week_published_car[$key];
                $total_dealer_this_month_published_car += $val->dealer_this_month_published_car[$key];

                $total_agent_today_new_signup += $val->agent_today_new_signup[$key];
                $total_agent_this_week_new_signup += $val->agent_this_week_new_signup[$key];
                $total_agent_this_month_new_signup += $val->agent_this_month_new_signup[$key];
                $total_agent_today_published_car += $val->agent_today_published_car[$key];
                $total_agent_this_week_published_car += $val->agent_this_week_published_car[$key];
                $total_agent_this_month_published_car += $val->agent_this_month_published_car[$key];
            ?> --}}
            @endforeach
            {{-- <tr>
                <th>Total</th>
                <td align="center">{{ $total_dealer_today_new_signup }}</td>
                <td align="center">{{ $total_dealer_this_week_new_signup }}</td>
                <td align="center">{{ $total_dealer_this_month_new_signup }}</td>
                <td align="center">{{ $total_dealer_today_published_car }}</td>
                <td align="center">{{ $total_dealer_this_week_published_car }}</td>
                <td align="center">{{ $total_dealer_this_month_published_car }}</td>

                <td align="center">{{ $total_agent_today_new_signup }}</td>
                <td align="center">{{ $total_agent_this_week_new_signup }}</td>
                <td align="center">{{ $total_agent_this_month_new_signup }}</td>
                <td align="center">{{ $total_agent_today_published_car }}</td>
                <td align="center">{{ $total_agent_this_week_published_car }}</td>
                <td align="center">{{ $total_agent_this_month_published_car }}</td>
            </tr> --}}
        </tbody>
    </table>
