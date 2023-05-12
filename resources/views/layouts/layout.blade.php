<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class="fixed h-10 top-0 grid grid-cols-3 grid-rows-1 justify-items-center w-full bg-white">
    <a href="{{route('view', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-2xl flex flex-row items-center justify-center h-full">@lang('Attraction')</h2></a>
    <a href="{{route('view.gallery', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-2xl flex flex-row items-center justify-center h-full">@lang('Gallery')</h2></a>
    <a href="{{route('view.map', ['title_compiled' => $title_compiled])}}" class="w-full"><h2 class="text-2xl flex flex-row items-center justify-center h-full">@lang('Map')</h2></a>
  </div>
  @if($isLogged)
    <div class="fixed top-16 w-full">
      <a href="{{route('admin.list.attraction')}}"><h2 class="text-2xl text-center flex flex-row items-center justify-center h-full">@lang('Admin')</h2></a>
    </div>
  @endif
  <div class="pt-24">
    @yield('body')
  </div>
</body>
</html>
