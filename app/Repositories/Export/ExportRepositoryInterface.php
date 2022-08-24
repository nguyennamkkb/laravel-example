<?php
namespace App\Repositories\Export;

use App\Repositories\Contracts\RepositoryInterface;

interface ExportRepositoryInterface extends RepositoryInterface
{
    public function findBy($dateFrom, $dateTo,$category_id,$status);
    public function getinput();
}