<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\Rfc;
use App\Support\Meta;
use Illuminate\Database\Eloquent\Builder;

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

        $additionalRfcs = Rfc::query()
            ->where('published_at', '<=', now()->startOfDay())
            ->where(fn (Builder $builder) => $builder->whereNull('ends_at')->orWhere('ends_at', '>', now()))
            ->when(filled($user), fn (Builder $builder) => $builder->whereDoesntHave('arguments', fn (Builder $builder) => $builder->where('user_id', $user->id)))
            ->inRandomOrder()
            ->with(['arguments', 'yesArguments', 'noArguments'])
            ->limit(3)
            ->get();

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
            'additionalRfcs' => $additionalRfcs,
        ]);
    }
}
