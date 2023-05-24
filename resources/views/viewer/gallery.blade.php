@extends('layouts.layout')
@section('body')
  <div class="w-full">
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    @if ($images)
      <div class="w-full grid grid-cols-1 xl:grid-cols-3 gap-4 p-4">
        @foreach ($images as $img)
          <img src="{{$img['image_path']}}" alt="Attraction Image" class="h-full rounded">
        @endforeach
      </div>
    @else
      <div class="text-center py-4">
        <h1 class="text-4xl">@lang('No gallery to show')</h1>
      </div>
    @endif
  </div>
@endsection
