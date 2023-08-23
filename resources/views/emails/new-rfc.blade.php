@php
    /**
     * @var App\Models\User $user
     * @var App\Models\Rfc $rfc
     */
@endphp

@component('mail::layout')
@slot('header')
    @component('mail::header')
    @endcomponent
@endslot

<h1>New RFC is out!</h1>
<p>Hi <b>{{ $user->name }}</b>! There's a new RFC in town <b>"{{ $rfc->title }}"</b>! Check it out, vote, and share your arguments!</p>

@component('mail::button', ['url' => action(App\Http\Controllers\RfcDetailController::class, $rfc)])
    Go to the RFC
@endcomponent

<p>If you're having trouble clicking the button, copy and paste the URL into your web browser:</p>

<a href="{{ action(App\Http\Controllers\RfcDetailController::class, $rfc) }}">
    {{ action(App\Http\Controllers\RfcDetailController::class, $rfc) }}
</a>

@slot('footer')
    @component('mail::footer')
    @endcomponent
@endslot

@endcomponent
