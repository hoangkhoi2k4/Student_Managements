<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }
    public function show($id)
    {
        return $this->model->with('student')->findOrFail($id);
    }
}
