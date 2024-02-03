<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ $Classs->nom }}
        </h2>
    </x-slot>

    <div class="py-2 ">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col gap-y-2 overflow-hidden sm:rounded-lg">
                <div>
                    @livewire('classe-compts-status', ['Classs' => $Classs])
               </div> 
                <div>
                     @livewire('classe-compts', ['Classs' => $Classs])
                </div> 

            </div>
        </div>
    </div>
</x-app-layout>