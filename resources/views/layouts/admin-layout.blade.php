<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class="fixed top-0 left-0 lg:w-64 w-20 h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-500 flex flex-col">
       <ul class="space-y-2 font-medium flex flex-col justify-between h-full">
        <div class="space-y-2">
          <li>
            <a href="{{route('admin.list.attraction')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_attr') bg-slate-700 @endif hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">distance</span>
              <span class="flex-1 ml-3 whitespace-nowrap hidden lg:block">@lang('Attractions')</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.list.users')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_usr') bg-slate-700 @endif hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">group</span>
              <span class="flex-1 ml-3 whitespace-nowrap hidden lg:block">@lang('Users')</span>
            </a>
          </li>
        </div>
        <div class="space-y-2">
          <li>
            <x-language-changer :current="strtoupper(Session::get('locale'))"/>
          </li>
          <li>
            <a href="{{route('signout')}}" class="flex items-center p-2 text-white rounded-lg hover:bg-slate-600">
              <span class="material-symbols-rounded fs-36">logout</span>
              <span class="flex-1 ml-3 whitespace-nowrap lg:block hidden">@lang('Sign Out')</span>
            </a>
          </li>
        </div>
       </ul>
    </div>
  </div>
  <div class="lg:pl-64 pl-20">
    @yield('body')
  </div>
</body>
</html>
