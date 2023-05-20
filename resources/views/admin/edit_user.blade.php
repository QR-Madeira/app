<?php use function App\Auth\check; ?>
@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Edit User')</h1>
    <div class='hidden sm:visible sm:absolute right-0'>
        <x-a :url="route('admin.list.users')" :name="'Users list'"/>
      </div>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.user', [ 'id' => $user->id ])}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <x-input :type="'text'" :name="'name'" :value="$user->name ?? old('name')" :placeholder="'Name'"/>
      <x-input :type="'password'" :name="'old_password'" :placeholder="'Current Password'"/>
      <x-input :type="'password'" :name="'password'" :placeholder="'New Password'"/>
      <x-input :type="'password'" :name="'password_confirmation'" :placeholder="'New Password Confirmation'"/>
<fieldset>

<legend>User permission: </legend>

@foreach($permissions as $k => $v)
  <p>
    <label class="select-none">
      @lang(ucfirst($k))
      <input type="checkbox" class="peer/standart" name="permissions[{{$k}}]" value="{{$v}}" <?php if(isset($user) && check($user, $v)) echo 'checked'?>/>
    </label>
  </p>
@endforeach

</fieldset>
      <x-submit :value="'Create'" />
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="$status" :msg="$message"/>
    @endif
  </div>
@endsection
