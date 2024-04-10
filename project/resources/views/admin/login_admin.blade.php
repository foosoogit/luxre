<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
        <x-validation-errors class="mb-4" />
        <form method="POST" action="{{ route('admin.login.store') }}">@csrf
            <div>
                <x-label for="email" value="email:"/>
                <x-input type="text" id="email" name="email" required />
            </div>                            
            <div>
                <x-label for="password" value="{{ __('Password') }}"/>
                <x-input type="password" id="password" name="password" required class="block mt-1 w-full"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <div class="flex justify-end mt-4">
                    @error('failed')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                <x-button class="ms-4">ログイン</x-button>
            </div>
        </div>
        </form>
    </x-authentication-card>
</x-guest-layout>