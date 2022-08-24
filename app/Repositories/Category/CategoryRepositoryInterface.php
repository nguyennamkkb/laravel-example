<?php
namespace App\Repositories\Category;

use App\Repositories\Contracts\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}