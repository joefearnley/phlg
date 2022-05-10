<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('account')" :active="request()->routeIs('account')">
                        {{ __('Account') }}
                    </x-nav-link>
                    <x-nav-link :href="route('account.access-tokens')" :active="request()->routeIs('account.access-tokens')">
                        {{ __('Access Tokens') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </x-slot>

    <x-alert :type="session('message_type') ?? ''" :message="session('message') ?? ''"/>

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
</x-app-layout>
