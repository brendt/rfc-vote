<?php

namespace App\Http\Livewire;

use App\Actions\AcceptVerificationRequest;
use App\Actions\DenyVerificationRequest;
use App\Models\UserFlair;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class VerificationRequestsList extends Component
{
    /** @var Collection<int, VerificationRequest> */
    public Collection $pendingRequests;

    public ?VerificationRequest $isAccepting = null;

    public ?VerificationRequest $isDenying = null;

    public ?string $flair = null;

    public function mount(): void
    {
        $this->refresh();
    }

    public function render(): View
    {
        return view('livewire.verification-requests-list');
    }

    public function accept(VerificationRequest $request): void
    {
        if (! $this->isAccepting) {
            $this->isAccepting = $request;

            return;
        }

        if (! $this->isAccepting->is($request)) {
            $this->isAccepting = $request;

            return;
        }

        $this->validate([
            'flair' => ['required', 'string'],
        ]);

        app(AcceptVerificationRequest::class)(
            $request,
            UserFlair::from($this->flair)
        );

        $this->refresh();
    }

    public function deny(VerificationRequest $request): void
    {
        if (! $this->isDenying) {
            $this->isDenying = $request;

            return;
        }

        if (! $this->isDenying->is($request)) {
            $this->isDenying = $request;

            return;
        }

        app(DenyVerificationRequest::class)($request);

        $this->refresh();
    }

    public function cancelAccept(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->isAccepting = null;
        $this->isDenying = null;
        $this->flair = UserFlair::ADMIN->value;

        $this->pendingRequests = VerificationRequest::query()
            ->where('status', VerificationRequestStatus::PENDING)
            ->with(['user'])
            ->get();
    }
}
