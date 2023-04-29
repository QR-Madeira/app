@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>Create User</h1>
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
      <fieldset>
        <legend>User permission: </legend>
        <input type="radio" class="peer/standart" name="user_type" id="standart">
        <label for="standart">@lang('Standart')</label>
        <input type="radio" class="ml-12 peer/admin" name="user_type" id="admin">
        <label for="admin">@lang('Admin')</label>
        <div class="hidden peer-checked/standart:block">Standart users can only create, update and delete their attractions.</div>
        <div class="hidden peer-checked/admin:block">Admins can manage everything about atrractions and users.</div>
      </fieldset>
      <x-submit :value="'Create'" />
    </form>
    @if(Session::has('status'))
      @if(Session::get('status'))
        <x-user-created/>
      @else
        <p>as</p>
      @endif
    @endif
  </div>
@endsection