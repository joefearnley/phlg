<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap justify-left items-center">

                <h2 class="font-semibold text-xl leading-tight mr-12">
                    {{ __('Messages') }}
                </h2>

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-blue focus:outline-none focus:text-blue focus:border-blue">
                            <div>{{ __('Application') }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($applications as $application)
                        <x-dropdown-link :href="route('messages.index', $application)">
                            {{ $application->name }}
                        </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>

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
