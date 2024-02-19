<?php

namespace App\DTO;

class FaqDTO
{
    public string $title;

    public string $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
}
