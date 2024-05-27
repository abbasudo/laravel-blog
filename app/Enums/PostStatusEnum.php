<?php

namespace App\Enums;

enum PostStatusEnum: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Published = 'published';
}
