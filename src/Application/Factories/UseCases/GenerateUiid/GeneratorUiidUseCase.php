<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\Factories\UseCases\GenerateUiid;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\UuidGenerator;

class GeneratorUiidUseCase
{
    public function __construct(private UuidGenerator $uuidGenerator) {}
    public function execute(): string
    {
        return $this->uuidGenerator->generate();
    }
}
