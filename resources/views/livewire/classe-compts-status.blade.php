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
        <div class=" border border-gray-200 dark:border-gray-700 shadow grid grid-cols-1 divide-x-0 lg:divide-x divide-y lg:divide-y-0  md:divide-x md:divide-y  divide-gray-200 dark:divide-gray-500 rtl:divide-x-reverse sm:grid-cols-2 lg:grid-cols-3 rounded-md overflow-hidden">
            <x-My.simple-card :label="__('compt.payed')" :montant="$payedEtuds.' / '.$etudCount" :exp="'no'" :border="1" :url="'#'" />
            <x-My.simple-card :label="__('compt.unpayed')" :montant="$unpayedEtuds.' / '.$etudCount" :exp="'no'" :border="1" :url="'#'" />
            <x-My.simple-card :label="__('compt.alls')" :montant="$payedAmount.' / '.$unpayedAmount" :exp="'no'" :border="0" :url="'#'" />
        </div>
   </div>
    
    

    
</div>



</div>
