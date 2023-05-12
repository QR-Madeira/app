@extends('layouts.admin-layout')
@section('body')
  <div class="lg:px-24 lg:py-4 px-4 space-y-4">
    <div class="lg:flex lg:flex-row lg:justify-center lg:items-center lg:relative grid grid-cols-2 grid-rows-2">
      <h1 class="text-6xl py-4 col-span-2 text-center">@lang('Gallery')</h1>
      <div class='lg:absolute lg:left-0 flex items-center justify-center'>
        <x-a :url="route('admin.edit.attraction', ['id' => $id])" :name="$title"/>
      </div>
      <div class='lg:absolute lg:right-0 flex items-center justify-center'>
        <x-a :url="route('admin.list.attraction')" :name="__('Attractions list')"/>
      </div>
    </div>
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-4">
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
