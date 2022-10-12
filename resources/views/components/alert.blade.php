@if ($message)

<div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{{ json_encode(['show' => true]) }}" x-show="show">
    <div class="my-3 py-3 gap-16">
        @if($type === 'success')
        <div class="bg-emerald-100 rounded-b text-emerald-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="py-1 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Success!</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>
                <button class="py-1" x-on:click="show = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if($type === 'error')
        <div class="bg-red-100 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="py-1 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Error!</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>
                <button class="py-1" x-on:click="show = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
