<?php

namespace App\Http\Controllers;

use App\Interfaces\PhotoRepositoryInterface;
use App\Models\Photo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    private PhotoRepositoryInterface $photoRepository;

    public function __construct(PhotoRepositoryInterface $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * On the first access, 10 photos are automatically presented and saved in the database.
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $apiKey  = 'f9cc014fa76b098f9e82f1c288379ea1';
        $perPage = 10;
        $url     = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=$apiKey&per_page=$perPage&tags=london&format=json&nojsoncallback=1";

        $response = json_decode(file_get_contents($url), true);

        if (isset($response['photos'])) {
            $photos = collect($response['photos']['photo'])->map(function ($photo) {
                return [
                    'id'        => $photo['id'],
                    'title'     => $photo['title'],
                    'thumbnail' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_q.jpg",
                    'image'     => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_c.jpg",
                ];
            });
            foreach ($photos as $photo) {
                $newPhoto            = new Photo;
                $newPhoto->image     = $photo['image'];
                $newPhoto->title     = $photo['title'];
                $newPhoto->thumbnail = $photo['thumbnail'];
                $newPhoto->save();
            }
        } else {
            $photos = collect([]);
        }


        $success = 'Images have been saved successfully.';
        return view('images', compact('photos', 'success'));
    }

    /**
     * Size filter is applied to the search for images in the api,
     * later allowing them to be recorded manually using the function saveImages()
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function getImagesWithSizes(Request $request): Application|Factory|View
    {
        $apiKey  = 'f9cc014fa76b098f9e82f1c288379ea1';
        $tag     = 'kitten';
        $perPage = 10;
        $sizes   = 's,q,t,m,z,c,b';

        $extras = $request->input('extras');
        if ($extras) {
            $sizes = $extras;
        }

        $url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=$apiKey&tags=$tag&per_page=$perPage&extras=$sizes&format=json&nojsoncallback=1";

        $response = json_decode(file_get_contents($url), true);

        if (isset($response['photos'])) {
            $photos = collect($response['photos']['photo'])->map(function ($photo) use ($sizes) {
                return [
                    'id'        => $photo['id'],
                    'title'     => $photo['title'],
                    'thumbnail' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_t.jpg",
                    'image'     => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_$sizes.jpg",
                ];
            });
        } else {
            $photos = collect([]);
        }

        return view('images', compact('photos'));
    }

    /**
     * This function allows you to saved images manually in the database,
     * all 10 images presented will be saved
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function saveImages(Request $request): RedirectResponse
    {
        $photoDetails = $request->validate([
            'image'     => 'required',
            'title'     => 'nullable',
            'thumbnail' => 'required',
        ]);

        return redirect($this->photoRepository->savePhoto($photoDetails))->back()->with('success', 'Images have been saved successfully.');
    }
}
