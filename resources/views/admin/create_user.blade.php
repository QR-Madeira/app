@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Create User')</h1>
    <div class='hidden sm:visible sm:absolute right-0'>
        <x-a :url="route('admin.list.users')" :name="'Users list'"/>
      </div>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.create.user')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'text'" :name="'name'" :value="old('name')" :placeholder="'Name'"/>
      <x-input :type="'email'" :name="'email'" :value="old('email')" :placeholder="'Email'"/>
      <x-input :type="'password'" :name="'password'" :placeholder="'Password'"/>
      <x-input :type="'password'" :name="'password_confirmation'" :placeholder="'Password Confirmation'"/>
<fieldset>

<legend>User permission: </legend>

@foreach($permissions as $k => $v)
  <p>
    <label class="select-none">
      @lang(ucfirst($k))
      <input type="checkbox" class="peer/standart" name="permissions[{{$k}}]" value="{{$v}}" @if($loop->first) checked @endif/>
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
