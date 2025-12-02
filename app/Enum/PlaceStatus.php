<?php

namespace App\Enum;

enum PlaceStatus: string
{
    case Pending    = 'pending';
    case Processing = 'processing';
    case Done       = 'done';
    case Error      = 'error';
}
