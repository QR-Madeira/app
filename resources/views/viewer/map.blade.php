@extends('layouts.layout')
@section('body')
  <div class="w-full pt-10 flex justify-center items-center">
    <h1 class="text-6xl">@lang('Map')</h1>
  </div>
  <div class="flex justify-center items-center pt-12">
    <x-map :lat="$lat" :lon="$lon"/>
  </div>
  @if($locations && count($locations) > 0)
  <div class="w-full pt-10 flex justify-center items-center">
    <h2 class="text-4xl">Close Locations</h2>
  </div>
  <div class="py-8">
    @foreach($locations as $location)
      <x-location :location="$location"/>
      <hr>
    @endforeach
  </div>
  @endif
@endsection
