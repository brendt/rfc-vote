@component('layouts.base')

<div>
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

        <blockquote>... voting is just the last step of the RFC process:
            While the vote is the final arbiter, the discussion phase that precedes it
            is where concerns are heard and the proposal is shaped.<br>

            <div class="text-right">
                <a href="https://externals.io/message/110936#110937">Nikita Popov</a>
            </div>
        </blockquote>
    </x-about.section>


    <x-about.section heading="Who's involved?">
        <p>Many people throughout the PHP community have already
            <a href="https://github.com/brendt/rfc-vote/graphs/contributors">contributed to this project</a>
            — and <a href="https://github.com/brendt/rfc-vote">you can too</a>!
        </p>

        <p>The initial idea came from <a href="https://twitter.com/pronskiy">Roman Pronskiy</a>,
            who helps administer the <a href="https://thephp.foundation/">PHP Foundation</a>,
            and is developed (together with many open source enthusiasts) by
            <a href="https://twitter.com/brendt_gd">Brent Roose</a>, developer advocate for PHP at
            <a href="https://www.jetbrains.com/phpstorm/">JetBrains</a>.</p>
    </x-about.section>

    <x-about.section heading="Thanks to all our contributors:">
        <ul>
            @foreach($contributors as $contributor)
                <li>
                    <a href="{{ $contributor->url }}">{{ $contributor->name }}</a>:
                    <a href="{{ $contributor->contributionsUrl }}">{{ implode(', ', $contributor->contributions) }}</a>
                </li>
            @endforeach
        </ul>

        <h2>Interesting links</h2>

        <ul>
            <li>
                <a href="https://github.com/brendt/rfc-vote">
                    The RFC Vote repository
                </a>
                — everyone can contribute!
            </li>
            <li>
                <a href="https://www.youtube.com/playlist?list=PL0bgkxUS9EaLguM2puiMD-NiiV6r5b8RY">
                    The YouTube playlist
                </a>
                where we built this project on stream, together.
            </li>
        </ul>
    </x-about.section>
</div>

@endcomponent
