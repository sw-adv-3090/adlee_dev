<?php

namespace App\Enums;

enum PaymentIntentStatus: string
{
    case Succeeded = 'succeeded';
    case Canceled = 'canceled';
    case RequiresAction = 'requires_action';
    case RequiresCapture = 'requires_capture';
    case RequiresConfirmation = 'requires_confirmation';
    case RequiresPaymentMethod = 'requires_payment_method';
}
