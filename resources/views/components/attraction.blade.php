<?php use Illuminate\Support\Facades\Auth; ?>

<div class='grid lg:grid-cols-5 grid-cols-2 p-4 w-full h-36'>
  <x-delete-alert :route="route('admin.delete.attraction', ['id' => $attraction->id])" :id="$attraction->id"/>

  <div class="h-28 w-28 flex flex-row items-center">
    <a target="_blank" href="{{asset($attraction['qr-code'])}}" download="{{$attraction->title}}"><img src="{{ asset($attraction['qr-code']) }}" alt="Local Image" class='w-full h-full'></a>
  </div>

  <h1 class='lg:flex flex-row items-center text-xl hidden'>{{$attraction->title}}</h1>

  <div class="lg:block overflow-auto py-4 hidden">
    <p class='flex flex-row items-center text-xl max-h-28'>{{$attraction->description}}</p>
  </div>

  <div class='flex lg:flex-row flex-col lg:items-center items-end w-full justify-end space-x-2 lg:col-span-2'>
    <x-a :url="route('view', ['title_compiled' => $attraction->title_compiled])" :name="__('View')"/>
    @if (Auth::user()->name === $attraction->creator_name)
      <x-a :url="route('admin.edit.attraction', ['id' => $attraction->id])" :name="__('Edit')"/>
    @endif
    <button onclick="document.getElementById('{{$attraction->id}}').style.display = 'block';" class='lg:py-4 lg:px-6 py-1 px-2 rounded border-red-600 border-2 text-red-600 hover:text-white hover:bg-red-600'>@lang('Delete')</button>
  </div>
</div>
