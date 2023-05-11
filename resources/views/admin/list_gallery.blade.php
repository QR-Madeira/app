@extends('layouts.admin-layout')
@section('body')
  <div class="px-24 py-4 space-y-4">
    <div class="flex flex-row justify-center items-center">
      <h1 class="text-6xl py-4">@lang('Gallery')</h1>
    </div>
    <div class="grid grid-cols-3 gap-4">
      @foreach ($images as $image)
        <div class="relative">
          <img src="{{$image['image_path']}}" alt="Gallery image" class="h-full rounded">
          <div class="absolute top-4 right-0">
            <x-a :url="route('admin.delete.image', ['id' => $image['id']])" :name="__('Delete')"/>
          </div>
        </div>
      @endforeach
      <div>
        <form action="{{route('admin.create.image')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="grid gap-4">
            <x-input :type="'hidden'" :name="'belonged_attraction'" :value="$belonged_attraction"/>
            <x-input :type="'file'" :name="'gallery[]'" :multiple="TRUE"/>
            <x-submit :value="__('Create')"/>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
