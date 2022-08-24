<?php
namespace App\Repositories\Code;

use App\Repositories\Contracts\RepositoryInterface;

interface CodeRepositoryInterface extends RepositoryInterface
{
    public function findBy($status, $keyword);
}