<div class='grid grid-cols-2 gap-1'>
  <a href="{{route('language', ['locale' => 'pt'])}}" class='py-1 px-2 @if($current == 'PT') bg-slate-700 @else bg-black @endif text-white text-xs rounded'>PT</a>
  <a href="{{route('language', ['locale' => 'en'])}}" class='py-1 px-2 @if($current == 'EN') bg-slate-700 @else bg-black @endif text-white text-xs rounded'>EN</a>
</div>