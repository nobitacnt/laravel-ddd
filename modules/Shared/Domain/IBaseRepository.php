<?php

namespace Modules\Shared\Domain;
use  Modules\Shared\Domain\ValueObjects\Pagination;

interface IBaseRepository
{
    public function tableName();

    public function getQuery();

    public function existsByCond(array $cond);

    public function exists(string $id);

    public function all();

    public function find($id);

    public function create($param = []);

    public function update($id, $param);

    public function updateWhere(array $cond, array $param);

    public function delete($id);

    public function getPagination(mixed $result): Pagination;
}
