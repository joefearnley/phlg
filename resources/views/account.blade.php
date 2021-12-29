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
                <h2 class="font-semi-bold text-l mb-4">Update Account Information</h2>
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

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
                <form method="POST" action="{{ route('account.update') }}">
                    @csrf
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
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
