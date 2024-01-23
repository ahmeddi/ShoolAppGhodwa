<div dir="rtl" class=" flex flex-col space-y-2 w-full h-full">
    <img wire:model='header' src="{{ asset('storage'.'/'.$header) }}" class="h-28 w-auto object-cover mb-3 "    />

    <div class="w-full flex mb-1 rounded-md p-2 border border-gray-600">

        <table class="w-full mb-1 text-sm text-right text-gray-800 rounded-t-md overflow-hidden dark:text-gray-200">  
                <tr class="  ">
                    <td class="w-1/6">الإسم:</td>
                    <td class="w-fit text-center font-bold">  {{ $etud->nom }} - {{ $etud->nomfr }} </td>
                    <td class="w-1/6 text-left">:Nom</td>
                </tr>
                <tr class="">
                    <td class="w-1/6">القسم:</td>
                    <td class="w-fit text-center font-bold">  {{ $etud->classe->nom }} </td>
                    <td class="w-1/6 text-left">:Classe</td>
                </tr>
                <tr class="">
                    <td class="w-1/6">رقم التسجيل :</td>
                    <td class="w-fit text-center font-bold">  {{ $etud->nb }} </td>
                    <td class="w-1/6 text-left">:Matricule</td>
                </tr>
                <tr class="">
                    <td class="w-1/6">الرقم التربوي  :</td>
                    <td class="w-fit text-center font-bold">  {{ $etud->nc }} </td>
                    <td class="w-1/6 text-left">:RIM</td>
                </tr>
                <tr class="">
                    <td class="w-1/6">السنة الدراسية :</td>
                    <td class="w-fit text-center font-bold">  2023 - 2024  </td>
                    <td class="w-1/6 text-left">:Année Scolaire
                    </td>
                </tr>
                <tr class="">
                    <td class="w-1/6">  </td>
                    <td class="w-fit text-center font-bold">  {{  $sem->nom }} - {{ $sem->nomfr }}  </td>
                    <td class="w-1/6 text-left">  </td>
                </tr>     
        </table>
        <div class=" w-28  h-fit overflow-hidden  mx-2 rounded-lg  ">
            @if ($etud->image)
                <img src="{{ asset('storage/'.$etud->image) }}" class="h-full w-auto object-cover "    />
            @else 
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full text-gray-200 dark:text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                </svg>
            @endif

        </div>
    </div>
    
    <div class="w-full m-4 flex  font-semibold text-2xl  justify-center dark:text-gray-50 print:dark:text-gray-900">
        كشف الدرجات
    </div>


    <div class=" flex w-full gap-x-4 text-sm">

        <table class="w-1/2 h-fit   text-right text-gray-900  dark:text-gray-400">
            <tr class=" h-10  divide-y divide-x divide-gray-900 dark:bg-gray-800 bg-gray-100 border border-gray-900">
                <th  class="py-1 px-3 border border-gray-900">   
                    <div>المواد</div>
                </th>
                <th  class="py-1 px-3 text-center border border-gray-900"> 
                    <div> الدرجات </div>
                </th>
            </tr>
            <tbody>
                @forelse ($Ara_result as $result)
                    <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                        <th  class="py-1 px-3 max-h-10 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                            {{   $result['nom']  }}
                        </th>
                        <td class="py-1 px-3  text-center font-mono">
                            <div  class="w-full flex ">
                                <div class="" >{{  $result['mat_tot'] }}</div>/
                                <div class=" font-semibold">{{ $result['exam_note']  }} </div>
                            </div>
                        </td>
                    </tr>   
                @empty
                @endforelse

                @if ($lang_count == 'fr')
                    @for ($i = 0; $i < $count; $i++)
                        <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                            <th  class="py-1 px-3 max-h-10 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                                <div class=" opacity-0">
                                    Placeholder
                                </div>
                            </th>
                            <td class="py-1 px-3  font-mono">
                                <div class=" opacity-0">
                                    Placeholder
                                </div>
                            </td>
                        </tr> 
                    @endfor     
                @endif
    
                <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                    <th  class="py-1 px-3 max-h-10 font-bold print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                        مجموع مواد العربية
                    </th>
                    <td class="py-1 px-3 font-semibold nt-mono">
                        <div  class="w-full flex ">
                            <div class="" >{{ $Ara_total }}</div>/
                            <div class=" font-bold">{{ $Ara_etud_total  }} </div>
                        </div>
                    </td>
                </tr> 
            </tbody>
        </table>

        <table class="w-1/2 h-fit   text-right text-gray-900  dark:text-gray-400">
                <tr class=" h-10  divide-y divide-x divide-gray-900 dark:bg-gray-800 bg-gray-100 border border-gray-900">
                    
                    <th  class="py-1 px-3 border text-center border-gray-900"> 
                        <div>Notes </div>
                    </th>
                    <th  class="py-1 px-3 border  text-left border-gray-900">   
                        <div>Matières </div>
                    </th>
                </tr>
            <tbody>
                @forelse ($Fra_result as $result)
                    <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                        
                        <th  class="py-1 px-3 max-h-10 font-mono font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                            <div  class="w-full flex ">
                                <div class="" >{{ $result['mat_tot'] }}</div>/
                                <div class=" font-semibold">{{ $result['exam_note']  }} </div>
                            </div>
                            
                        </th>
                        <td class="py-1 px-3   text-left">
                            {{   $result['nom']  }}
                        </td>
                    </tr>   
                @empty
                @endforelse

                @if ($lang_count == 'ar')
                    @for ($i = 0; $i < $count; $i++)
                        <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                            <th  class="py-1 px-3 max-h-10 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                                <div class=" opacity-0">
                                    Placeholder
                                </div>
                            </th>
                            <td class="py-1 px-3  font-mono">
                                <div class=" opacity-0">
                                    Placeholder
                                </div>
                            </td>
                        </tr> 
                    @endfor     
                @endif
                
    
                <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                    <th  class="py-1 px-3 max-h-10 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                        <div  class="w-full flex ">
                            <div class="" >{{ $Fra_total }}</div>/
                            <div class=" font-bold">{{ $Fra_etud_total  }} </div>
                        </div>
                    </th>
                    <td class="py-1 px-3 font-bold text-left ">
                        <div class="">
                            Total en Français
                        </div>
                    </td>
                </tr> 
            </tbody>
        </table>
    </div>

    <div class=" bg-gray-100 border border-gray-600 p-1 w-full flex justify-between print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
        <div class="w-1/3 px-3 text-right">
            المجموع
        </div>
        <div class="w-1/3  font-bold   text-center justify-center items-center ">
            {{ $Fra_total + $Ara_total }} / {{ $Fra_etud_total + $Ara_etud_total}} 
        </div>
        <div class="w-1/3 px-3 text-left">
            Total
        </div>
    </div>

    <div class="w-full flex justify-between print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
        <div class=" w-1/3 py-1 px-3 text-right font-bold">
            المعدل العام
        </div>
        <div  class="w-1/3 py-1 px-3 text-center font-bold text-lg">
          10 /  {{ $moy }} 
        </div>
        <div class="w-1/3 py-1 px-3 font-bold text-left ">
            Moyenne générale
        </div>
    </div>

    <div class="border border-gray-900 p-1 w-full flex justify-between print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
        <div class="px-3">
            الرتبة
        </div>
        <div class=" font-bold   text-center justify-center items-center ">
            <div>{{ $number }}</div>
        </div>
        <div class="px-3">
            Rang
        </div>
    </div>
    
    <div class="p-1 w-full flex justify-between print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
        <div>
            التقدير
        </div>
        <div class=" font-bold   text-center justify-center items-center ">
            <div>{{ $note }}</div>
        </div>
        <div>
            Mention
        </div>
    </div>
    
</div>
