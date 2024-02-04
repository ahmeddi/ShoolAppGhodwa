<div>
    <div class="">
        {{-- <div class="flex justify-between w-full  items-center">
            <select wire:change='monthly' wire:model='month'  class="inputs w-40 "   required >
                @foreach ($months as $month)
                    <option  class="text-sm" value="{{$month->value}}">{{$month->label()}}</option>
                @endforeach
            </select>
        </div> --}}
    </div> 
    <div class="my-4">
        <div class=" flex gap-x-2">
            <div
                class="block rounded-lg bg-white p-4 shadow-md dark:bg-gray-900">
                    <h5
                    class="mb-1 text-lg font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                    <span>عدد الطلاب الدافعين</span>
                    </h5>
                    <p class="mb-1 text-xl font-semibold text-neutral-600 dark:text-neutral-200">
                        {{ $payedEtuds }} / {{ $etudCount }}
                    </p>
            </div>

            <div
                class="block rounded-lg bg-white p-4 shadow-md dark:bg-gray-900">
                    <h5
                    class="mb-1 text-lg font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                    <span>عدد الطلاب المدينين</span>
                    </h5>
                    <p class="mb-1 text-xl text-neutral-600 dark:text-neutral-200">
                        {{ $unpayedEtuds }} / {{ $etudCount }}
                    </p>
            </div>

            <div
                class="block rounded-lg bg-white p-4 shadow-md dark:bg-gray-900">
                    <h5
                        class="mb-1 text-lg font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                        <span>اجمالي المدفوع  </span>
                    </h5>
                    <p class="mb-1 text-xl text-neutral-600 dark:text-neutral-200">
                        {{ $payedAmount }} / {{ $unpayedAmount }}  
                    </p>
            </div>
        </div>
   </div>
    
    

    
</div>



</div>
