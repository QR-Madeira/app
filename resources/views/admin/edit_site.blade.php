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
      <p><label>@lang("Title"): <input required type="text" name="title" value="{{$siteInfo->title ?? old('title')}}" class="form-in"/></label></p>
      <p><label>@lang("Description"): <textarea required type="text" name="desc" rows="10" class="form-in">{{$siteInfo->desc ?? old('desc')}}</textarea></label></p>
      <legend>@lang("Footer")</legend>
      <p><label>@lang("Footer Sede"): <input required type="text" name="footerSede" value="{{$siteInfo->footerSede ?? old('footerSede')}}" class="form-in"/></label></p>
      <p><label>@lang("Footer Phone"): <input required type="text" name="footerPhone" value="{{$siteInfo->footerPhone ?? old('footerPhone')}}" class="form-in"/></label></p>
      <p><label>@lang("Footer Mail"): <input required type="text" name="footerMail" value="{{$siteInfo->footerMail ?? old('footerMail')}}" class="form-in"/></label></p>
      <p><label>@lang("Footer Copyright"): <input required type="text" name="footerCopyright" value="{{$siteInfo->footerCopyright ?? old('footerCopyright')}}" class="form-in"/></label></p>
      <button type="submit" class="form-submit">@lang("Save")</button>
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="$status" :msg="$message"/>
    @endif
  </div>
@endsection