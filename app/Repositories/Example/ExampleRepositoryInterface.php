<?php
namespace App\Repositories\Example;

use App\Repositories\Contracts\RepositoryInterface;

interface ExampleRepositoryInterface extends RepositoryInterface
{
    public function findBy( $keyword);
}