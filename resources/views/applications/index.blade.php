<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between items-center">
                <div class=" w-1/2">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Applications') }}
                    </h2>
                </div>
                <div class="w-1/8">
                    <button type="button" class="add-application-button inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                        {{ __('Add New ') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

    @if (!$applications->isEmpty())
        @foreach ($applications as $application)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-3 border-b">
                <div class="flex flex-row flex-wrap">
                    <div class="w-full">
                        <h3 class="font-bold text-xl mb-3">
                            {{ $application->name }}
                            <a href="/applications/{{ $application->id}}/edit/" class="inline-flex items-center px-2 py-2 text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </a>
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

    <div class="add-application-form hidden">
        <form method="POST" action="{{ route('applications.store') }}" class="mt-6">
            @csrf
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>
        </form>
    </div>

    <div class="edit-application-form hidden">
        <form method="POST" action="{{ route('applications.store') }}" class="mt-6">
            @csrf
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>
        </form>
    </div>
</x-app-layout>
