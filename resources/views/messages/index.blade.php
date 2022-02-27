<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-between items-center">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl leading-tight mr-12">
                    @if (empty($selectedApplication))
                        {{ __('All Messages') }}
                    @else
                        {{ __('Messages for') }} <strong>{{ $selectedApplication->name }}</strong>
                    @endif
                    </h2>
                </div>
                <div class="w-1/8 relative">
                    <form id="search-form">
                        <input class="border-2 border-blue-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" id="search-term" name="search" placeholder="Search">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="w-1/8">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="filter-application-button inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                                <div>{{ __('Application') }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach ($applications as $application)
                            <x-dropdown-link :href="route('messages.index', ['appid' => $application->id])">
                                {{ $application->name }}
                            </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
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
