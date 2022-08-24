<?php
namespace App\Repositories\Unit;

use App\Repositories\Contracts\RepositoryInterface;

interface UnitRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}