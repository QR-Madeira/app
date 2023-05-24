<?php use function App\Auth\check; ?>
@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-4 lg:px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Edit User')</h1>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.user', [ 'id' => $user->id ])}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <x-input :type="'text'" :name="'name'" :value="$user->name ?? old('name')" :placeholder="'Name'"/>
      <div class="grid grid-cols-2">
        <fieldset class="col-span-2 sm:col-span-1">
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
        <a class="a-btn col-span-2 sm:col-span-1 my-8" href="{{route('admin.edit.user_pass', ['id' => $user->id])}}">@lang("Change password")</a>
      </div>
      <x-submit :value="'Save'" />
    </form>
  </div>
@endsection
