<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8" />
<title>Email Verification</title>

<link rel="dns-prefetch" href="//example.com">
<link rel="preconnect" href="//example.com">
<link rel="preconnect" href="//cdn.example.com" crossorigin>
<link rel="prefetch" href="//example.com/next-page.html" as="document" crossorigin="use-credentials">
<link rel="prefetch" href="/library.js" as="script">
<link rel="prerender" href="//example.com/next-page.html">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,300,0,0" />
<style>
    .material-symbols-rounded.fs-24 { font-size: 24px; }
    .material-symbols-rounded.fs-36 { font-size: 36px; }
    .material-symbols-rounded.fs-48 { font-size: 48px; }
</style>
@vite('resources/css/app.css')

<link rel="author" href="https://github.com/QR-Madeira/">
<!-- <link rel="license" href=""> -->

<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta name="application-name" content="" />
<meta name="application-name" content="" lang="" />
<meta name="author" content="" />
<meta name="description" content="" />
<meta name="generator" content="" />
<meta name="keywords" content="" />
<meta name="referrer" content="" />
<meta name="theme-color" content="" />
<meta name="theme-color" content="" media="(prefers-color-scheme: dark)" />
<meta name="color-scheme" content="light" />

<meta name="apple-mobile-web-app-title" content="" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name="date" content="2023-05-20" />

<meta name="robots" content="all" />

</head>

<body class="my-4 mx-auto w-[120ch]">

<form class="grid grid-cols-1 gap-4 [&>p>label]:flex [&>p>label]:flex-col [&>p>label]:sm:flex-row" action="#" method="POST">
@csrf

<p><label class="flex flex-col sm:flex-row">@lang("Email"): <input required type="email" name="email" value="{{$email ?? ''}}" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Verification Code"): <input required type="text" name="code" value="{{$code ?? ''}}" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Password"): <input required type="password" name="password" class="form-in" /></label></p>
<p><label class="flex flex-col sm:flex-row">@lang("Password Confirmation"): <input required type="password" name="password_confirmation" class="form-in" /></label></p>

<button type="submit" class="form-submit">Verify</button>

</form>

</body>

</html>
