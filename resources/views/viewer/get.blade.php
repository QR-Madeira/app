@extends('layouts.layout')
@section('body')
  <div class='w-full max-h-screen grid grid-cols-2 justify-items-center p-4'>
    <div class='p-4 flex flex-row justify-start w-full'>
      <div class='w-fit'>
        <img src="{{ $image }}" alt="Local Image" class='w-full rounded-lg'>
      </div>
    </div>
    <div class='p-4 w-full'>
      <div class='text-center'>
        <h1 class='text-6xl'>{{$title}}</h1>
      </div>
      <div class='text-center p-8'>
        <p class='text-lg'><?= $description ?></p>
      </div>
    </div>
  </div>
@endsection