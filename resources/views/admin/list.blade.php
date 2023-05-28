@extends('layouts.admin-layout')
@section('body')
<div class='px-4 xl:px-24 py-4 grid grid-rows-auto grid-cols-1 justify-center'>

  <nav class="py-4 grid sm:grid-cols-5 gap-3">
    <div class="sm:row-start-1"></div>
    <h1 class="row-start-1 sm:col-span-3 text-center text-4xl antialiased font-bold py-7">@lang('Attractions List')</h1>
    <a class="a-btn" href="{{route('admin.create.attraction')}}">@lang("Create Attraction")</a>
  </nav>

  @if(is_iterable($attractions) && (count($attractions) > 0))
  <table class="my-4 border border-slate-500 w-full">

  <colgroup><col>
  <colgroup><col><col>
  <colgroup><col>

  <thead class="border border-slate-500">
    <tr>
      <th class="sm:table-cell hidden">@lang('Qr Code')
      <th>@lang("Name")
      <th class="sm:table-cell hidden">@lang("Description")
      <th>@lang("Actions")
    </tr>
  </thead>

  <tbody>
    @foreach($attractions as $a)
    <x-delete-alert :route="route('admin.delete.attraction', ['id' => $a->id])" :id="$a->id"/>
    <tr>
      <td class="sm:table-cell hidden h-4"><a href="{{asset($a['qr-code'])}}" download="{{$a->title_compiled}}"><img src="{{ asset($a['qr-code']) }}" alt="Local Image" class="min-w-[124px] aspect-square p-4"></a></td>
      <td><span class="flex justify-center">{{$a->title}}</span></td>
      <td class="sm:table-cell hidden">
        <div class="w-[35ch] max-h-[35ch] break-words overflow-y-auto hyphens-auto" lang="{{App::currentLocale()}}">
          {{$a->description}}
        </div>
      </td>
      <td>
      <div class="py-4 flex flex-col gap-4 h-full">
        <a class="a-btn" href="{{route('view', ['title_compiled' => $a->title_compiled])}}">@lang("View")</a>
        <a class="a-btn" href="{{route('admin.edit.attraction', ['id' => $a->id])}}">@lang("Edit")</a>
        <button onclick="document.getElementById('{{$a->id}}').style.display = 'block';" class='a-btn bg-red-600 text-white'>@lang('Delete')</button>
      </div>
      </td>
    </tr>
    @endforeach
  </table>

  <p>{{$attractions->links()}}</p>

  @else
  <p class="text-black/50 p-4 text-2xl">@lang('There are no attractions created')</p>
  @endif

</div>
@endsection
