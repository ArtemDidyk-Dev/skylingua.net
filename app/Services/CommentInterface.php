<?php

namespace App\Services;

use App\DTO\CommentDTO;
use Illuminate\Database\Eloquent\Collection;

interface CommentInterface
{
    public function all(): Collection;

    public function create_update(CommentDTO $data);

    public  function deleteThroughId(int $id);
}
