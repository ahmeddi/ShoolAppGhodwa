<div>
  <x-dialog-modal wire:model='visible' >
      <x-slot name='title'>
          <div class='relative w-full px-12 text-lg font-bold text-green-900 dark:text-gray-50 '>
            <div>
                {{-- @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach --}}

                
             </div> 
             <button wire:click="close" class="absolute top-0 rtl:left-2 ltr:right-2 z-20 flex items-center justify-center w-8 h-8 text-green-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 dark:text-gray-50">
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                     </svg>
             </button>
          </div>
        </x-slot>

       <x-slot name='content'>
          <div  x-data="{
            paiements: @entangle('paiements'),
        
            addPaiement() {
                this.paiements.push({ etudiant_id: null, month: null, montant: null });
            },
        
            removePaiement(index) {
                this.paiements.splice(index, 1);
            },
        
            getComputedTotal() {
                const total = this.paiements.reduce((total, paiement) => {
                    const numericValue = parseFloat(paiement.montant);
                    return !isNaN(numericValue) ? total + numericValue : total;
                }, 0);
        
                return total;
            }
        }"
             class="flex flex-col space-y-8 ">
    
              {{-- 4 top rows --}}
              <div x-data="{ total: 0 }" class="grid lg:grid-cols-2 gap-x-6 gap-y-3 px-12  justify-items-center">

                    <div class=" w-full flex flex-col space-y-2">
                      <div class="flex justify-between ">
                          <label   class="labels">{{ __('compt.datr') }} :</label>
                          @error('date') <span class="danger">{{ $message }}</span> @enderror  
                      </div>
                      <input wire:model='date' class="inputs @error('date') reds @enderror" type="date"   required  />    
                    </div>

                    <div class=" w-full flex flex-col space-y-2">
                      <div class="flex justify-between w-full ">
                          <label   class="labels">{{ __('compt.mont') }} :</label>
                          @error('paiements.*') <span class="danger">{{ __('parent.error') }}</span> @enderror  
                      </div>
                      <input dir="ltr" :value="getComputedTotal()"  disabled   class="inputs w-full  @error('paiements.*') reds @enderror " type="text" x-mask:dynamic="$money($input, '.', ' ')"   required  /> 
                    </div> 

                    <div class="flex flex-col space-y-1 col-span-2 w-full">
                      @empty(!$paiements)
                          <div class="flex space-x-60 w-full">
                              <div class="flex justify-between">
                                  <label class="labels opacity-0">Prix:</label>
                              </div>
                              
                          </div>
                            
                      @endempty
                          
                      <div class="flex flex-col  gap-1  w-full">

                               {{-- @foreach ($paiements as $index => $paiement)
                                <div class="flex gap-1 w-full">
                                    <select wire:model="paiements.{{$index}}.etudiant_id" name="paiements.{{$index}}.etudiant_id" class="inputs w-56 @error('type') reds @enderror"  >
                                        <option class="text-sm">-----</option>
                                        @foreach ($etuds as $item)
                                            <option  class="text-sm" value="{{ $item->id }}">{{ $item->nom }}</option>
                                        @endforeach
                                    </select> 
                                    <select wire:model="paiements.{{$index}}.month" name="Months.{{$index}}.month" class="inputs w-56 @error('type') reds @enderror"  >
                                      <option class="text-sm">-----</option>
                                      @foreach ($Months as $month)
                                          <option  class="text-sm" value="{{ $month['id'] }}">{{ $month['nom'] }}</option>
                                      @endforeach
                                  </select> 
                                    <input 
                                    wire:change="totals" 
                                    wire:model="paiements.{{$index}}.montant" 
                                    @change="calculateTotal()"  class="inputs w-24 @error('rdate') reds @enderror" type="text"   />    
                                    @if ($loop->first)
                                    <button class="text-green-600  dark:text-green-400" wire:click="add()">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                      </svg>                                
                                    </button>
                                    @else
                                    <button class="text-red-600  dark:text-red-400" wire:click="remove({{$index}})">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                      </svg>                                  
                                  </button>
                                    @endif
                                    
                                </div>
                              @endforeach   --}}

                               <div  >
                                <template class="flex flex-col  gap-1  w-full" x-for="(paiement, index) in paiements" :key="index">

                                  <div class="flex gap-1 w-full my-1">
                                    <select  x-model="paiement.etudiant_id"  class="inputs w-56  @error('paiement.etudiant_id') reds @enderror  "  >
                                        <option value="0" class="text-sm">-----</option>
                                        @foreach ($etuds as $item)
                                            <option  class="text-sm" value="{{ $item->id }}">{{ $item->nom }}</option>
                                        @endforeach
                                    </select> 
                                    <select x-model="paiement.month"  class="inputs w-56 "  >
                                      <option value="0" class="text-sm">-----</option>
                                      @foreach ($Months as $month)
                                          <option  class="text-sm" value="{{ $month['id'] }}">{{ $month['nom'] }}</option>
                                      @endforeach
                                    </select> 
                                    <input 
                                    {{-- wire:change="totals"  --}}
                                    x-model="paiement.montant"
                                    class="inputs w-24 @error('rdate') reds @enderror" type="text"   />    
                                    
                                    <button x-show="index == 0" class="text-green-600  dark:text-green-400" @click="addPaiement">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                      </svg>                                                                       
                                    </button>
                                    
                                    <button x-show="index != 0" class="text-red-600  dark:text-red-400" @click="removePaiement(index)">
                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                      </svg>                                  
                                  </button>
                                    
                                    
                                </div>
                                </template>

                              </div> 
                      </div>

                  </div> 
                  
{{-- 
                    <div class="flex flex-col space-y-1 col-span-2 w-full ">
                      <div class="flex justify-between">
                        <label for="note"  class="labels"> {{ __('compt.note') }}:</label>
                        @error('note') <span class="danger ">{{ $message }}</span> @enderror  
                      </div>
                      <textarea wire:model='note' class="textearea h-10 w-full @error('note') reds @enderror" type="text" required  ></textarea>
                    </div> --}}
                                      
              </div>

          </div>  
       </x-slot>

       <x-slot name='footer' >

          <div wire:loading class="mx-8">
              <div role="status ">
                  <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-teal-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
          <div wire:loading.remove class="flex justify-between">
           <div class='px-12'>
             
           </div>
           <div class='px-10  flex space-x-3 justify-end items-center w-full'>

            <button  wire:click="close" type="button" class="w-full inline-flex justify-center rounded-md  shadow-sm px-4 py-2 focus:outline-none bg-white border-teal-600 border hover:bg-gray-50 text-teal-700 dark:text-gray-200 dark:border-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 sm:ml-3 sm:w-auto sm:text-sm">
              {{ __('etudiants.add-cancel') }} 
            </button>
            <button wire:click='save'  type="button" class="mt-3 w-full inline-flex justify-center rounded-md border dark:border-gray-500 shadow-sm px-4 py-2 focus:outline-none bg-teal-600 hover:bg-teal-800 text-white dark:text-gray-900 dark:bg-gray-100 dark:hover:bg-gray-200 font-bold sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                  {{ __('etudiants.add-save') }} 
            </button>
          </div>
         
          </div>
       </x-slot>
</x-dialog-modal>

</div>

