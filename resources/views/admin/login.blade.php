@extends('layouts.basic')
@section('body')
  <div class='py-4 sm:px-96 px-4'>
    <div class='flex items-center justify-center w-full'>
      <h1 class='text-center text-5xl py-8'>Login</h1>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('signin')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <p><label>Email: <input required type="email" name="email" value="{{$email ?? old('email')}}" class="form-in" /></label></p>
      <p><label>Password: <input required type="password" name="password" class="form-in" /></label></p>
      <div class="flex">
        <label for="remember" class="select-none"><p class="text-xl">@lang('Remember Me'): </p></label>
        <input class="w-12" type="checkbox" name="remember" id="remember" />
      </div>
      <button type="submit" class="form-submit">@lang("Signin")</button>
    </form>
  </div>
@endsection
