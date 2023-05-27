@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-4 lg:px-24'>
    <div class='grid sm:grid-cols-5 gap-3 flex items-center justify-center w-full relative'>
      <div class="sm:row-start-1"></div>
      <h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Password')</h1>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.user_pass', [ 'id' => $user->id ])}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <p><label>@lang("Current Password"): <input required type="password" name="old_password" class="form-in"/></label></p>
      <p><label>@lang("New Password"): <input required type="password" name="password" class="form-in"/></label></p>
      <p><label>@lang("New Password Confirmation"): <input required type="password" name="password_confirmation" class="form-in"/></label></p>
      <a href="{{route('admin.edit.user_pass', ['id' => $user->id])}}">@lang("I forgot my password!")</a>
      <button type="submit" class="form-submit">@lang("Change Password")</button>
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="$status" :msg="$message"/>
    @endif
  </div>
@endsection
