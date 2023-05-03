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
      <h2 class='text-center text-3xl py-8'>@lang('Close locations')</h2>
      <label for="close_icon">Chose an icon: </label>
      <select name="close_icon" id="close_icon">
        <option data-icon="glyphicon-glass" value="">A</option>
        <option data-icon="glyphicon-glass" value="">B</option>
        <option data-icon="glyphicon-glass" value="">C</option>
      </select>
      <x-input :type="'text'" :name="'close_name'" :placeholder="'Place name'"/>
      <x-input :type="'text'" :name="'close_location'" :placeholder="'Place location'"/>
      <x-input :type="'text'" :name="'close_phone'" :placeholder="'Place phone'"/>
      <x-submit :value="'Create'"/>
    </form>
    @if($created)
      <x-attraction-created :route="$route"/>
    @endif
  </div>
@endsection