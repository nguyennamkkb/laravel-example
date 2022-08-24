<?php
namespace App\Repositories\EmployeeType;

use App\Repositories\Contracts\RepositoryInterface;

interface EmployeeTypeRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}