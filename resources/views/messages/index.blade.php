<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between items-center">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl leading-tight mr-12 mb-2">
                        {{ __('Messages') }}
                    </h2>
                    @if (!empty($selectedApplication))
                    <p class="my-4">{{ __('Application') }}: <strong>{{ $selectedApplication->name }}</strong></p>
                    @endif
                    @if (!empty($searchTerm))
                    <p class="mt-2">{{ __('Search Term') }}: <strong>{{ $searchTerm }}</strong></p>
                    @endif
                </div>
                <div class="w-1/8 relative">
                    <form id="search-form">
                        <input class="form-control bg-white bg-clip-padding border-2 border-blue-300 pl-4 pr-2 py-2 mr-3 my-2 rounded-lg focus:outline-none focus:bg-white focus:border-blue-300 focus:outline-none" type="search" id="term" name="term" placeholder="Search" value="{{ $searchTerm ?? '' }}">
                        <select name="appid"{''( id="application" class="appearance-none border-2 border-blue-300 rounded-lg my-2">
                            <option value="">{{ __('Application') }}</option>
                        @foreach ($applications as $application)
                            <option value="{{ $application->id }}" {{ ($selectedApplication && $selectedApplication->id === $application->id) ? 'selected' : '' }} >{{ $application->name }}</option>
                        @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-3 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 ml-4">Search</button>
                    </form>

                    <x-jet-button class="mt-4">
                        {{ __('Delete All Messages') }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                        </svg>
                    </x-jet-button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

            @if (!$messages->isEmpty())
                @foreach ($messages as $message)
                <div class="mt-3 bg-white shadow-xl sm:rounded-lg">
                    <div class="p-3 sm:px-10 border-l-4 border-solid border-{{ $message->level->color() }}-500">
                        <div class="text-gray-500 text-1xl">
                            <div class="flex flex-row flex-wrap">
                                <div class="w-full md:w-1/4">
                                    <p class="font-bold text-blue">{{ $message->application->name }}</p>
                                    <p>{{ $message->formattedCreationTime() }}</p>
                                    <p class="font-bold text-{{ $message->level->color() }}-500">{{ $message->level->name }}</p>
                                </div>
                                <div class="w-full md:w-1/2 mt-6 md:mt-0 flex items-center">
                                    <p class="md:pl-6">{{ $message->body }}</p>
                                </div>
                                <div class="w-full md:w-1/4 mt-6 md:mt-0 flex md:justify-end items-center">
                                    <livewire:delete-message :message="$message"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-5 d-flex">
                    {!! $messages->links() !!}
                </div>
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
