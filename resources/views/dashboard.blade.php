<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Latest Messages') }}
            </h2>
        </div>
    </x-slot>

    @foreach ($messages as $message)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 p-3 border-l-4 border-solid border-{{ $message->level->color() }}-600">
            <div class="flex flex-row flex-wrap">
                <div class="w-full md:w-1/3">
                    <p><strong>{{ $message->application->name }}</strong></p>
                    <p>{{ $message->level->name }}</p>
                    <p>{{ $message->formattedCreationDate() }}</p>
                </div>
                <div class="w-full md:w-2/3 mt-6 md:mt-0">
                    <p>{{ $message->body }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
