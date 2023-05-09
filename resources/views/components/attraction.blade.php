<?php use Illuminate\Support\Facades\Auth; ?>

<div class='grid grid-cols-5 p-4 w-full h-36'>
  <x-delete-alert :route="route('admin.delete', ['id' => $attraction->id])" :id="$attraction->id"/>

  <div class="h-28 w-28 flex flex-row items-center">
    <a target="_blank" href="{{asset($attraction['qr-code'])}}" download="{{$attraction->title}}"><img src="{{ asset($attraction['qr-code']) }}" alt="Local Image" class='w-full h-full'></a>
  </div>

  <h1 class='flex flex-row items-center text-xl'>{{$attraction->title}}</h1>

  <div class="overflow-auto">
    <h1 class='flex flex-row items-center text-xl max-h-28'>{{$attraction->description}}</h1>
  </div>

  <div class='flex flex-row items-center w-full justify-end space-x-2 col-span-2'>
    <button onclick="location.href='<?= route('view', ['title_compiled' => $attraction->title_compiled]) ?>'" class='text-xl py-4 px-6 rounded bg-black text-white'>@lang('View')</button>
    @if (Auth::user()->name === $attraction->creator_name)
      <a class="px-6 py-4 text-xl bg-yellow-300 rounded" href="{{route("admin.updater", $attraction->id)}}">Update</a>
    @endif
    <button onclick="document.getElementById('{{$attraction->id}}').style.display = 'block';" class='text-xl py-4 px-6 rounded bg-red-600'>@lang('Delete')</button>
  </div>
</div>
