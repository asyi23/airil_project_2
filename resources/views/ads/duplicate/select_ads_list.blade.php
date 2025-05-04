@if($ads->isNotEmpty())
    @foreach($ads->chunk(2) as $ads_chunk)
        <tr>
            <td class="p-0">
                <div class="d-flex flex-column flex-md-row">
                    @foreach($ads_chunk as $ad)
                        <div class="col-md-6 p-3 @if($loop->first) border-right @endif">
                            <label class="d-flex flex-row w-100 mb-0" for="checkbox_{{ $ad->ads_id }}">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="ads_ids[]"
                                           value="{{ $ad->ads_id }}"
                                           id="checkbox_{{ $ad->ads_id }}">
                                </div>

                                <div class="mr-2">
                                    @if($ad->cover_photo)
                                        <img class="photo" src="{{ $ad->cover_photo->getUrl('thumb') }}"
                                             class="card-img-top card-company-banner" width="120px">
                                    @else
                                        <img class="photo" src="{{ asset('images/no_image_available.png') }}"
                                             class="card-img-top card-company-banner" width="100%">
                                    @endif
                                </div>

                                <div class="font-weight-bold">
                                    <a href="{{ env('WEB_URL') . $ad->ads_type->ads_type_slug . '/' . $ad->ads_slug . '/' . $ad->ads_id }}"
                                       target="_blank">
                                        {{ $ad->ads_title }}
                                    </a>
                                    <br/>
                                    #{{ sprintf("%08d", $ad->ads_id) }}
                                    <br/>
                                    <span
                                        class="badge badge-secondary cars-status-padding">{{ $ad->ads_type->ads_type_name }}</span>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    @endforeach
{{--    @foreach($ads as $ad)--}}
{{--        <tr class="d-sm-none">--}}
{{--            <td class="w-100">--}}
{{--                <label class="d-flex flex-row w-100 mb-0" for="checkbox_{{ $ad->ads_id }}">--}}
{{--                    <div class="form-check">--}}
{{--                        <input type="checkbox" class="form-check-input" name="ads_ids[]" value="{{ $ad->ads_id }}"--}}
{{--                               id="checkbox_{{ $ad->ads_id }}">--}}
{{--                    </div>--}}

{{--                    <div class="mr-2">--}}
{{--                        @if($ad->cover_photo)--}}
{{--                            <img class="photo" src="{{ $ad->cover_photo->getUrl('thumb') }}"--}}
{{--                                 class="card-img-top card-company-banner" width="120px">--}}
{{--                        @else--}}
{{--                            <img class="photo" src="{{ asset('images/no_image_available.png') }}"--}}
{{--                                 class="card-img-top card-company-banner" width="100%">--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    <div class="font-weight-bold">--}}
{{--                        <a href="{{ env('WEB_URL') . $ad->ads_type->ads_type_slug . '/' . $ad->ads_slug . '/' . $ad->ads_id }}"--}}
{{--                           target="_blank">--}}
{{--                            {{ $ad->ads_title }}--}}
{{--                        </a>--}}
{{--                        <br/>--}}
{{--                        #{{ sprintf("%08d", $ad->ads_id) }}--}}
{{--                        <br/>--}}
{{--                        <span--}}
{{--                            class="badge badge-secondary cars-status-padding">{{ $ad->ads_type->ads_type_name }}</span>--}}
{{--                    </div>--}}
{{--                </label>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
@else
    <tr>
        <td>No Ads</td>
    </tr>
@endif


