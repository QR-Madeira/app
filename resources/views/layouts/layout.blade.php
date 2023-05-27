<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body class="flex flex-col min-h-screen">
  <div class="fixed h-10 top-0 grid grid-cols-3 grid-rows-1 justify-items-center w-full h-auto bg-white py-2">
    <a class="grid grid-cols-1 xl:grid-cols-2 xl:gap-6" href="{{route('view', ['title_compiled' => $title_compiled])}}" class="w-full">
      <span class="material-symbols-rounded fs-36 xl:flex xl:justify-end">dashboard</span>
      <h2 class="text-2xl hidden xl:block">@lang('Attraction')</h2>
    </a>
    <a class="grid grid-cols-1 xl:grid-cols-2 xl:gap-6" href="{{route('view.gallery', ['title_compiled' => $title_compiled])}}" class="w-full">
      <span class="material-symbols-rounded fs-36 xl:flex xl:justify-end">gallery_thumbnail</span>
      <h2 class="text-2xl hidden xl:block">@lang('Gallery')</h2>
    </a>
    <a class="grid grid-cols-1 xl:grid-cols-2 xl:gap-6" href="{{route('view.map', ['title_compiled' => $title_compiled])}}" class="w-full">
      <span class="material-symbols-rounded fs-36 xl:flex xl:justify-end">distance</span>
      <h2 class="text-2xl hidden xl:block">@lang('Map')</h2>

    </a>
  </div>
  @if($isLogged)
    <div class="fixed top-16 w-full">
      <a href="{{route('admin.list.attraction')}}"><h2 class="text-2xl text-center flex flex-row items-center justify-center h-full">@lang('Admin')</h2></a>
    </div>
  @endif
  <div class="pt-24">
    @yield('body')
  </div>
  <x-footer :site="$siteInfo"/>
  @if (session('error'))
      <dialog class="bg-slate-700 p-8 rounded text-red-500 [&>*]:py-4" id="errors" open>
        <h1>@lang('Error'):</h1>
        <p><strong><code>{{session("error")}}<code><strong></p>
        <form method="dialog">
          <button autofocus type="submit" class="form-submit bg-slate-600 hover:bg-slate-500 text-white">Okay</button>
        </form>
      </dialog>
    <script>
      document.querySelector("#errors")?.close();
      document.querySelector("#errors")?.showModal();
    </script>
  @endif
</body>
</html>
