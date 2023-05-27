@extends('layouts.admin-layout')
@section('body')
<div class='px-4 xl:px-24 py-4 grid grid-rows-auto grid-cols-1 justify-items-center'>
    <nav class="py-4 grid sm:grid-cols-5 gap-3">
        <div class="sm:row-start-1"></div>
        <h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">@lang('Users List')</h1>
        @if(isset($canCreate) && $canCreate === true)
        <a class="a-btn" href="{{route('admin.create.user')}}">@lang("Create User")</a>
        @else
        <div></div>
        @endif
    </nav>

    <section class="flex gap-4 items-center">
        <h2>@lang("Your user")</h2>
        <x-delete-alert :route="route('admin.delete.user', ['id' => $you->id])" :id="$you->id" />
        <div class="py-4 flex flex-col sm:flex-row justify-center sm:[&>*]:w-full gap-4 h-full">
            <a class="a-btn" href="{{route('admin.edit.user_pass', ['id' => $you->id])}}">@lang("Change password")</a>
        </div>
    </section>

    <hr />

    @if(isset($canCreate) && $canCreate === true)
    @if(isset($users) && is_iterable($users) && count($users) != 0)
    <table class="my-4 border border-slate-500 w-full">
        <thead class="border border-slate-500">
            <tr>
                <th>@lang("Name")</th>
                <th>@lang("Actions")</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <x-delete-alert :route="route('admin.delete.user', ['id' => $user->id])" :id="$user->id" />
            <tr>
                <td>
                    <div class="flex justify-center ">{{$user->name}}</div>
                </td>
                <td>
                    <div class="py-4 flex flex-col sm:flex-row justify-center sm:[&>*]:w-full gap-4 h-full">
                        <a class="a-btn" href="{{route('admin.edit.user', ['id' => $user->id])}}">@lang("Edit")</a>
                        @if(!$user->super)
                        <button onclick="document.getElementById('{{$user->id}}').style.display = 'block';" class='a-btn bg-red-600 text-white'>@lang('Delete')</button>
                        @endif
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
    @endif
    @if(Session::has('status') && Session::has('message'))
    <x-success_error_msg :status="Session::get('status')" :msg="Session::get('message')" />
    @endif
</div>
@endsection
