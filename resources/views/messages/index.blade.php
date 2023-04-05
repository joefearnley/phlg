<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl leading-tight mr-12 mb-2">
                        {{ __('Messages') }}
                    </h2>
                </div>
                <div class="w-1/8 relative">
                    <form id="search-form">
                        <input class="form-control block md:inline-block mt-2 md:mt-0 bg-white bg-clip-padding text-sm border-2 border-blue-300 px-4 py-2 mr-3 rounded-lg focus:outline-none focus:bg-white focus:border-blue-300 focus:outline-none" type="search" id="term" name="term" placeholder="Search" value="{{ $searchTerm ?? '' }}">
                        <select name="appid" id="application" class="block md:inline-block mt-2 md:mt-0 appearance-none border-2 border-blue-300 rounded-lg text-sm">
                            <option value="">{{ __('Application') }}</option>
                        @foreach ($applications as $application)
                            <option value="{{ $application->id }}" {{ ($selectedApplication && $selectedApplication->id === $application->id) ? 'selected' : '' }} >{{ $application->name }}</option>
                        @endforeach
                        </select>
                        <button type="submit" class="block md:ml-4 mt-2 md:mt-0 md:inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

            <div class="mt-3 bg-white sm:rounded-lg">
                <div class="my-2 py-3 px-3 sm:px-10 flex flex-col md:flex-row md:items-center justify-between">
                    @if (!empty($selectedApplication))
                    <div class="my-1 md:mx-0">
                        <a href="{{ route('applications.index') }}">{{ __('Applications') }}</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline stroke-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        <strong>{{ $selectedApplication->name }}</strong>
                    </div>
                    @endif
                    @if (!empty($searchTerm))
                    <div class="my-1 md:mx-0">{{ __('Results for') }} <strong>&quot;{{ $searchTerm }}&quot;</strong></div>
                    @endif
                    @if (!$messages->isEmpty())
                    <div class="my-1 md:mx-0">
                        <livewire:delete-messages />
                    </div>
                    @endif
                </div>
            </div>

            @if (!$messages->isEmpty())
                @foreach ($messages as $message)
                <div class="mt-3 bg-white sm:rounded-lg">
                    <div class="border-l-4 border-solid border-{{ $message->level->color() }}-400">
                        <div class="text-gray-500 text-1xl">
                            <div class="py-3 px-3 sm:px-10 flex flex-row flex-wrap">
                                <div class="w-full md:w-1/4">
                                    <p class="font-bold text-blue">{{ $message->application->name }}</p>
                                    <p>{{ $message->formattedCreationTime() }}</p>
                                    <p class="font-bold text-{{ $message->level->color() }}-400">{{ $message->level->name }}</p>
                                </div>
                                <div class="w-full md:w-3/4 mt-6 md:mt-0 flex items-center">
                                    <p class="md:pl-6">{{ $message->body }}</p>
                                </div>
                            </div>
                            <div class="py-1 px-3 sm:px-10 w-full mt-6 md:mt-0 border border-l-0 border-r-0 border-b-0">
                                <livewire:delete-message :message="$message"/>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-5 d-flex">
                    {!! $messages->links() !!}
                </div>
            @else
                <div class="mt-3 bg-white overflow-hidden sm:rounded-lg">
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
