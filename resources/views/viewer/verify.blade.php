@extends('layouts.basic')
@section('body')
<x-show-required :errors="$errors"/>
<form class="p-4 grid grid-cols-1 gap-4 [&>p>label]:flex [&>p>label]:flex-col [&>p>label]:sm:flex-row" action="#" method="POST">
@csrf

<p><label class="flex flex-col sm:flex-row">@lang("Email"): <input required type="email" name="email" value="{{$email ?? ''}}" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Verification Code"): <input required type="text" name="code" value="{{$code ?? ''}}" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Password"): <input required type="password" name="password" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Password Confirmation"): <input required type="password" name="password_confirmation" class="form-in" /></label></p>

<button type="submit" class="form-submit">Verify</button>

</form>
@endsection
