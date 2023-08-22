@php
    /**
     * @var string $verificationLink
     */
@endphp

@component('mail::layout')
@slot('header')
@component('mail::header')
@endcomponent
@endslot

<h1>Verify your Email</h1>
<p>You have requested to change your email address. Please click the button below to verify your new email:</p>

@component('mail::button', ['url' => $verificationLink, 'color' => 'purple'])
Verify email
@endcomponent

<p>If you're having trouble clicking the button, copy and paste the URL into your web browser:</p>
<a href="{{ $verificationLink }}">{{ $verificationLink }}</a>

@component('mail::subcopy')
<p>If you did not make this request, you can safely ignore this email.</p>
@endcomponent

@slot('footer')
@component('mail::footer')
@endcomponent
@endslot

@endcomponent
