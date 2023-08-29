<?php

namespace App\Http\ViewComposers;

use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Illuminate\View\View;

class AdminViewComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();

        if (! $user?->is_admin) {
            return;
        }

        $view->with(
            'pendingVerificationRequests',
            VerificationRequest::query()->where('status', VerificationRequestStatus::PENDING)->count()
        );
    }
}
