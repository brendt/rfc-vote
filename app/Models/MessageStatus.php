<?php

namespace App\Models;

enum MessageStatus: string
{
    case UNREAD = 'unread';
    case READ = 'read';
    case ARCHIVED = 'archived';
}
