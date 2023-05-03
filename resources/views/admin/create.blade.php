@extends('layouts.admin-layout')

@section('body')
  <div class='py-4 px-96'>
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
      <button class="bg-black/[.10] text-black flex justify-center items-center rounded border-2 border-black/[.10] hover:bg-black/[.16] p-3 mb-12" id="add" onclick="event.preventDefault(); document.getElementById('add_close_location').style.display == 'block'?document.getElementById('add_close_location').style.display = 'none':document.getElementById('add_close_location').style.display = 'block';"><span class="material-symbols-rounded h-full">add</span>Add new location</button>
      <!--<div >-->
      <fieldset id="add_close_location" style="display: none">
        <label for="close_icon">Chose an icon for this location: </label>
        <select name="close_icon" id="close_icon" class="w-28 h-auto material-symbols-rounded fs-48">
          <option value="local_hospital">local_hospital</option>
          <option  value="shopping_cart">shopping_cart</option>
          <option value="account_balance">account_balance</option>
          <option value="hotel">hotel</option>
        </select>
        <x-input :type="'text'" :name="'close_name'" :placeholder="'Place name'"/>
        <x-input :type="'text'" :name="'close_location'" :placeholder="'Place location'"/>
        <x-input :type="'text'" :name="'close_phone'" :placeholder="'Place phone'"/>
        <button class="bg-black/[.10] text-black flex justify-center items-center rounded border-2 border-black/[.10] hover:bg-black/[.16] p-3 mb-12" id="add" onclick=""><span class="material-symbols-rounded h-full">add</span>Add new location</button>
      </fieldset>
       <!-- /CLOSE LOCATIONS -->
      <x-submit :value="'Create'"/>
    </form>
    @if($created)
      <x-attraction-created :route="$route"/>
    @endif
  </div>
@endsection