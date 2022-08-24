<?php
namespace App\Repositories\Employee;

use App\Repositories\Contracts\RepositoryInterface;

interface EmployeeRepositoryInterface extends RepositoryInterface
{
    public function findBy($employeeType_id,$keyword,$address, $phone);
}