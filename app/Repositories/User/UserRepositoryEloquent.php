<?php

namespace App\Repositories\User;

use App\Repositories\Eloquent\RepositoryEloquent;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use App\Http\Resources\UserResource;


class UserRepositoryEloquent extends RepositoryEloquent implements UserRepositoryInterface
{
    public function model()
    {
        return User::class;
    }

    public function findBy($keyword)
    {
        $query = $this->model->newQuery();

        if (!empty($keyword)) {
            $query = $this->model->where('name', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%");
        }

        return $query;
    }
}
