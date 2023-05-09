@extends('layouts.layout')
@section('body')
  <div class="w-full h-36 pt-10">
    <div class="fixed h-10 top-0 grid grid-cols-3 grid-rows-1 justify-items-center w-full">
      <a href="{{route('view', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Attraction</h2></a>
      <a href="{{route('view.gallery', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Gallery</h2></a>
      <a href="{{route('view.map', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-lg flex flex-row items-center justify-center h-full">Map</h2></a>
    </div>
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    <div class="w-full grid grid-cols-3 gap-4 p-4">
      @foreach ($images as $img)
        <img src="{{$img['image_path']}}" alt="Attraction Image" class="h-full">
      @endforeach
    </div>
  </div>
@endsection
