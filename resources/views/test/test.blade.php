<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enlarge Image on Hover</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <style>
        .enlarge-image {
            transition: transform 0.2s; /* Apply a smooth transition effect */
            max-width: 100%;
            max-height: 100%;
        }
        
        .enlarge-image:hover {
            transform: scale(5); /* Enlarge the image by 20% */
            cursor: pointer; /* Change the cursor to indicate interactivity */
        }


        .enlarge-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px; /* Set the desired height for the container */
        }

        
    </style>
</head>
<body>

<div class="container">
    <div class="row mt-lg-5">
      .
    </div>
    <div class="row mt-lg-5">
      .
    </div>
    <div class="row mt-lg-5">
        <div class="col-md-12 text-center">
            <img src="{{ asset('storage/profile-photos/M0AmuyQVVubYjGfbLlc5p169Nyfi8hGPuuOLbp8F.jpg') }}" alt="Image" width="100px" class="img-fluid enlarge-image">


        </div>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>