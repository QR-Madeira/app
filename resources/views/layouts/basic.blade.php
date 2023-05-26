<!DOCTYPE html>
<html lang="en">
<head>
  <x-header/>
</head>
<body class="">
  @yield('body')
  <x-footer :site="$siteInfo"/>
</body>
</html>