<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flickr Images</title>
    <style>
        .image-container {
            margin-bottom: 20px;
        }

        .image-container img {
            display: block;
            margin-bottom: 10px;
        }

        .btn-container {
            margin-bottom: 20px;
        }

        .btn {
            margin-right: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="btn-container">
    <form action="{{ route('flickr-images') }}" method="get">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
            <option value="url_sq,url_t,url_s,url_m,url_l,url_o">Default</option>
            <option value="url_sq">Small Square</option>
            <option value="url_t">Thumbnail</option>
            <option value="url_s">Small</option>
            <option value="url_m">Medium</option>
            <option value="url_l">Large</option>
            <option value="url_o">Original</option>
        </select>
        <button type="submit" class="btn">Sort</button>
    </form>
    <form action="{{ route('flickr-save') }}" method="post">
        @csrf
        <input type="hidden" name="images" value="{{ json_encode($photos) }}">
        <button type="submit" class="btn">Save Images</button>
    </form>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="error">{{ session('error') }}</div>
@endif

<div class="image-container">
    @foreach($photos as $photo)
        <div>
            <img src="{{ $photo['url'] }}" alt="{{ $photo['title'] }}">
            <div>Size: {{ $photo['size'] }}</div>
        </div>
    @endforeach
</div>
</body>
</html>
