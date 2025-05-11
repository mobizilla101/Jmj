<?php

namespace App\Enum;

enum OrderStatus:string
{
    CASE PROCESSING = 'processing';
    CASE COMPLETED = 'completed';
    CASE CANCELED = 'canceled';
    CASE REJECTED = 'rejected';

}
