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
                                <div class="w-full md:w-3/4 mt-6 md:mt-0 flex items-center">
                                    <p class="md:pl-6">{{ $message->body }}</p>
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
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-gray-500 text-1xl">
                            {{ __('No Messages Yet!') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
