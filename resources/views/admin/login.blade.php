@extends('layout')
@section('body')
  <div class='p-4 w-full'>
    <div class='text-center p-4'>
      <h1 class='text-6xl'>Login</h1>
    </div>
    <form action="{{route('admin.signin')}}" method="POST" class='p-4 grid grid-rows-3 gap-4'>
      @csrf
      <input type="text" name="username" class='p-4 bg-black/[.10] rounded placeholder:text-black' placeholder="Username">
      <input type="password" name="password" class='p-4 bg-black/[.10] rounded placeholder:text-black' placeholder="Password">
      <input type="submit" class='p-4 bg-green-500 rounded text-black' value="Signin">
    </form>
  </div>
@endsection