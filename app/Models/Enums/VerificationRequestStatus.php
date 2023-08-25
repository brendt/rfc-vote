<?php

namespace App\Models\Enums;

enum VerificationRequestStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DENIED = 'denied';
}
