<?php
namespace App\Repositories\Customer;

use App\Repositories\Contracts\RepositoryInterface;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    public function findBy($customerType_id,$keyword,$address, $phone);
}