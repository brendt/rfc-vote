@php
    /**
     * @var array{id: int, name: string, url: string, contributions: string[]}[] $contributors
     */
@endphp

@component('layouts.base')

<x-about.section heading="Shaping PHP, together">
    <p>Thank you for checking out RFC Vote!</p>
    <p>This project is dedicated to providing a platform for the PHP community to express their thoughts and
        feelings about the proposals for the PHP language in an easier way.</p>

    <p>Our main goal is to visualize the diverse opinions and arguments surrounding PHP's proposed features,
        making it easier to understand the benefits and downsides of each proposal. By doing so, we hope to
        foster a greater understanding of how PHP developers feel about these changes.</p>

    <p>While official voting on RFCs is limited to internal qualified developers and a specific group of
        contributors, RFC Vote offers a space for everyone in the PHP community to share their voice. Your
        votes and comments won't directly influence the official PHP RFC outcomes, but they can serve as
        valuable insights for those involved in the decision-making process.</p>

    <p>In addition to casting a vote, you are encouraged to share your reasoning behind your choices on
        each RFC. By explaining why you voted yes or no, we can collectively gain better insights into
        the popularity or concerns associated with an RFC. This collaborative approach allows us to learn
        from one another and contributes to a more informed and connected PHP community.</p>

    <p>For official messages, please consider using the PHP Internals mailing list. Despite common belief,
        it is in fact, open to anyone.</p>

    <x-about.quote
        author="Nikita Popov"
        link="https://twitter.com/nikita_ppv"
        :image="asset('storage/nikita-popov.jpeg')"
    >
        I believe it is important to remember that voting is just the last step of
        the RFC process: While the vote is the final arbiter, the discussion phase
        that precedes it is where concerns are heard and the proposal is shaped.<br>
    </x-about.quote>
</x-about.section>


<x-about.section heading="Who's involved?">
    <p>Many people throughout the PHP community have already
        <x-about.link href="https://github.com/brendt/rfc-vote/graphs/contributors">contributed to this project</x-about.link>
        — and <x-about.link href="https://github.com/brendt/rfc-vote">you can too</x-about.link>!</p>

    <p>The initial idea came from <x-about.link href="https://twitter.com/pronskiy">Roman Pronskiy</x-about.link>,
        who helps administer the <x-about.link href="https://thephp.foundation/">PHP Foundation</x-about.link>,
        and is developed (together with many open source enthusiasts) by
        <x-about.link href="https://twitter.com/brendt_gd">Brent Roose</x-about.link>, developer advocate for PHP at
        <x-about.link href="https://www.jetbrains.com/phpstorm/">JetBrains</x-about.link>.</p>
</x-about.section>

<x-about.contributors :contributors="$contributors" />

<x-about.section heading="Interesting links">
    <p>
        <ul>
            <li>
                <x-about.link href="https://github.com/brendt/rfc-vote">
                    The RFC Vote repository
                </x-about.link>
                — everyone can contribute!
            </li>
            <li>
                <x-about.link href="https://www.youtube.com/playlist?list=PL0bgkxUS9EaLguM2puiMD-NiiV6r5b8RY">
                    The YouTube playlist
                </x-about.link>
                where we built this project on stream, together.
            </li>
        </ul>
    </p>
</x-about.section>

@endcomponent
