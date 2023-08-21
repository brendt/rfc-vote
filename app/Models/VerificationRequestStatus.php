<?php

namespace App\Models;

enum VerificationRequestStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DENIED = 'denied';
}
