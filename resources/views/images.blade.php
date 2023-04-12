<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Images - from FlickrAPI</title>
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

        .success-message {
            color: green;
            background-color: #e6ffe6;
            border: 1px solid #66ff66;
            padding: 10px;
            margin: 10px 0;
            animation: fadeOut 5s forwards;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 10px;
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 10px;
        }

        .grid-item {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            font-size: 30px;
        }

        select {
            font-size: 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f2f2f2;
            color: #333;
            cursor: pointer;
        }

        select:hover {
            background-color: #e6e6e6;
        }

        select:focus {
            outline: none;
            box-shadow: 0 0 5px #b3d9ff;
        }

        .select-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            cursor: pointer;
        }

        /* Hover state */
        .select-button:hover {
            border-color: #6c757d;
        }

        /* Focus state */
        .select-button:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            border-color: #6c757d;
        }

        /* Active state */
        .select-button:active {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            color: #212529;
        }

        .hidden-button {
            display: none;
        }
    </style>
</head>
<body>
<div class="btn-container">
    <form action="{{ route('images') }}" method="get">
        <label for="extras"></label>
        <select name="extras" id="extras">
            <option>Select Size</option>
            <option value="s">Square</option>
            <option value="q">Large Square</option>
            <option value="t">Thumbnail</option>
            <option value="m">Medium</option>
            <option value="z">Medium 640</option>
            <option value="c">Medium 800</option>
            <option value="b">Large</option>
        </select>
        <button type="submit" class="hidden-button"></button>
        <script>
            document.getElementById("extras").addEventListener("change", function () {
                this.form.submit();
            });
        </script>
    </form>
    <hr/>
    <form action="{{ route('save-images') }}" method="post">
        @csrf
        @foreach($photos as $photo)
            <input type="hidden" id="image" name="image[]" value="{{ $photo['image'] }}">
            <input type="hidden" id="title" name="title[]" value="{{ $photo['title'] }}">
            <input type="hidden" id="thumbnail" name="thumbnail[]" value="{{ $photo['thumbnail'] }}">
        @endforeach
        <button type="submit" class="select-button">Save Images</button>
    </form>
</div>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="error-message">{{ session('error') }}</div>
@endif

<div class="image-container">
    <div class="grid-container">
        @foreach($photos as $photo)
            <div class="grid-item"><img src="{{ $photo['image'] }}" alt="{{ $photo['title'] }}"></div>
        @endforeach
    </div>
</div>
</body>
</html>
