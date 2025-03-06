<?php

namespace App\Enums;

enum BookletPrintStatus: string
{
    case CREATED = 'created';
    case SEND = 'send';
    case DISPATCHED = 'dispatched';
}
