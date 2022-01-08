<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap items-center">
                <div class=" w-1/2">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Applications') }}
                    </h2>
                </div>
                <div class="w-1/2 text-right">
                    <a href="/applications/create" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                        {{ __('Add New ') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
