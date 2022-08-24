<?php
namespace App\Repositories\CategoryChild;

use App\Repositories\Contracts\RepositoryInterface;

interface CategoryChildRepositoryInterface extends RepositoryInterface
{
    public function findBy( $categoryid,$keyword);
    public function findByCategoryid( $categoryid);
}