<?php

namespace Jhonattan\BaseProjectFromEcommerce\Application\UseCases\User\RegisterUser;

use InvalidArgumentException;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;
use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Repositories\UserRepository;
use Jhonattan\BaseProjectFromEcommerce\Application\UseCases\Encripter\EncryptPasswordUseCase;
use Jhonattan\BaseProjectFromEcommerce\Application\UseCases\GenerateUuid\GeneratorUuidUseCase;

class RegisterUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private GeneratorUuidUseCase $generetorUiid,
        private EncryptPasswordUseCase $encryptPassword
    ) {}
    public function execute(RegisterUserDTO $dto): User
    {
        $this->validate($dto);
        $dto->setId($this->generetorUiid->execute());
        $dto->setPassword($this->encryptPassword->execute($dto->password));
        $savedUser =  $this->userRepository->save($dto->toEntity());
        return $savedUser;
    }
    private function validate(RegisterUserDTO $dto): void
    {
        // Implementar validação aqui
        if (empty($dto->name) || empty($dto->email) || empty($dto->password)) {
            throw new InvalidArgumentException('Invalid user data');
        }
    }
}
