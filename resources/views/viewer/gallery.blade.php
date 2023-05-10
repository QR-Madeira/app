@extends('layouts.layout')
@section('body')
  <div class="w-full h-36 pt-10">
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 p-4">
      @foreach ($images as $img)
        <img src="{{$img['image_path']}}" alt="Attraction Image" class="h-full rounded">
      @endforeach
    </div>
  </div>
@endsection
