<!DOCTYPE html>
<html>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

<head>

    <title>Form Details PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <table>
        <td style="width: 60px;vertical-align: top;">
            <img src="assets/images/airil_logo.jpeg" height="60" width="auto" alt="" />
        </td>
        <td style="vertical-align: top;margin: 0;padding: 0;">
            <p class="gamalux-title" style="font-size: 30px;color: green;; margin: 0;">
                GAMALUX OILS SDN. BHD.<br />
            </p>
        </td>
    </table>
    <table>
        <tr>
            <th colspan="7" style="background-color: #99ff99;font-size: 20px; text-align: center;">
                {{$form->department_equipment->department_equipment_name}}
            </th>
        </tr>
        <tr>
        <tr>
            <th colspan="7" style="background-color: yellow;font-size: 20px; text-align: center; ">
                {{$form->form_name}}
            </th>
        </tr>
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>End Date</th>
            <th>Order No</th>
            <th>Quantity</th>
            <th>UOM</th>
            <th>Remarks</th>
        </tr>
        @php
        $no = 1; //
        @endphp

        @foreach($form_detail as $detail)
        <tr>
            <td>{{ $no++}} </td>
            <td>{{ \Carbon\Carbon::parse($detail->form_detail_date)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($detail->form_detail_end_date)->format('d-m-Y') }}</td>
            <td>{{ @$detail->form_detail_order_no }}</td>
            <td>{{ @$detail->form_detail_quantity }}</td>
            <td>{{ @$detail->form_detail_oum }}</td>
            <td>{{ @$detail->form_detail_remark }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="7" style="background-color: yellow;font-size: 20px; text-align: left; ">
                TOTAL : {{$total_form_detail}} ({{$measurement}})
            </th>
        </tr>
    </table>
    <table style="position: fixed; bottom: 30%; width: 100%; text-align: center;">
        <tr>
            <th style="text-align: center; padding: 0 20px;">
                <div style="position: relative; display: inline-block;">
                    <span style="display: block; text-align: center;">______________</span>
                    <p style="position: relative; z-index: 1; background-color: white; margin: 0;">Prepared By</p>
                </div>
            </th>
            <th style="text-align: center; padding: 0 20px;">
                <div style="position: relative; display: inline-block;">
                    <span style="display: block; text-align: center;">______________</span>
                    <p style="position: relative; z-index: 1; background-color: white; margin: 0;">Checked By</p>
                </div>
            </th>
            <th style="text-align: center; padding: 0 20px;">
                <div style="position: relative; display: inline-block;">
                    <span style="display: block; text-align: center;">______________</span>
                    <p style="position: relative; z-index: 1; background-color: white; margin: 0;">Verified By</p>
                </div>
            </th>
        </tr>
    </table>
</body>

</html>