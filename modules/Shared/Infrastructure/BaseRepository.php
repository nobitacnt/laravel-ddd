<?php

namespace Modules\Shared\Infrastructure;

use Modules\Shared\Domain\IBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Shared\Domain\ValueObjects\Pagination;
use Modules\Shared\Infrastructure\EloquentModels\Model;

abstract class BaseRepository implements IBaseRepository
{
    protected Model $model;

    /** @var Builder */
    protected Builder $query;

    public function __construct()
    {
        $this->setModel();
        $this->query = $this->model->newQuery();
    }

    abstract public function getModel();

    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function existsByCond(array $cond): bool
    {
        return $this->query->where($cond)->exists();
    }

    public function exists(string $id): bool
    {
        return $this->existsByCond(['id' => $id]);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function update($id, $param): void
    {
        $this->updateWhere(['id', $id], $param);
    }

    public function updateWhere(array $cond, array $param): void
    {
        $this->model->where($cond)->update($param);
    }

    public function delete($id): void
    {
        $this->find($id)->delete();
    }

    public function create($param = [])
    {
        return $this->model->create($param);
    }

    /**
     * @param LengthAwarePaginator $result
     * @return Pagination
     */
    public function getPagination($result): Pagination
    {
        return new Pagination(
            $result->currentPage(),
            $result->lastPage(),
            $result->perPage(),
            $result->total(),
            $result->firstItem(),
            $result->lastItem()
        );
    }
}
