@extends('layouts.admin-layout')

@section('body')
  <div class='py-4 px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Create Attraction')</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.list')" :name="'Attractions List'"/>
      </div>
    </div>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.create')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <x-input :type="'text'" :name="'title'" :placeholder="'Title'"/>
      <textarea type="text" name="description" placeholder="@lang('Description')" class="p-4 bg-black/[.10] text-black rounded-lg placeholder:text-black"></textarea>
      <x-input :type="'file'" :name="'image'" :placeholder="'Image'"/>
      <x-input :type="'file'" :name="'gallery[]'" :placeholder="'Gallery'" :multiple="TRUE"/>
      <!-- CLOSE LOCATIONS -->
      <h2 class='text-center text-3xl py-8'>@lang('Close locations')</h2>
      <div class="flex flex-col space-y-4" id="location_form" style="display: none;"><x-close_location/></div>
      <button class="bg-black/[.10] text-black flex justify-center items-center rounded border-2 border-black/[.10] hover:bg-black/[.16] p-3 mb-8" id="add" onclick="event.preventDefault(); document.querySelector('#location_form').style.display = 'flex'; this.disabled = true"><span class="material-symbols-rounded h-full">add</span>Add new location</button>
       <!-- /CLOSE LOCATIONS -->
      <x-submit :value="'Create'"/>
    </form>
    @if($created)
      <x-attraction-created :route="$route"/>
    @endif
  </div>
@endsection
