<?php

namespace App\Enums;

enum UserType: string
{
    case SPONSOR = 'sponsor';
    case AdSpaceOwner = 'ad-space-owner';
    case Designer = 'designer';
}
