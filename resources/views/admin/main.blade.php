@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-96'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>Admin Page</h1>
    </div>
    <div class='w-full flex flex-col items-center justify-center'>
        <div class='grow p-12'>
            <x-a :url="route('admin.list')" :name="'Manage Attractions'"/>
        </div>
        <div class='grow p-12'>
          <x-a :url="route('admin.list_users')" :name="'Manage Users'"/>
        </div>
    </div>
  </div>
@endsection