<?php
namespace App\Repositories\Supplier;

use App\Repositories\Contracts\RepositoryInterface;

interface SupplierRepositoryInterface extends RepositoryInterface
{
    public function findBy($status, $keyword);
}