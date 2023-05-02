@extends('layouts.admin-layout')
@section('body')
  <div class='px-24 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-5xl py-8'>@lang('Attractions List')</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.create')" :name="'Create Attraction'"/>
      </div>
    </div>
    <div class='grid grid-cols-6 p-4 border-2 rounded-t border-black border-b-0 w-full'>
      <h1 class="text-lg">@lang('Qr Code')</h1>
      <h1 class='text-lg'>@lang('Name')</h1>
      <h1 class="text-lg">@lang('Description')</h1>
      <h1 class="text-lg">@lang('Created by'):</h1>
      <h1 class="text-lg">@lang('Created at'):</h1>
      <h1 class="text-lg">@lang('Actions')</h1>
    </div>
    <div class="w-full">
      @if(count($attractions) != 0)
        @foreach ($attractions as $attr)
          <div class="@if(!$loop->last) border-b-0 @else rounded-b @endif border-2 border-black">
            <x-attraction :attraction="$attr"/>
          </div>
        @endforeach
      @else
        <div class="p-4">
          <h1 class='text-2xl'>@lang('There are no attractions created')</h1>
        </div>
      @endif
    </div>
  </div>
@endsection
