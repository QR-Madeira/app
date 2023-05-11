@extends('layouts.admin-layout')
@section('body')
  <div class='py-4 px-24'>
    <div class='flex items-center justify-center w-full relative'>
      <h1 class='text-center text-5xl py-8'>@lang('Add close locations')</h1>
      <div class='absolute left-0'>
        <x-a :url="route('admin.edit.attraction', ['id' => $attraction->id])" :name="$attraction->title"/>
      </div>
      <div class='absolute right-0'>
        <x-a :url="route('admin.list.attraction')" :name="__('Attractions list')"/>
      </div>

    </div>
    <h2 class='text-center text-3xl py-6'>@lang('Attraction'): <b>{{$attraction->title}}</b></h2>
    @if(count($attraction_locations) != 0)
      <div>
        <table class="border border-slate-500 w-full">
          <thead class="border border-slate-500">
            <tr>
              <th>icon</th>
              <th>name</th>
              <th>location</th>
              <th>phone</th>
              <th>Manage</th>
            </tr>
          </thead>
          <tbody>
            @foreach($attraction_locations as $attr_loc)
              <x-delete-alert :route="route('admin.delete.location', ['id' => $attr_loc->id])" :id="$attr_loc->id"/>
              <tr>
                <td><span class="material-symbols-rounded fs-36">{{$attr_loc->icon_path}}</span></td>
                <td>{{$attr_loc->name}}</td>
                <td>{{$attr_loc->location}}</td>
                <td>{{$attr_loc->phone}}</td>
                <td>
                  <x-a :url="route('admin.edit.location', ['id' => $attraction->id, 'id_2' => $attr_loc->id])" :name="__('Edit')"/>
                  <button onclick="document.getElementById('{{$attr_loc->id}}').style.display = 'block';" class='py-4 px-6 rounded bg-red-600 text-white'>@lang('Delete')</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="p-4">
        <h2 class='text-2xl'>@lang("Currently this attraction doesn't have close locations.")</h2>
      </div>
    @endif
    <x-show-required :errors="$errors"/>
    <form class="grid grid-cols-1 gap-4" action="{{route('admin.'.((isset($isPUT) && $isPUT)?'update':'create').'.location', $arr)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($isPUT) && $isPUT)
          @method("PUT")
        @endif
        <label for="close_icon">Choose  an icon for your location: </label>
        <select name="icon" id="close_icon" class="w-28 h-auto material-symbols-rounded fs-48">
            <option value="other_houses">other_houses</option>
            <option value="local_hospital">local_hospital</option>
            <option  value="shopping_cart">shopping_cart</option>
            <option value="account_balance">account_balance</option>
            <option value="hotel">hotel</option>
        </select>
        <label for="close_icon">If you can't find an icon that fits with your location simply leave the first one.</label>
        <x-input :type="'text'" :name="'name'" :value="isset($name)?$name:''" :placeholder="'Place name' "/>
        <x-input :type="'text'" :name="'location'" :value="isset($location)?$location:''" :placeholder="'Place location'"/>
        <x-input :type="'text'" :name="'phone'" :value="isset($phone)?$phone:''" :placeholder="'Place phone (Optional)'"/>
        <x-submit :value="isset($isPUT)?$isPUT?'Save':'Add location':'Add location'" />
    </form>
    @if(Session::has('status') && Session::has('message'))
      <x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')"/>
    @endif
  </div>
@endsection