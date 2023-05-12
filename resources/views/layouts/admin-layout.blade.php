<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class="sm:fixed top-0 left-0 lg:w-64 w-screen sm:h-screen">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-500 flex flex-col">
      <div class="w-auto h-auto rounded-lg bg-slate-700 items-center text-left mb-4 p-2">
        <p class="ml-2 mr-2 w-auto h-auto break-all text-white">{{Auth::user()->name}}</p>
      </div>
       <ul class="space-y-2 font-medium flex sm:flex-col justify-between sm:h-full">
        <div class="flex justify-between sm:spaces-y-2">
          <li>
              <a href="{{route('admin.list.attraction')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_attr') bg-slate-700 @endif hover:bg-slate-600">
                <span class="material-symbols-rounded fs-36">distance</span>
                <span class="hidden sm:visible flex-1 ml-3 whitespace-nowrap">@lang('Attractions')</span>
              </a>
          </li>
          <li>
              <a href="{{route('admin.list.users')}}" class="flex items-center p-2 text-white rounded-lg @if(Session::get('place') == 'admin_usr') bg-slate-700 @endif hover:bg-slate-600">
                <span class="material-symbols-rounded fs-36">group</span>
                <span class="hidden sm:visible flex-1 ml-3 whitespace-nowrap">@lang('Users')</span>
              </a>
          </li>
        </div>
        <div class="hidden sm:space-y-2">
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
