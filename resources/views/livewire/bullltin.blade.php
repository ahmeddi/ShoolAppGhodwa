<div dir="rtl" class=" flex flex-col space-y-2 w-full h-full">
    <img wire:model='header' src="{{ asset('storage'.'/'.$header) }}" class="h-32 w-auto object-cover mb-3 "    />

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
    
    <div class="w-full m-4 flex font-semibold text-2xl  justify-center dark:text-gray-50 print:dark:text-gray-900">
        كشف الدرجات
    </div>

    <table class="w-full  text-xs text-right text-gray-900  dark:text-gray-400">
            <tr class="text-xs  divide-y divide-x divide-gray-900 dark:bg-gray-800 bg-gray-100 border border-gray-900">
                <th scope="col" class="py-1 px-3 border border-gray-900">   
                    <div>المادة</div>
                    <div>Matiere</div>
                </th>
                <th scope="col" class="py-1 px-3 text-center border border-gray-900"> 
                    <div> نتائج الاختبار</div>
                    <div>Note Devoirs</div>
                </th>
                <th scope="col" class="py-1 px-3 text-center">
                    <div> معدل الاختبار</div>
                    <div>Moy Devoirs</div>
                </th>
                <th scope="col" class="py-1 px-3 text-center">   
                    <div>    نتيجة الامتحانات </div>
                    <div>Note Compo</div>
                </th>

                @if (!$classmoy)  
                <th scope="col" class="py-1 px-3 text-center">
                    
                    <div> المعدل </div>
                    <div>Moyenne</div>
                </th>
                @endif


                <th scope="col" class="py-1 px-3 text-center">
                    @if (!$classmoy)
                        <div> الضارب </div>
                        <div>Coefficient</div>
                    @else
                        <div> المجموع </div>
                        <div>Total</div>
                    @endif
                </th>

                @if (!$classmoy)  
                <th scope="col" class="py-1 px-3 text-center">
                    <div> المجموع </div>
                    <div>Total</div>
                </th>
                @endif

            </tr>
        <tbody>
            @forelse ($results as $result)

                <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white  dark:bg-gray-800 ">
                    <th scope="row" class="py-1 px-3 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white  border border-gray-900">
                        {{   $result['nom']  }}
                    </th>
                    <td class="py-1 px-3  font-mono">
                        {{ $result['devn']  }}
                    </td>
                    <td class="py-1 px-3 text-center font-mono">

                        @if ($result['devm'])
                             {{  round($result['devm'], 2) }}
                        @endif
                        
                 
                    </td>
                    <td class="py-1 px-3 text-center font-mono">
                        {{ $result['examn']  }}
                    </td>
                    

                    @if (!$classmoy)
                    <td class="py-1 px-3 text-center font-mono">
                        {{ $result['moy']  }}
                    </td>
                    @endif

                    <td class="py-1 px-3 text-center font-mono">
                        {{ $result['foix']  }}
                    </td>
                @if (!$classmoy)
                    <td class="py-1 px-3 text-center font-mono">
                        {{ $result['tot']  }}
                        </td>
                @endif
                </tr>   

            @empty
            @endforelse

            @if($classmoy)
            <tr class="border border-gray-900 divide-y divide-x divide-gray-900 w-full even:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-900 bg-white border-b dark:bg-gray-800 print:border-gray-900 dark:border-gray-900">
                <th colspan="3" class="py-1 px-3 font-medium print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                     
                </th>

                
                <td class="py-1 px-3 text-center font-bold  font-mono">
                    {{ $moy  }}
                </td>
                <td class="py-1 px-3 text-center font-bold font-mono">
                    {{ $tots }}
                    </td>

            </tr>   
            @endif


        </tbody>
    </table>
    <div class="flex justify-between print:dark:text-gray-700 print:text-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
        <div class="py-1 px-3 font-bold">
            المعدل العام
        </div>

        @if($classmoy and $tots)
        <div  class="py-1 px-3 text-center font-bold text-lg">
            {{ '10' }} / {{ ($moy*10)/$tots }} 
        </div>
         @endif

         @if(!$classmoy and $moy)
        <div  class="py-1 px-3 text-center font-bold text-lg">
            {{ $tots }} / {{ $moy }} 
        </div>
         @endif



        <div class="py-1 px-3 font-bold ">
            Moyenne generale
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
