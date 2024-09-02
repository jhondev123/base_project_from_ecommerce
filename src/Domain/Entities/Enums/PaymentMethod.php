<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Enums;

enum PaymentMethod:string
{
    case CREDIT_CARD = 'CREDIT_CARD';
    case DEBIT_CARD = 'DEBIT_CARD';
    case PIX = 'PIX';
    case MONEY = 'MONEY';


}
