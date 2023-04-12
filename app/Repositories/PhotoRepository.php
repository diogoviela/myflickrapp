<?php

namespace App\Repositories;

use App\Interfaces\PhotoRepositoryInterface;
use App\Models\Photo;

class PhotoRepository implements PhotoRepositoryInterface
{

    public function savePhoto(array $photoDetails): void
    {

        foreach($photoDetails['image'] as $key => $image) {
            $newImage = new Photo;
            $newImage->image = $image;
            $newImage->title = $photoDetails['title'][$key];
            $newImage->thumbnail = $photoDetails['thumbnail'][$key];
            $newImage->save();
        }

    }

}
