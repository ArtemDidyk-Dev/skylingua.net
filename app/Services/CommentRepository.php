<?php

namespace App\Services;

use App\DTO\CommentDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class CommentRepository implements  CommentRepositoryInterface
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

    public function create(CommentDTO $dto)
    {

      $this->model->create(
            [
                'name' => $dto->name,
                'descrip' => $dto->descrip,
                'content' => $dto->content,
                'image' => $dto->image->name ?? null
            ]
        );

    }

    public function update(CommentDTO $dto, Model $faq): Model
    {

        $faq->update([
            'name' => $dto->name,
            'descrip' => $dto->descrip,
            'content' => $dto->content,
        ]);
        if($dto->image) {
            $faq->update(['image' => $dto->image->name]);
        }
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

    public function limit(int|null $int): CommentRepositoryInterface
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
