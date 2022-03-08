<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between items-center">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl leading-tight mr-12">
                        {{ __('Messages') }}
                    </h2>
                    @if (!empty($selectedApplication))
                    <p class="mt-2">{{ __('Application') }}: <strong>{{ $selectedApplication->name }}</strong></p>
                    @endif
                    @if (!empty($searchTerm))
                    <p class="">{{ __('Search Term') }}: <strong>{{ $searchTerm }}</strong></p>
                    @endif
                </div>
                <div class="w-1/8 relative">
                    <form id="search-form">
                        <input class="form-control bg-white bg-clip-padding border-2 border-blue-300 pl-4 pr-2 py-2 mr-3 rounded-lg focus:outline-none focus:bg-white focus:border-blue-300 focus:outline-none" type="search" id="search-term" name="search" placeholder="Search" value="{{ $searchTerm ?? '' }}">
                        <select name="appid"{''( id="application" class="appearance-none border-2 border-blue-300 rounded-lg">
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

    <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

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
