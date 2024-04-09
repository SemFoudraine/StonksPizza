<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" style="margin-top: 75px;">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Voor- en Achternaam')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Telefoonnummer -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Telefoonnummer')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required
                autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Woonplaats -->
        <div class="mt-4">
            <x-input-label for="woonplaats" :value="__('Woonplaats')" />
            <x-text-input id="woonplaats" class="block mt-1 w-full" type="text" name="woonplaats" :value="old('woonplaats')"
                required autofocus autocomplete="woonplaats" />
            <x-input-error :messages="$errors->get('woonplaats')" class="mt-2" />
        </div>

        <!-- Postcode -->
        <div class="mt-4">
            <x-input-label for="postcode" :value="__('Postcode')" />
            <x-text-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" :value="old('postcode')"
                required autofocus autocomplete="postcode" />
            <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
        </div>

        <!-- Adres -->
        <div class="mt-4">
            <x-input-label for="adres" :value="__('Adres + Huisnummer')" />
            <x-text-input id="adres" class="block mt-1 w-full" type="text" name="adres" :value="old('adres')"
                required autofocus autocomplete="adres" />
            <x-input-error :messages="$errors->get('adres')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Wachtwoord')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Bevestig Wachtwoord')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                href="{{ route('login') }}">
                {{ __('Al geregistreed?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registreer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
