
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename = Ads-export.xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_clean();
flush();
?>
    <table>
        <thead>

            <tr>
                <th>vehicle_id</th>
                <th>company_code</th>
                <th>title</th>
                <th>variant</th>
                <th>url</th>
                <th>brand</th>
                <th>model</th>
                <th>year</th>
                <th>mileage</th>
                <th>mileage_unit</th>
                <th>image_url</th>
                <th>transmission</th>
                <th>fuel_type</th>
                <th>body_type</th>
                <th>drivetrain</th>
                <th>price</th>
                <th>address</th>
                <th>state</th>
                <th>city</th>
                <th>exterior_color</th>
                <th>sale_price</th>
                <th>availability</th>
                <th>state_of_vehicle</th>
                <th>fb_page_id</th>
                <th>company_name</th>
                <th>dealer_name</th>
            </tr>


        </thead>
        <tbody>

            @foreach($export as $key =>$val)
            <tr>

                <td>{{ $val->vehicle_id}}</td>
                <td>{{ $val->user_code}}</td>
                <td>{{ $val->title}}</td>
                <td>{{ $val->variant}}</td>
                <td>{{ $val->url}}</td>
                <td>{{ $val->brand}}</td>
                <td>{{ $val->model}}</td>
                <td>{{ $val->year}}</td>
                <td>{{ $val->mileage}}</td>
                <td>{{ $val->mileage_unit}}</td>
                <td>{{ $val->image_url}}</td>
                <td>{{ $val->transmission}}</td>
                <td>{{ $val->fuel_type}}</td>
                <td>{{ $val->body_type}}</td>
                <td>{{ $val->drivetrain}}</td>
                <td>{{ $val->price}}</td>
                <td>{{ "{ addr1:'$val->addr1' , address_city:'$val->address_city' , region:'$val->address_state' , postal_code:'$val->postal_code' , country:'MY' }"}}</td>
                <td>{{ $val->state}}</td>
                <td>{{ $val->city}}</td>
                <td>{{ $val->exterior_color}}</td>
                <td>{{ $val->sale_price}}</td>
                <td>{{ $val->availability}}</td>
                <td>{{ $val->state_of_vehicle}}</td>
                <td>{{ $val->fb_page_id}}</td>
                <td>{{ $val->company_name}}</th>
                <td>{{ $val->dealer_name}}</th>
            </tr>

            @endforeach

        </tbody>
    </table>
