<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove "No file chosen" Box</title>
    <!-- Include Bootstrap CSS (you can replace the link with your specific version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/css/bootstrap.min.css">
    <style>
        /* Hide the "No file chosen" box */
        .custom-file-label::after {
            content: none; /* Hide the content after the input field */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form>
            <div class="mb-3">
                <label for="customFile" class="form-label">Choose file</label>
                <input type="file" class="form-control custom-file-input" id="customFile" hidden>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
