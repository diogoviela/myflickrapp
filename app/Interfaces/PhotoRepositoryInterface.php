<?php

namespace App\Interfaces;

interface PhotoRepositoryInterface
{

    /**
     * @param array $photoDetails
     * @return void
     */
    public function savePhoto(array $photoDetails): void;

}
