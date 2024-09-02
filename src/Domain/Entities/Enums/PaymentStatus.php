<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums;

enum PaymentStatus :string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

}
