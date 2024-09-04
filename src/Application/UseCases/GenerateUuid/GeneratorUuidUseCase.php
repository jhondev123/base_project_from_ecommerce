<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\UseCases\GenerateUuid;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\UuidGenerator;

class GeneratorUuidUseCase
{
    public function __construct(private UuidGenerator $uuidGenerator) {}
    public function execute(): string
    {
        return $this->uuidGenerator->generate();
    }
}
