<?php
namespace App\Repositories\Enterprise;

use App\Repositories\Contracts\RepositoryInterface;

interface EnterpriseRepositoryInterface extends RepositoryInterface
{
    public function findBy($keyword,$address, $phone);
}