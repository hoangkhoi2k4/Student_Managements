<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll($size);
    public function getAllNotPaginate();
    public function create(array $data);
    public function findOrFail($id);
    public function find($id);
    public function update(array $data, $id);
    public function delete($id);
}
