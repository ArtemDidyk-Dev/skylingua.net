<?php

namespace App\Services;

interface SaveFile {
    public function save($file): object|null;
}
