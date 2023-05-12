<?php use Illuminate\Support\Facades\Auth; ?>

<div class='grid grid-cols-5 p-4 w-full h-36'>
  <x-delete-alert :route="route('admin.delete.attraction', ['id' => $attraction->id])" :id="$attraction->id"/>

  <div class="h-28 w-28 flex flex-row items-center">
    <a target="_blank" href="{{asset($attraction['qr-code'])}}" download="{{$attraction->title}}"><img src="{{ asset($attraction['qr-code']) }}" alt="Local Image" class='w-full h-full'></a>
  </div>

  <h1 class='flex flex-row items-center text-xl'>{{$attraction->title}}</h1>

  <div class="overflow-auto py-4">
    <p class='flex flex-row items-center text-xl max-h-28'>{{$attraction->description}}</p>
  </div>

  <div class='flex flex-col  sm:flex-row items-center w-full justify-end space-x-2 col-span-2'>
    <x-a :url="route('view', ['title_compiled' => $attraction->title_compiled])" :name="__('View')"/>
    @if (Auth::user()->name === $attraction->creator_name)
      <x-a :url="route('admin.edit.attraction', ['id' => $attraction->id])" :name="__('Edit')"/>
    @endif
    <button onclick="document.getElementById('{{$attraction->id}}').style.display = 'block';" class='sm:py-4 sm:px-6 rounded border-red-600 border-2 text-red-600 hover:text-white hover:bg-red-600'>@lang('Delete')</button>
  </div>
</div>
