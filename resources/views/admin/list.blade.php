@extends('layouts.admin-layout')
@section('body')
  <div class='px-4 lg:px-24 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <div class='flex lg:flex-row flex-col flex-gap-1 items-center justify-center w-full relative pb-12'>
      <h1 class='text-5xl text-center py-8'>@lang('Attractions List')</h1>
      <div class='py-8 lg:absolute sm:right-0'>
        <x-a :url="route('admin.create.attraction')" :name="'Create Attraction'"/>
      </div>
    </div>
    @if(count($attractions) != 0)
      <div class='grid lg:grid-cols-5 grid-cols-2 p-4 border-2 rounded-t border-black border-b-0 w-full'>
        <h1 class="text-lg">@lang('Qr Code')</h1>
        <h1 class='text-lg lg:block hidden'>@lang('Name')</h1>
        <h1 class="text-lg lg:block hidden">@lang('Description')</h1>
        <h1 class="text-lg text-end">@lang('Actions')</h1>
      </div>
      <div class="w-full">
        @foreach ($attractions as $attr)
          <div class="@if(!$loop->last) border-b-0 @else rounded-b @endif border-2 border-black">
            <x-attraction :attraction="$attr" :userName="$userName"/>
          </div>
        @endforeach
      </div>
    @else
      <div class="p-4">
        <h1 class='text-2xl'>@lang('There are no attractions created')</h1>
      </div>
    @endif
  </div>
@endsection
