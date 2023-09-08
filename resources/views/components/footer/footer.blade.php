<div class="pt-14 pb-9 text-white bg-main-dark bg-gradient-to-r from-main to-main-dark relative">
    {{-- Decoration that creates a nice effect on top of the footer --}}
    <div class="absolute bg-main-light dark:bg-gray-800 h-4 inset-x-0 -top-1 rounded-b-[50%]"></div>

    <div class="flex justify-center gap-8">
        <x-footer.link href="/feed" icon="icons.rss">
            RSS Feed
        </x-footer.link>

        <x-footer.link href="https://github.com/brendt/rfc-vote" icon="icons.github">
            Contribute
        </x-footer.link>

        <x-footer.link href="https://youtube.com/playlist?list=PL0bgkxUS9EaLguM2puiMD-NiiV6r5b8RY&si=IJHdypNSFGh5X-KJ" icon="icons.youtube">
            Watch on YouTube
        </x-footer.link>

        <x-footer.link href="https://raw.githubusercontent.com/brendt/rfc-vote/main/LICENSE.md" icon="icons.document">
            Our License
        </x-footer.link>
    </div>

    <div class="text-center opacity-70 mt-5">
        <small>
            &copy; {{ date('Y') }} {{ config('app.name') }}. This project is open source.
            <a href="https://github.com/brendt/rfc-vote" class="underline" target="_blank">Contribute</a>
            and collaborate with us!</p>
        </small>
    </div>
</div>
