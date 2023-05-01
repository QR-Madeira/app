<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class="fixed top-0 left-0 w-64 h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-500 flex flex-col">
      <div class="w-auto h-auto rounded-lg bg-slate-700 items-center text-left mb-4 p-2">
        <p class="ml-2 mr-2 w-auto h-auto break-all text-white">{{Auth::user()->name}}</p>
      </div>  
       <ul class="space-y-2 font-medium flex flex-col justify-between h-full">
        <div class="space-y-2">
          <li>
              <a href="{{route('admin.list_users')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_usr') bg-slate-700 @endif hover:bg-slate-600">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span class="flex-1 ml-3 whitespace-nowrap">@lang('Users')</span>
              </a>
          </li>
          <li>
              <a href="{{route('admin.list')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_attr') bg-slate-700 @endif hover:bg-slate-600">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM21 9H3M21 15H3M12 3v18"/></svg>
                <span class="flex-1 ml-3 whitespace-nowrap">@lang('Attractions')</span>
              </a>
          </li>
        </div>
        <div class="space-y-2">
          <li>
            <x-language-changer :current="$current"/>
          </li>
          <li>
            <a href="{{route('signout')}}" class="flex items-center p-2 text-white rounded-lg hover:bg-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
              <span class="flex-1 ml-3 whitespace-nowrap">@lang('Sign Out')</span>
            </a>
          </li>
        </div>
       </ul>
    </div>
  </div>
  <div class="pl-64">
    @yield('body')
  </div>
</body>
</html>