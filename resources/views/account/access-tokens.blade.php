<x-app-layout>
<x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Account') }}
            </h2>
        </div>
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="space-x-8 sm:-my-px md:flex">
                    <x-nav-link :href="route('account')" :active="request()->routeIs('account')">
                        {{ __('Account Information') }}
                    </x-nav-link>
                    <x-nav-link :href="route('account.access-tokens')" :active="request()->routeIs('account.access-tokens')">
                        {{ __('Access Tokens') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </x-slot>

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
                <form method="POST" action="{{ route('account.create-access-token') }}">
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
            <div>
                <h2 class="font-semi-bold text-l mb-4">{{ __('Previous Issued Tokens') }}</h2>
                <ul>
                @foreach ($accessTokens as $accessToken) 
                <li>{{ $accessToken->name }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
