<?php

namespace App\Contracts;

interface MediaServiceInterface
{
    public function uploadMedia(array $files, $mediable, bool $deleteExisting = false): void;
}
