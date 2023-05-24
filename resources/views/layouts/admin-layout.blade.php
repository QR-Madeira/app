<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body class="relative min-h-screen">
  <div class="fixed top-0 left-0 xl:w-64 w-20 h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-500 flex flex-col">
       <ul class="space-y-2 font-medium flex flex-col h-full">
          <li>
            <a href="{{route('admin.main')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'main') bg-slate-700 @endif hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">home</span>
              <span class="flex-1 ml-3 whitespace-nowrap hidden xl:block">@lang('Main')</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.list.attraction')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_attr') bg-slate-700 @endif hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">distance</span>
              <span class="flex-1 ml-3 whitespace-nowrap hidden xl:block">@lang('Attractions')</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.list.users')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_usr') bg-slate-700 @endif hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">group</span>
              <span class="flex-1 ml-3 whitespace-nowrap hidden xl:block">@lang('Users')</span>
            </a>
          </li>
       </ul>
       <ul class="space-y-2 font-medium flex flex-col justify-end h-full">
          <li>
            <x-language-changer :current="strtoupper(Session::get('locale'))"/>
          </li>
          <li>
            <a href="{{route('signout')}}" class="flex items-center p-2 text-white rounded-lg hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">logout</span>
              <span class="flex-1 ml-3 whitespace-nowrap xl:block hidden">@lang('Sign Out')</span>
            </a>
          </li>
       </ul>
    </div>
  </div>
  <div class="xl:pl-64 pl-20">
    @yield('body')

<hr />

<footer class="flex gap-4 justify-between align-center h-10 absolute bottom-0 py-8">

  <address class="h-full">
    <p class="h-full">
      <a class="h-full" href="https://github.com/QR-Madeira"><img class="h-full" src="{{asset("images/GitHub-Mark.png")}}" alt="GitHub Logo" /></a>
    </p>
  </address>

  <div class="flex flex-row space-x-4 items-end">
    <h4 class="text-xl">Made by</h4>
    <a href="https://github.com/AbreuDProgrammer"><h5 class="text-lg">Leonardo Abreu</h5></a>
    <a href="https://github.com/Marado-Programmer"><h5 class="text-lg">João Torres</h5></a>
    <a href="https://github.com/DaniloKy"><h5 class="text-lg">Danilo Kymhyr</h5></a>
  </div>

</footer>

  </div>
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

<!--
LICENSE
-->
