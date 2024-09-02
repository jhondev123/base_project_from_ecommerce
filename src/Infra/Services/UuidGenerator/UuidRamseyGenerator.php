<?php

namespace Jhonattan\BaseProjectFromEcommerce\Infra\Services\UuidGenerator;

use Ramsey\Uuid\Uuid;
use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\UuidGenerator;

class UuidRamseyGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }

}
