<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\DTO\CommentDTO;
use Illuminate\Database\Eloquent\Model;
interface CommentRepositoryInterface
{
    public function all(): Collection;

    public function create(CommentDTO $dto);

    public function update(CommentDTO $dto, Model $faq);

    public function findId(int $id);

    public function delete(Model $model);

    public  function limit(int $int): self;

    public  function get(): Collection;
}
