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
                    <div x-data="{ open: false }">

                        <button x-on:click="open = true" type="button" class="inline-flex items-center px-4 py-2 bg-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25">
                            {{ __('Add New ') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-on:keydown.escape.prevent.stop="open = false"
                            role="dialog"
                            aria-modal="true"
                            x-id="['modal-title']"
                            :aria-labelledby="$id('modal-title')"
                            class="fixed inset-0 overflow-y-auto"
                        >

                            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

                            <div
                                x-show="open" x-transition
                                x-on:click="open = false"
                                class="relative min-h-screen flex items-center justify-center p-4"
                            >
                                <div
                                    x-on:click.stop
                                    x-trap.noscroll.inert="open"
                                    class="relative max-w-2xl w-full bg-white p-8 overflow-y-auto"
                                >
                                    <h2 class="text-xl font-medium border-b" :id="$id('modal-title')">
                                        {{  __('Add Application') }}
                                    </h2>
                                    <form method="POST" action="{{ route('applications.store') }}" class="mt-6">
                                        @csrf

                                        <div>
                                            <x-label for="name" :value="__('Name')" />
                                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                                        </div>

                                        <div class="mt-8 flex space-x-2">
                                            <x-button class="ml-4">
                                                {{ __('Save') }}
                                            </x-button>

                                            <x-button x-on:click="open = false"   class="ml-4">
                                                {{ __('Cancel') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
</x-app-layout>
