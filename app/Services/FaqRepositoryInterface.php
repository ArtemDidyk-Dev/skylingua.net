<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\DTO\FaqDTO;
use Illuminate\Database\Eloquent\Model;
interface FaqRepositoryInterface
{
    public function all(): Collection;

    public function create(FaqDTO $dto);

    public function update(FaqDTO $dto, Model $faq);

    public function findId(int $id);

    public function delete(Model $model);

    public  function limit(int $int): self;

    public  function get(): Collection;
}
