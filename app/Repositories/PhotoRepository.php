<?php

namespace App\Repositories;

use App\Interfaces\PhotoRepositoryInterface;
use App\Models\Photo;

class PhotoRepository implements PhotoRepositoryInterface
{

    /**
     * @param array $photoDetails
     *
     * @return void
     */
    public function savePhoto(array $photoDetails): void
    {
        foreach ($photoDetails['image'] as $key => $image) {
            $newPhoto            = new Photo;
            $newPhoto->image     = $image;
            $newPhoto->title     = $photoDetails['title'][$key];
            $newPhoto->thumbnail = $photoDetails['thumbnail'][$key];
            $newPhoto->save();
        }
    }

}
