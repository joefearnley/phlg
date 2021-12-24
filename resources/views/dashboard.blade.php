<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Latest Messages
                </div>
            </div>
        </div>
    </div>

    @foreach ($messages as $message)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white">
                <p><strong>Application:</strong> {{ $message->application->name }}</p>
                <p><strong>Level:</strong> {{ $message->level->name }}</p>
                <p><strong>Message:</strong> {{ $message->body }}</p>
                <p><strong>Message:</strong> {{ $message->created_at }}</p>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
