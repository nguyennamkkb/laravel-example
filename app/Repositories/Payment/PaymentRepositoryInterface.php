<?php
namespace App\Repositories\Payment;

use App\Repositories\Contracts\RepositoryInterface;

interface PaymentRepositoryInterface extends RepositoryInterface
{
    public function findBy($customer,$dateFrom,$datoTo, $status);
}