<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body>
  <div class='absolute top-0 left-0 p-4'>
    <x-a :url="route('admin.main')" :name="'Home Page'"/>
  </div>
  <div class='absolute top-0 right-0 p-4'>
    <a href="{{route('admin.main')}}" class="text-black py-2 px-6 border rounded">Logout</a>
  </div>
  <div class='absolute top-12 right-0 p-4'>
    <x-language-changer :current="$current"/>
  </div>
  @yield('body')
</body>
</html>