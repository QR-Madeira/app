@extends('layouts.admin-layout')
@section('body')
  <div class="xl:px-24 xl:py-4 px-4 space-y-4">
    <nav class="grid sm:grid-cols-5 gap-3">
      <a class="a-btn sm:row-start-1" href="{{route('admin.edit.attraction', ['id' => $id])}}">{{$title}}</a>
      <h1 class='row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7'>@lang('Gallery')</h1>
      <a class="a-btn" href="{{route('admin.list.attraction')}}">@lang("Attractions List")</a>
    </nav>
    <div class="grid xl:grid-cols-3 grid-cols-1 gap-4">
      @foreach ($images as $image)
        <div class="relative">
          <img src="{{$image['image_path']}}" alt="Gallery image" class="h-full rounded">
          <div class="absolute top-4 right-0">
            <a class="a-btn bg-red-600 text-white" href="{{route('admin.delete.image', ['id' => $image['id']])}}">@lang('Delete')</a>
          </div>
        </div>
      @endforeach
      <div class="mt-14">
        <form action="{{route('admin.create.image')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="grid gap-4">
            <input type="hidden" name="belonged_attraction" value="{{$belonged_attraction}}">
            <p><label>@lang("Gallery"): <input type="file" name="gallery[]" multiple class="form-in" /></label></p>
            <button type="submit" class="form-submit">@lang("Add")</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
