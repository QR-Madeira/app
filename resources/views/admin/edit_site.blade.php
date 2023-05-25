<?php use function App\Auth\check; ?>
@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-4 lg:px-24'>
    <div class='grid sm:grid-cols-5 gap-3 flex items-center justify-center w-full relative'>
      <h1 class='row-start-1 sm:col-span-3 text-center text-5xl py-8'>@lang('Change Website info')</h1>
    </div>
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.update.site')}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <legend>@lang("Index Page")</legend>
      <p><label>@lang("Title in Portuguese"): <input required type="text" name="titlePt" value="{{$siteInfo->titlePt ?? old('title')}}" class="form-in"/></label></p>
      <p><label>@lang("Title in English"): <input required type="text" name="titleEng" value="{{$siteInfo->titleEng ?? old('titleEng')}}" class="form-in"/></label></p>
      <p><label>@lang("Description in Portuguese"): <input required type="text" name="descPt" value="{{$siteInfo->descPt ?? old('descPt')}}" class="form-in"/></label></p>
      <p><label>@lang("Description in English"): <input required type="text" name="descEng" value="{{$siteInfo->descEng ?? old('descEng')}}" class="form-in"/></label></p>
      <legend>@lang("Footer")</legend>
      <p><label>@lang("Footer Contacts"): <input required type="text" name="title" value="{{$title ?? old('title')}}" class="form-in"/></label></p>
      <p><label>@lang("Footer"): <input required type="text" name="title" value="{{$title ?? old('title')}}" class="form-in"/></label></p>
      <button type="submit" class="form-submit">@lang("Save")</button>
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="$status" :msg="$message"/>
    @endif
  </div>
@endsection