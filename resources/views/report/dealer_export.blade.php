
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename = Dealer-Performance-Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_clean();
flush();
?>
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Company Code</th>
                <th>Selling Type</th>
                <th>Company State</th>
                <th>Company City</th>
                <th>Coverage Area</th>

                <th>Username</th>
                <th>Contact Number</th>
                <th>User Credit</th>

                <th>Company Show Room</th>
                <th>User Type</th>
                <th>Admin Name</th>

                <th>Car Published</th>
                <th>Selected Date Published</th>
                <th>Today Published</th>
                <th>Last 7 Days Published</th>
                <th>Today Bump</th>
                <th>Last 7 Days Bump</th>
                <th>Total view</th>
                <th>Last 7 Days Total View</th>
                <th>Total ctr</th>
                <th>Last 7 Days Total CTR</th>
                <th>Total Impression</th>
                <th>Topup Amount</th>
                <th>Latest Topup Date</th>

            </tr>


        </thead>
        <tbody>
            @foreach($report as $key =>$val)
            <tr>
                <td>{{ $val->company_name }}</td>
                <td>{{ $val->user_code }}</td>
                <td>{{ App\Repositories\CompanyRepository::selling_type($val->company_selling_type) }}</td>
                <td>{{ $val->company_state }}</td>
                <td>{{ $val->company_city }}</td>
                <td>{{ $val->setting_coverage_area_name }}</td>

                <td>{{ $val->user_fullname }}</td>
                <td>{{ $val->user_mobile }}</td>
                <td>{{ $val->user_credit  ?? 0 }}</td>
                <td>{{ $val->company_show_room }}</td>
                <td>{{ $val->user_type_name }}</td>
                <td>{{ $val->admin_name }}</td>

                <td>{{ $val->car_published  ?? 0 }}</td>
                <td>{{ $val->selected_date_published ?? 0 }}</td>
                <td>{{ $val->today_published ?? 0 }}</td>
                <td>{{ $val->last_7_days_published ?? 0 }}</td>
                <td>{{ $val->today_bump ?? 0 }}</td>
                <td>{{ $val->last_7_days_bumped ?? 0 }}</td>
                <td>{{ $val->total_view ?? 0 }}</td>
                <td>{{ $val->last_7_days_view ?? 0 }}</td>
                <td>{{ $val->total_ctr ?? 0 }}</td>
                <td>{{ $val->last_7_days_ctr ?? 0 }}</td>
                <td>{{ $val->total_impression ?? 0 }}</td>
                <td>{{ $val->topup_amount ?? 0 }}</td>
                <td>{{ $val->latest_topup ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
