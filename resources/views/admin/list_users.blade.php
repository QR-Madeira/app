@extends('layouts.admin-layout')
@section('body')
  <div class='xl:px-24 px-4 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <div class='flex xl:flex-row flex-col items-center justify-center w-full relative'>
      <h1 class='text-5xl text-center py-8'>@lang('Users List')</h1>
      <div class='xl:absolute xl:right-0'>
        <x-a :url="route('admin.create.user')" :name="'Create User'"/>
      </div>
    </div>
    @if(is_iterable($users) && count($users) != 0)
    <table class="my-4 border border-slate-500 w-full">
      <thead class="border border-slate-500">
        <tr>
          <th>@lang("Name")</th>
          <th>@lang("Actions")</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <x-delete-alert :route="route('admin.delete.user', ['id' => $user->id])" :id="$user->id"/>
          <tr>
            <td>
              <div class="flex justify-center ">{{$user->name}}</div>
            </td>
            <td>
              <div class="py-4 flex flex-col sm:flex-row justify-center sm:[&>*]:w-full gap-4 h-full">
                <a class="a-btn" href="{{route('admin.edit.attraction', ['id' => $user->id])}}">@lang("Edit")</a>
                <button onclick="document.getElementById('{{$user->id}}').style.display = 'block';" class='a-btn bg-red-600 text-white'>@lang('Delete')</button>
              </div>
            </td>
          </tr>
      @endforeach
      </tbody>
    </table>
    <p>{{$users->links()}}</p>
    @else
      <div class="p-4">
        <h1 class='text-2xl'>There are no users created</h1>
      </div>
    @endif
  </div>
@endsection
