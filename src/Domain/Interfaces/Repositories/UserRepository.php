<?php

namespace Jhonattan\BaseProjectFromEcommerce\Domain\Interfaces\Repositories;

use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\User;

interface UserRepository
{
    public function save(User $user):User;
    public function findById(string $id):?User;
    public function findAllUsers():array;
    public function update(User $user):User;
    public function delete(User $user):bool;
    

  
}
