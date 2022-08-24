<?php
namespace App\Repositories\Price;

use App\Repositories\Contracts\RepositoryInterface;

interface PriceRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}