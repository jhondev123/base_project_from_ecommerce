<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\Factories\UseCases\User\RegisterUser;

use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Repositories\UserRepository;

class RegisterUserUseCase
{
    public function __construct(private UserRepository $userRepository) {}
    public function execute(RegisterUserDTO $dto): bool
    {
        return $this->userRepository->save($dto->toEntity());
    }
}
