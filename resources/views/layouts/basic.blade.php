<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <x-header/>
</head>
<body class="flex flex-col h-full">
    <main class="pb-2">
      @yield('body')
    </main>
    <x-footer :site="$siteInfo"/>
</body>
</html>