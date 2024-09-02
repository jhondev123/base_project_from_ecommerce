<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case REFUSED = 'refused';
    case CONFIRMED = 'confirmed';
    case INDELIVERY = 'in_delivery';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
