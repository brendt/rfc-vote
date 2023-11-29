<x-buttons.main
    href="{{ action(App\Http\Controllers\SocialiteRedirectController::class, 'github') }}"
    class="!bg-gray-800 hover:!bg-gray-700 text-white"
>
    <x-icons.github class="h-6 w-6 fill-white dark:fill-gray-300" />
    Log in with GitHub
</x-buttons.main>