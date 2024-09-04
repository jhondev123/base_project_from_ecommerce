<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Repositories;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;

interface UserRepository
{
    public function save(User $user):bool;
    public function findById(string $id):?User;
    public function findAllUsers():array;
    public function update(User $user):bool;
    public function delete(User $user):bool;
    

  
}
