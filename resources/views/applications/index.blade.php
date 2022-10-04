<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between items-center">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Applications') }}
                    </h2>
                </div>
                <div class="w-1/8">
                    <a href="{{ route('applications.create') }}" class="add-application-button inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                        {{ __('Add New ') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$applications->isEmpty())
                @foreach ($applications as $application)
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-10">
                        <div class="text-gray-500 text-1xl">
                            <div class="flex flex-row flex-wrap items-center">
                                <div class="w-full md:w-3/4">
                                    <h3 class="font-bold text-xl mb-3">
                                        {{ $application->name }}
                                    </h3>
                                    <p>
                                        <strong>Message Count:</strong>
                                        @if ($application->messages->isNotEmpty())
                                            <a href="/messages/application/{{ $application->id }}">
                                                {{ $application->messages->count() }}
                                            </a>
                                        @else
                                            {{ $application->messages->count() }}
                                        @endif
                                    </p>
                                    <p><strong>Last Updated:</strong> {{ $application->lastUpdated() }}</p>
                                </div>
                                <div class="w-1/4 flex mt-4 md:mt-0">
                                    <a href="{{ route('applications.edit', $application) }}" class="add-application-button inline-flex items-center mr-4 px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('applications.destroy', $application) }}" class="delete-application-form inline-flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" href="{{ route('applications.destroy', $application) }}" class="delete-application-button px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="max-w-7xl mx-auto my-6 sm:px-6 lg:px-8">
                <h3 class="font-semibold text-lg leading-tight">
                    {{ __('No Applications found. Click the Add New button to create one.') }}
                </h3>
            </div>
            @endif
        </div>
    </div>

    <div class="add-application-form hidden">
        <form method="POST" action="{{ route('applications.store') }}" class="mt-6">
            @csrf
            <div>
                <x-jet-label for="name" :value="__('Name')" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>
        </form>
    </div>

    <div class="edit-application-form hidden">
        <form method="POST" action="{{ route('applications.store') }}" class="mt-6">
            @csrf
            <div>
                <x-jet-label for="name" :value="__('Name')" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>
        </form>
    </div>
</x-app-layout>