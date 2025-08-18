<?php

namespace App\DTO;

class CommentDTO
{
    public string $name;
    public string|null $descrip;
    public string $content;
    public object|null $image;

    public function __construct(string $name, string|null $descrip = null, string $content, object|null $image = null)
    {

        $this->name = $name;
        $this->descrip = $descrip;
        $this->content = $content;
        $this->image = $image;
    }
}
