<x-app-layout>
    <x-slot name="header">
        <div class="my-3 max-w-7xl mx-auto">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Account') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 py-3 grid md:grid-cols-2 gap-16">
            <div>
                <h2 class="font-semi-bold text-l mb-4">{{ __('Update Account Information') }}</h2>

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

                <form method="POST" action="{{ route('account.update') }}">
                    @csrf
                    <div class="grid grid-rows-2 gap-6">
                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ auth()->user()->name }}" required autofocus />
                        </div>
                        <div>
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ auth()->user()->email }}" required />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update Information') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>

            <div>
                <h2 class="font-semi-bold text-l mb-4">{{ __('Update Password') }}</h2>
                @if ($errors->any() && $errors->getBag('default')->hasAny(['new_password', 'new_password_confirmation']))
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

                <form method="POST" action="{{ route('account.update-password') }}">
                    @csrf

                    <div class="grid grid-rows-2 gap-6">
                        <div>
                            <x-label for="password" :value="__('New Password')" />
                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="new_password"
                                            autocomplete="new-password" />
                        </div>
                        <div>
                            <x-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="new_password_confirmation" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update Password') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="my-6 py-3 grid md:grid-cols-2 gap-16">
            <div>
                <h2 class="font-semi-bold text-l mb-4">{{ __('Create Access Token') }}</h2>
                @if(session('access_token'))
                <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>
                <div class="token-results py-2 px-4 my-3 border border-blue rounded-md flex items-center justify-start">
                    <div class="mr-2">
                        {{ session('access_token') }}
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                @endif
                <form method="POST" action="{{ route('account.create-token') }}">
                    @csrf
                    <div class="grid grid-rows-2 gap-6">
                        <div class="flex items-center justify-start mt-2">
                            <x-button>
                                {{ __('Generate New Token') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
