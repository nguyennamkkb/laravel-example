<?php
namespace App\Repositories\InputDetail;

use App\Repositories\Contracts\RepositoryInterface;

interface InputDetailRepositoryInterface extends RepositoryInterface
{
    public function findBy($keyword); 
    public function findByInputId($id); 
}