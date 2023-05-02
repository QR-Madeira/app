@extends('layouts.admin-layout')
@section('body')
  <div class='px-24 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-5xl py-8'>@lang('Attractions List')</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.create')" :name="'Create Attraction'"/>
      </div>
    </div>
    <div class='grid grid-cols-6 p-4 border-2 rounded border-black w-full'>
      <h1 class="text-3xl">Qr Code</h1>
      <h1 class='text-3xl'>Name</h1>
      <h1 class="text-3xl">Description</h1>
      <h1 class="text-3xl">Created by:</h1>
      <h1 class="text-3xl">Created at:</h1>
      <h1 class="text-3xl">Actions</h1>
    </div>
    <div class="grid gap-4 py-4 w-full">
      @if(count($attractions) != 0)
        @foreach ($attractions as $attr)
          <x-attraction :attraction="$attr"/>
        @endforeach
      @else
        <div class="p-4">
          <h1 class='text-2xl'>@lang('There are no attractions created')</h1>
        </div>
      @endif
    </div>
  </div>
@endsection
