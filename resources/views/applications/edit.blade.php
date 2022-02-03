<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <div class="flex flex-row flex-wrap items-center">
                <div class=" w-1/2">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ __('Applications') }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="my-6">
                <div>
                    <h2 class="font-semi-bold text-lg mb-4">{{ __('Add Application')}}</h2>

                    @if ($errors->any() && $errors->getBag('default')->hasAny(['name', 'email']) )
                    <div class="bg-red-100 rounded-b text-red-900 px-4 py-3 mb-6 shadow-md" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
                            </div>
                            <div>
                                <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('applications.update', $application) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-rows-2 gap-6">
                            <div>
                                <x-label for="name" :value="__('Name')" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $application->name }}" required autofocus />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Save') }}
                                </x-button>

                                <x-button class="cancel-create-application-form ml-4">
                                    {{ __('Cancel') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
