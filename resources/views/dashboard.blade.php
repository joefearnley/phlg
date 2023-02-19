<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 bg-white overflow-hidden sm:rounded-lg">
                <div class="p-2 sm:px-10 bg-white border-b border-gray-200">
                    <div class="mt-1 text-lg font-medium">
                        {{ __('Latest Messages') }}
                    </div>
                </div>
            </div>

            @if (!$messages->isEmpty())
                @foreach ($messages as $message)
                <div class="mt-3 bg-white sm:rounded-lg">
                    <div class="p-2 px-10 border-l-4 border-solid border-{{ $message->level->color() }}-500">
                        <div class="text-gray-500 text-1xl">
                            <div class="flex flex-row flex-wrap">
                                <div class="w-full md:w-1/4">
                                    <p class="font-bold text-blue">{{ $message->application->name }}</p>
                                    <p>{{ $message->formattedCreationTime() }}</p>
                                    <p class="font-bold text-{{ $message->level->color() }}-500">{{ $message->level->name }}</p>
                                </div>
                                <div class="w-full md:w-3/4 mt-6 md:mt-0 flex items-center">
                                    <p class="md:pl-6">{{ $message->body }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="mt-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-10 bg-white border-b border-gray-200">
                        <div class="text-gray-500 text-1xl">
                            {{ __('No Messages Yet!') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
