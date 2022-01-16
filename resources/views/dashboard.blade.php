<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Latest Messages') }}
            </h2>
        </div>
    </x-slot>

    @if (!$messages->isEmpty())
        @foreach ($messages as $message)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-3 border-l-4 border-solid border-{{ $message->level->color() }}-600">
                <div class="flex flex-row flex-wrap">
                    <div class="w-full md:w-1/4">
                        <p class="font-bold text-blue">{{ $message->application->name }}</p>
                        <p>{{ $message->formattedCreationTime() }}</p>
                        <p class="font-bold text-{{ $message->level->color() }}-600">{{ $message->level->name }}</p>
                    </div>
                    <div class="w-full md:w-3/4 mt-6 md:mt-0">
                        <p>{{ $message->body }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="max-w-7xl mx-auto my-6 sm:px-6 lg:px-8">
            <h3 class="font-semibold text-lg leading-tight">
                {{ __('No Messages Yet!') }}
            </h3>
        </div>
    @endif
</x-app-layout>
