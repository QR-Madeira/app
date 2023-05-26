<footer class="flex-2 flex flex-col stiky left-0 bottom-0 text-sm/[14px] w-full">

  <div class="flex flex-col sm:flex-row bg-slate-800 text-white py-6 px-2">
    <ul class="flex flex-col sm:flex-row gap-6 justify-between align-center">
      <li class="flex items-center gap-2">
        <span class="material-symbols-rounded fs-14">distance</span>
        <p><strong>SEDE: </strong>{{$site['footerSede']}}</p>
      </li>
      <li class="flex items-center gap-2">
        <span class="material-symbols-rounded fs-14">phone</span>
        <p><strong>TELEFONE: </strong>{{$site['footerPhone']}}</p>
      </li>
      <li class="flex items-center gap-2">
        <span class="material-symbols-rounded fs-14">mail</span>
        <p><strong>MAIL: </strong>{{$site['footerMail']}}</p>
      </li>
    </ul>
  </div>
  <div class="flex flex-col gap-4 bg-white text-gray-500 p-4">
    <div class="flex text-center">
      <p>&copy; {{$site['footerCopyright']}}</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-3">
      <p><strong>Made by:</strong></p>
      <ul class="flex flex-wrap sm:flex-row gap-4 items-start sm:items-center">
        <li>
          <a href="https://epcc.pt">Associação de Ensino Cristóvão Colombo</a>
        </li>
        <li>
          <a href="https://github.com/AbreuDProgrammer"><p>Leonardo Abreu</p></a>
        </li>
        <li>
          <a href="https://github.com/Marado-Programmer"><p>João Torres</p></a>
        </li>
        <li>
          <a href="https://github.com/DaniloKy"><p>Danilo Kymhyr</p></a>
        </li>
      </ul>
    </div>
  </div>

</footer>