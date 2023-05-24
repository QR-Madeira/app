@extends('layouts.layout')
@section('body')
  <div class="w-full">
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 xl:px-8">
      <img src="{{$image}}" alt="Attraction Image" class="rounded">
      <div class="w-full flex items-start justify-start px-8">
        <p class="text-lg"><?= $description ?></p>
      </div>
    </div>
  </div>
@endsection
