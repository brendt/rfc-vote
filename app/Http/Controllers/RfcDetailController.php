<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\Rfc;
use App\Support\Meta;

final readonly class RfcDetailController
{
    public function __construct(private Meta $meta)
    {
    }

    public function __invoke(Rfc $rfc)
    {
        $rfc->load([
            'arguments.user',
            'arguments.rfc',
        ]);

        $user = auth()->user();

        $user?->load([
            'arguments',
            'argumentVotes.argument',
            'viewedArguments',
        ]);

        $this->meta
            ->title($rfc->title)
            ->description($rfc->teaser)
            ->image(action(\App\Http\Controllers\RfcMetaImageController::class, $rfc));

        if ($user) {
            $unviewedArguments = $rfc->arguments
                ->reject(fn (Argument $other) => $user->viewedArguments->contains($other->id));

            $user->viewedArguments()->attach(
                $unviewedArguments->pluck('id')
            );
        }

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
        ]);
    }
}
