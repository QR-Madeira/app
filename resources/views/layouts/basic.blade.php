<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <x-header />
</head>

<body class="flex flex-col justify-between h-full">
    <main class="pb-6">
        @yield('body')
    </main>
    <x-footer :site="$siteInfo" />
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
