@extends('layouts.basic')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full'>
      <h1 class='text-center text-5xl py-8'>Login</h1>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('signin')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'email'" :name="'email'" :placeholder="'Email'" />
      <x-input :type="'password'" :name="'password'" :placeholder="'Password'" />
      <div class="flex">
        <label for="remember" class="select-none"><p class="text-xl">Remember Me: </p></label>
        <input class="w-12" type="checkbox" name="remember" id="remember" />
      </div>
      <x-submit :value="'Signin'" />
    </form>
  </div>
@endsection