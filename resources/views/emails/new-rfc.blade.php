<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} - Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6;">
<h1 style="font-size: 24px; font-weight: bold;"></h1>

<x-markdown>
Hi {{ $user->name }}!

There's a new RFC in town: [{{ $rfc->title }}]({{ action(\App\Http\Controllers\RfcDetailController::class, $rfc) }}).

Check it out, vote, and share your arguments!

Thanks,<br>{{ config('app.name') }}
</x-markdown>
</body>
</html>
