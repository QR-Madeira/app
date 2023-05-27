@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-4 lg:px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Create User')</h1>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.create.user')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <p><label>@lang("Name"): <input required type="text" name="name" value="{{$name ?? old('name')}}" class="form-in" /></label></p>
      <p><label>@lang("Email"): <input required type="email" name="email" value="{{$email ?? old('email')}}" class="form-in" /></label></p>
<fieldset>

<legend>@lang("User permission"): </legend>

@foreach($permissions as $k => $v)
  <p class="pl-4">
    <label class="select-none">
      @lang(ucfirst($k))
      <input type="checkbox" class="peer/standart" name="permissions[{{$k}}]" value="{{$v}}"/>
    </label>
  </p>
@endforeach

</fieldset>
      <button type="submit" class="form-submit">@lang("Create")</button>
    </form>
  </div>
@endsection
