<footer class="flex-2 flex flex-col gap-4 mt-auto text-sm/[14px] w-full">
    <address class="flex flex-col sm:flex-row bg-slate-800 text-white py-4 px-2">
        <ul class="flex flex-col sm:flex-row text-xs gap-4 justify-between align-center">
            <li class="flex items-center gap-2">
                <span class="material-symbols-rounded fs-14">distance</span>
                <p><strong>SEDE: </strong>{{$site['footerSede']}}</p>
            </li>
            <li class="flex items-center gap-2">
                <span class="material-symbols-rounded fs-14">phone</span>
                <p><strong>TELEFONE:</strong> <a href="tel:{{$site['footerPhone']}}">{{$site['footerPhone']}}</a></p>
            </li>
            <li class="flex items-center gap-2">
                <span class="material-symbols-rounded fs-14">mail</span>
                <p><strong>MAIL:</strong> <a href="mailto:{{$site['footerMail']}}">{{$site['footerMail']}}</a></p>
            </li>
        </ul>
    </address>
    <div class="grid sm:grid-cols-2 gap-4 [&>*]:text-gray-500">
        <div class="flex flex-row gap-4 bg-white px-4">
            <div class="flex text-center">
                <p>&copy; {{$site['footerCopyright']}}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <p><strong>Made by:</strong></p>
                <ul class="flex flex-wrap flex-row sm:flex-col gap-4 items-start">
                    <li>
                        <a target="_blank" href="https://epcc.pt">Associação de Ensino Cristóvão Colombo</a>
                    </li>
                    <li>
                        <ul class="flex flex-wrap flex-row sm:flex-col gap-1 items-start text-xs">
                            <li><a target="_blank" href="https://github.com/AbreuDProgrammer">Leonardo Abreu</a></li>
                            <li><a target="_blank" href="https://github.com/torres-developer">João Torres</a></li>
                            <li><a target="_blank" href="https://github.com/DaniloKy">Danilo Kymhyr</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
            @if(!empty($site["socials"]))
        <section class="flex flex-row gap-4 bg-white px-4">
            <ul class="flex max-w-[35ch] overflow-y-auto p-4 sm:m-auto gap-4 sm:justify-center">
            @foreach($site["socials"] as $s)
            <li><a target="_blank" href="{{$s["uri"]}}"><img src="/images/{{$s["ico"]}}" width="32" class="w-[32px] aspect-square object-cover" alt="{{$s["description"]}}" /></a></li>
            @endforeach
            </ul>
        </section>
            @endif
    </div>
</footer>
