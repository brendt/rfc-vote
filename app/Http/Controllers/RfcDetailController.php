<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use App\Models\User;
use App\Support\Meta;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class RfcDetailController
{
    public function __construct(private Meta $meta) {}

    public function __invoke(Rfc $rfc): View
    {
        $rfc->load([
            'arguments.user',
            'arguments.rfc',
            'arguments.comments.user',
        ]);

        $user = auth()->user();

        $this->meta
            ->title($rfc->title)
            ->description((string) $rfc->teaser)
            ->image(action(RfcMetaImageController::class, $rfc));

        //        if ($user) {
        //            // todo: review this block for performance issues
        //            $unviewedArguments = $rfc->arguments
        //                ->reject(fn (Argument $other) => $user->viewedArguments->contains($other->id));
        //
        //            $user->viewedArguments()->attach($unviewedArguments->pluck('id'));
        //        }

        return view('rfc', [
            'rfc' => $rfc,
            'user' => $user,
            'additionalRfcs' => $this->additionalRfcs($user, $rfc),
        ]);
    }

    /**
     * @return Collection<int, Rfc>
     */
    private function additionalRfcs(?User $user, Rfc $rfc): Collection
    {
        return Rfc::query()
            ->with(['arguments', 'yesArguments', 'noArguments'])
            ->where('published_at', '<=', now()->startOfDay())
            ->where(function (Builder $q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->where('id', '!=', $rfc->id)
            ->when(filled($user), function (Builder $builder) use ($user) {
                $builder->whereDoesntHave('arguments', function (Builder $q) use ($user) {
                    $q->where('user_id', $user?->id);
                });
            })
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }
}
