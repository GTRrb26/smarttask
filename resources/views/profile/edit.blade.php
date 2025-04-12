<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('auth.profile.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('auth.profile.name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('auth.profile.email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="current_password" :value="__('auth.profile.current_password')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                        </div>

                        <div>
                            <x-input-label for="new_password" :value="__('auth.profile.new_password')" />
                            <x-text-input id="new_password" name="new_password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('new_password')" />
                        </div>

                        <div>
                            <x-input-label for="new_password_confirmation" :value="__('auth.profile.confirm_password')" />
                            <x-text-input id="new_password_confirmation" name="new_password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('new_password_confirmation')" />
                        </div>

                        <div>
                            <x-input-label for="theme" :value="__('auth.profile.theme')" />
                            <select id="theme" name="theme" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="light" {{ $user->theme === 'light' ? 'selected' : '' }}>{{ __('auth.theme.light') }}</option>
                                <option value="dark" {{ $user->theme === 'dark' ? 'selected' : '' }}>{{ __('auth.theme.dark') }}</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('theme')" />
                        </div>

                        <div>
                            <x-input-label for="locale" :value="__('auth.profile.language')" />
                            <select id="locale" name="locale" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="en" {{ $user->locale === 'en' ? 'selected' : '' }}>{{ __('auth.language.en') }}</option>
                                <option value="hi" {{ $user->locale === 'hi' ? 'selected' : '' }}>{{ __('auth.language.hi') }}</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('locale')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('auth.profile.save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 