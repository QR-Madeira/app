@extends('layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full'>
      <h1 class='text-center text-5xl py-8'>Login</h1>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.signin')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'text'" :name="'username'" :placeholder="'Username'" />
      <x-input :type="'password'" :name="'password'" :placeholder="'Password'" />
      <x-submit :value="'Signin'" />
    </form>
  </div>
@endsection