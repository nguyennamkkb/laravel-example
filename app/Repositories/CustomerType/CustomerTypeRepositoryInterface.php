<?php
namespace App\Repositories\CustomerType;

use App\Repositories\Contracts\RepositoryInterface;

interface CustomerTypeRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}