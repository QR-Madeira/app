@extends('layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>Create Attraction</h1>
      <div class='absolute right-0'>
        <x-a :url="route('admin.list')" :name="'List'"/>
      </div>
    </div>
    <form class="grid grid-cols-1" action="{{route('admin.create')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="text" name="title" placeholder="Title" class="p-4 bg-black/[.10] text-black rounded-lg my-4 placeholder:text-black">
      <textarea type="text" name="description" placeholder="Description" class="p-4 bg-black/[.10] text-black rounded-lg my-4 placeholder:text-black"></textarea>
      <input type="file" name="image" placeholder="Image" class="p-4 bg-black/[.10] text-black rounded-lg my-4">
      <input type="submit" value="Create" class="p-4 bg-green-700 text-white rounded-lg my-4 cursor-pointer">
    </form>
  </div>
@endsection