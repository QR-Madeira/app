<?php use function App\Auth\check; ?>
@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-4 lg:px-24'>
    <div class='grid sm:grid-cols-5 gap-3 flex items-center justify-center w-full relative'>
      <a class="a-btn sm:row-start-1 mb-8" href="{{route('admin.edit.user', [ 'id' => $user->id ])}}">@lang('Go back')</a>
      <h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Password')</h1>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.user_pass', [ 'id' => $user->id ])}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <x-input :type="'password'" :name="'old_password'" :placeholder="'Current Password'"/>
      <x-input :type="'password'" :name="'password'" :placeholder="'New Password'"/>
      <x-input :type="'password'" :name="'password_confirmation'" :placeholder="'New Password Confirmation'"/>
      <a href="{{route('admin.edit.user_pass', ['id' => $user->id])}}">@lang("I forgot my password!")</a>
      <x-submit :value="'Change password'" />
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="$status" :msg="$message"/>
    @endif
  </div>
@endsection
