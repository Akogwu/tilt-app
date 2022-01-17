@component('mail::message')
Your payment was successful, login to our platform to view your test result.
<p>
    <a href= {{$link}}>view result</a>
</p>
<p>
    below is the public link to the test <a href="{{$link}}">{{$link}}</a>
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
