<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $apiKey = 'f9cc014fa76b098f9e82f1c288379ea1';
        $perPage = 10;
        $url = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=$apiKey&per_page=$perPage&tags=london&format=json&nojsoncallback=1";

        $response = json_decode(file_get_contents($url), true);

        if (isset($response['photos'])) {
            $photos = collect($response['photos']['photo'])->map(function ($photo) {
                return [
                    'id' => $photo['id'],
                    'title' => $photo['title'],
                    'thumbnail' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_q.jpg",
                    'image' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_c.jpg",
                ];
            });
        } else {
            $photos = collect([]);
        }

        return view('images', compact('photos'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function getFlickrImagesWithSizes(Request $request): Application|Factory|View
    {
        $apiKey = 'f9cc014fa76b098f9e82f1c288379ea1';
        $tag = 'kitten';
        $perPage = 10;
        $sizes = 's,q,t,m,z,c,b';

        $extras = $request->input('extras');
        if ($extras) {
            $sizes = $extras;
        }

        $url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=$apiKey&tags=$tag&per_page=$perPage&extras=$sizes&format=json&nojsoncallback=1";

        $response = json_decode(file_get_contents($url), true);

        if (isset($response['photos'])) {
            $photos = collect($response['photos']['photo'])->map(function ($photo) use ($sizes) {
                return [
                    'id' => $photo['id'],
                    'title' => $photo['title'],
                    'thumbnail' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_t.jpg",
                    'image' => "https://farm{$photo['farm']}.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_$sizes.jpg",
                ];
            });
        } else {
            $photos = collect([]);
        }

        return view('images', compact('photos'));
    }

    public function saveImages(Request $request)
    {
        $photos = $request->input('photo');

        foreach ($photos as $photo) {
            Image::create([
                'title' => $photo['title'],
                'url' => $photo['url'],
                'thumbnail_url' => $photo['thumbnail_url'],
            ]);
        }

        return redirect()->route('flickr-images')->with('success', 'Images saved successfully.');
    }


}
