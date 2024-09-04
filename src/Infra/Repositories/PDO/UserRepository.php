<?php

namespace Jhonattan\BaseProjectFromEcommerce\Infra\Repositories\PDO;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;
use Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Repositories\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): bool
    {
        return true;
    }

    public function findById(string $id): ?User
    {
        return null;
    }

    public function findAllUsers(): array
    {
        return [];
    }

    public function update(User $user): bool
    {
        return true;
    }

    public function delete(User $user): bool
    {
        return true;
    }
}
