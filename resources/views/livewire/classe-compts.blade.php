<div>
    <div class="w-full overflow-x-auto   print:block lg:block md:block">
        <table class=" w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900 dark:text-gray-200">
            <tr>
                <th scope="col" class="py-3 px-6">
                   
                </th>
                @forelse ($Months as $number => $Month )
                <th scope="col" class="py-3 px-6">
                    {{ $Month }}
                </th>
                @empty
                @endforelse
            </tr>
            </thead>
            <tbody>
                @foreach ($etuds as $etud)
                    <tr class="text-center  dark:bg-gray-800 dark:text-gray-100">
                        @foreach ($Months as $number => $Month)
                            @if ($loop->first)
                                <td class="border print:border-gray-900 dark:bg-gray-800 dark:border-gray-600 border-gray-300 bg-gray-100 text-gray-800 p-1   ">
                                    <div class="top  w-full">
                                        <a wire:navigate.hover href="{{ url(app()->getLocale().'/Etudiant'.'/'.$etud->id) }}" class="hover:underline text-gray-500 dark:text-gray-300 font-medium print:text-gray-900 dark:print:text-gray-900">
                                            {{ $etud->nom }}
                                        </a>
                                    </div>
                                </td>
                            @endif   
                            <td class="bg-white border dark:bg-gray-800 dark:border-gray-600 print:border-gray-900 p-1 relative ">  
                                <div class=" w-full h-full flex justify-center items-center   my-1 font-bold text-sm print:text-xs text-red-600 dark:text-red-400 print:text-gray-900 dark:print:text-gray-900">
                                    @php
                                      $array =   $etud->fraisMonthStatus($number);
                                    @endphp
                                    @if ($array['status'] == 1)
                                        <svg class="text-green-600 dark:text-green-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    @elseif ($array['status'] == 4)
                                        <span class="text-green-600 dark:text-green-400">
                                            {{ $array['paiement'] }}
                                        </span>
                                    @elseif ($array['status'] == 2)
                                        <span class="text-red-600 dark:text-red-400">
                                            {{ $array['frais'] }}
                                        </span>
                                    @elseif ($array['status'] == 3)
                                        <svg class="text-red-600 dark:text-red-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    @endif
                                
                                    

                                      
                                      
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            

            </tbody>
        </table>
    
    </div>
</div>
