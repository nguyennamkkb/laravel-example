<?php
namespace App\Repositories\Specificities;

use App\Repositories\Contracts\RepositoryInterface;

interface SpecificitiesRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}