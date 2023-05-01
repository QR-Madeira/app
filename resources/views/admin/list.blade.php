@extends('layouts.admin-layout')
@section('body')
  <div class='px-96 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-5xl py-8'>@lang('Attractions List')</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.create')" :name="'Create Attraction'"/>
      </div>
    </div>
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
@endsection
