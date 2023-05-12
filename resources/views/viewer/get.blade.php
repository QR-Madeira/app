@extends('layouts.layout')
@section('body')
  <div class="w-full">
    <div class="w-full flex items-center justify-center p-8">
      <h1 class="text-5xl">{{$title}}</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 px-8">
      <div class="flex items-center justify-center">
        <img src="{{$image}}" alt="Attraction Image" class="rounded">
      </div>
      <div class="w-full flex items-start justify-start p-8">
        <p class="text-lg"><?= $description ?></p>
      </div>
    </div>
  </div>
@endsection
