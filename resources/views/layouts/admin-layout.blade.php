<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class="fixed top-0 left-0 xl:w-64 w-20 h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-500 flex flex-col">
       <ul class="space-y-2 font-medium flex flex-col h-full">
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

<footer class="flex gap-4 align-center h-12">
<p><a class="h-full" ref="https://www.php.net/"><img class="h-max-full" src="https://www.php.net/images/logos/php-power-micro.png" alt="Powered by PHP" /></a></p>
<!-- <p><a class="h-full" rel="license" href="https://www.gnu.org/licenses/agpl-3.0.html"><img class="h-full" src="https://www.gnu.org/graphics/agplv3-with-text-162x68.png" alt="AGPL Logo" /></a></p> -->

<address class="h-full">
<p class="h-full"><a class="h-full" href="https://github.com/QR-Madeira"><img class="h-full" src="{{asset("images/GitHub-Mark.png")}}" alt="GitHub Logo" /></a></p>
</address>
</footer>

  </div>
  @if(session('error'))
    <script>
      console.error(`{{session("error")}}`);
      alert(`{{session("error")}}`);
    </script>
  @endif
</body>
</html>

<!--
LICENSE
-->
