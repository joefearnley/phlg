<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Applications') }}
            </h2>
        </div>
    </x-slot>

    @foreach ($applications as $application)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 p-3 border-b">
            <div class="flex flex-row flex-wrap">
                <div class="w-full md:w-3/4">
                    <h3 class="font-bold text-xl mb-3">{{ $application->name }}</h3>
                    <p><strong>Message Count:</strong> {{ $application->messages->count() }}</p>
                    <p><strong>Last Updated:</strong> {{ $application->lastUpdated() }}</p>
                </div>
                <div class="w-full md:w-1/4">
                    <a href="/applications/{{ $application->id}}/edit/">
                    {{ __('Edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
