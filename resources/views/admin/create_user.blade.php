@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>Create Attraction</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.list_users')" :name="'Users list'"/>
      </div>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.create_user')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'text'" :name="'name'" :placeholder="'Name'"/>
      <x-input :type="'email'" :name="'email'" :placeholder="'Email'"/>
      <x-input :type="'password'" :name="'password'" :placeholder="'Password'"/>
      <x-input :type="'password'" :name="'password_confirmation'" :placeholder="'Password Confirmation'"/>
      <x-submit :value="'Create'" />
    </form>
    @if($created)
      <x-user-created/>
    @endif
  </div>
@endsection