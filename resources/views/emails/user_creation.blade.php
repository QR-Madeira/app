<p>An account was created for the email {{$user->email}} at <a href="{{$url}}">{{$app}}</a> with the following permissions:</p>

<ul>
@if(is_iterable($permissions) && (count($permissions) > 0))
@foreach($permissions as $p)
<li>{{$p}}</li>
@endforeach
@else
<li>No permissions</li>
@endif
</ul>

<p>This is your verification code: <code>{{$code}}</code></p>
<p>Verify your account and define your password <a href="{{$verify_url}}">here</a></p>
