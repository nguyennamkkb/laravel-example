<?php
namespace App\Repositories\ExportDetail;

use App\Repositories\Contracts\RepositoryInterface;

interface ExportDetailRepositoryInterface extends RepositoryInterface
{
    public function findBy($keyword);
}