@extends('layouts.layout')
@section('body')
  <div class="w-full pt-10 flex justify-center items-center">
    <h1 class="text-6xl">Map</h1>
  </div>
  <div class="flex justify-center items-center pt-12">
    <x-map :lat="$lat" :lon="$lon"/>
  </div>
@endsection
