@extends('layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>Create Attraction</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.list_users')" :name="'Users list'"/>
      </div>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.create_user')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'text'" :name="'name'" :placeholder="'Name'"/>
      <textarea type="text" name="email" placeholder="Email"></textarea>
      <x-input :type="'password'" :name="'password'" :placeholder="'Password'"/>
      <x-input :type="'password'" :name="'password_confirm'" :placeholder="'Password Confirm'"/>
      <x-submit :value="'Create'" />
    </form>
  </div>
@endsection