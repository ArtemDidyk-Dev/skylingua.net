<?php

namespace App\Services;

use App\DTO\FaqDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class FaqRepository implements  FaqRepositoryInterface
{
    public Model|Builder  $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return  $this->model->all();
    }

    public function create(FaqDTO $dto)
    {
      return $this->model->create(
            [
                'title' => $dto->title,
                'content' => $dto->content
            ]
        );
    }

    public function update(FaqDTO $dto, Model $faq): Model
    {
        $faq->update([
            'title' => $dto->title,
            'content' => $dto->content
        ]);
        return $faq;
    }

    public function findId(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(Model $model): ?bool
    {
       return $model->delete();
    }

    public function limit(int|null $int): FaqRepositoryInterface
    {
        $this->model = $this->model->limit($int);
        return  $this;
    }

    public function get(): Collection
    {
        $query = $this->model;
        return $query->get();
    }


}
