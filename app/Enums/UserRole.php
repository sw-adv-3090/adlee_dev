<?php

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case Sponsor = 2;
    case AdSpaceOwner = 3;
    case Designer = 4;
}
