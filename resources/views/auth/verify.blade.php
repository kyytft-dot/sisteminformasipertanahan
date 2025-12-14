<x-guest-layout>
    <form method="POST" action="{{ url('/verify') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="code" :value="__('Kode Verifikasi')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
            <p class="text-sm text-gray-500 mt-1">Masukkan kode verifikasi yang Anda terima melalui email.</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">{{ __('Kembali ke Login') }}</a>
            <x-primary-button class="ms-4">{{ __('Verifikasi') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>
