@if($status)
    <div class='w-full flex items-center justify-center p-4'>
        <div class='p-4 grid grid-rows-2 gap-4 w-auto rounded'>
            <h1 class='text-2xl p-4 bg-white text-green-500 rounded'>@lang($msg)</h1>
        </div>
    </div>
@else
    <div class='w-full flex items-center justify-center p-4'>
        <div class='p-4 grid grid-rows-2 gap-4 w-auto rounded'>
            <h1 class='text-2xl p-4 bg-white text-red-500 rounded'>@lang($msg)</h1>
        </div>
    </div>
@endif