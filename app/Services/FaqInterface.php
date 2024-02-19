<?php

namespace App\Services;

use App\DTO\FaqDTO;
use Illuminate\Database\Eloquent\Collection;

interface FaqInterface
{
    public function all(): Collection;

    public function create_update(FaqDTO $data);

    public  function deleteThroughId(int $id);
}
