<?php

namespace App\Http\Livewire;

use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Illuminate\Support\Collection;
use Livewire\Component;

class VerificationRequestsList extends Component
{
    /** @var \Illuminate\Support\Collection<\App\Models\VerificationRequest> */
    public Collection $pendingRequests;

    public ?VerificationRequest $isAccepting = null;

    public ?VerificationRequest $isDenying = null;

    public ?string $flair = null;

    public ?string $flairColor = null;

    public function mount(): void
    {
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.verification-requests-list');
    }

    public function accept(VerificationRequest $request): void
    {
        if (! $this->isAccepting) {
            $this->isAccepting = $request;

            return;
        }

        $this->validate([
            'flair' => ['required', 'string'],
            'flairColor' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
        ]);

        $request->update([
            'status' => VerificationRequestStatus::ACCEPTED,
        ]);

        $request->user->update([
            'flair' => $this->flair,
            'flair_color' => $this->flairColor,
        ]);

        $this->refresh();
    }

    public function deny(VerificationRequest $request): void
    {
        if (! $this->isDenying) {
            $this->isDenying = $request;

            return;
        }

        $request->update([
            'status' => VerificationRequestStatus::DENIED,
        ]);

        $this->refresh();
    }

    public function refresh(): void
    {
        $this->isAccepting = null;
        $this->isDenying = null;
        $this->flair = null;
        $this->flairColor = null;

        $this->pendingRequests = VerificationRequest::query()
            ->where('status', VerificationRequestStatus::PENDING)
            ->with(['user'])
            ->get();
    }
}
