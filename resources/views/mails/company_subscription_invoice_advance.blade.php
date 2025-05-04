@component('mail::message')

<h1 style="text-align: center;">{{ @$content['title'] ?? '' }}</h1>
<br/>
{{ @$content['intro'] ?? '' }}
<br/>
<br/>
{{ @$content["text"] ?? '' }}
<br/>
<br/>

@component('mail::table')

@endcomponent

@component('mail::table')

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent