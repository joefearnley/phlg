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
                    <a href="{{ route('applications.create') }}" class="add-application-button inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                        {{ __('Add New ') }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="pt-3 pb-12">
        <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                    <a href="{{ route('applications.edit', $application) }}" class="add-application-button flex items-center mr-4 px-3 bg-blue border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                                        {{ __('Edit') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-1">
                                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                        </svg>
                                    </a>

                                    <livewire:delete-application :application="$application"/>
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
                        {{ __('No Applications found. Click the Add New button to create one.') }}
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>
