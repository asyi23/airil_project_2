<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
        <tr class="text-white text-center" style="background-color: #67708C">
            @foreach($day_list as $day_id => $day_name)
                <th style="font-size: 12px">{{ $day_name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody class="bg-white text-center" style="color: #67708C">
        <tr>
            @foreach($day_list as $day_id => $day_name)
                @if($ads_bump_auto_scheduler_day = $ads_bump_auto_scheduler->ads_bump_auto_scheduler_days->where('ads_bump_auto_scheduler_day_day','=',$day_id)->first())
                    <td>{{ substr($ads_bump_auto_scheduler_day->ads_bump_auto_scheduler_day_time, 0, -3) }}</td>
                @else
                    <td>-</td>
                @endif
            @endforeach
        </tr>
        <tr>
            @foreach($day_list as $day_id => $day_name)
                @if($ads_bump_auto_scheduler_day = $ads_bump_auto_scheduler->ads_bump_auto_scheduler_days->where('ads_bump_auto_scheduler_day_day','=',$day_id)->skip(1)->first())
                    <td>{{ substr($ads_bump_auto_scheduler_day->ads_bump_auto_scheduler_day_time, 0, -3) }}</td>
                @else
                    <td>-</td>
                @endif
            @endforeach
        </tr>
        <tr>
            @foreach($day_list as $day_id => $day_name)
                @if($ads_bump_auto_scheduler_day = $ads_bump_auto_scheduler->ads_bump_auto_scheduler_days->where('ads_bump_auto_scheduler_day_day','=',$day_id)->skip(2)->first())
                    <td>{{ substr($ads_bump_auto_scheduler_day->ads_bump_auto_scheduler_day_time, 0, -3) }}</td>
                @else
                    <td>-</td>
                @endif
            @endforeach
        </tr>
        </tbody>
    </table>
</div>

