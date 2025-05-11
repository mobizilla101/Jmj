<?php

namespace App\Enum;

enum PaymentStatus:string
{
    CASE PROCESSING = 'processing';

    CASE PENDING = 'pending';
    CASE COMPLETED = 'completed';
    CASE CANCELED = 'canceled';
    CASE REJECTED = 'rejected';
}
