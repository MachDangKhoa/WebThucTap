<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Edit Painting Dataset</h1>

        <form action="{{ route('painting.update', $painting->id_db) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="painting_title">Title</label>
                <input type="text" class="form-control" id="painting_title" name="painting_title" value="{{ old('painting_title', $painting->painting_title) }}" required>
            </div>

            <div class="form-group">
                <label for="artist_db">Artist</label>
                <input type="text" class="form-control" id="artist_db" name="artist_db" value="{{ old('artist_db', $painting->artist_db) }}" required>
            </div>

            <div class="form-group">
                <label for="style_db">Style</label>
                <input type="text" class="form-control" id="style_db" name="style_db" value="{{ old('style_db', $painting->style_db) }}" required>
            </div>

            <div class="form-group">
                <label for="photographer">Photographer</label>
                <input type="text" class="form-control" id="photographer" name="photographer" value="{{ old('photographer', $painting->photographer) }}" required>
            </div>

            <div class="form-group">
                <label for="similarity">Similarity</label>
                <input type="text" class="form-control" id="similarity" name="similarity" value="{{ old('similarity', $painting->similarity) }}" disabled>
                <small class="form-text text-muted">This field cannot be edited.</small>
            </div>

            <div class="form-group">
                <label for="matched_file">Matched File</label>
                <input type="text" class="form-control" id="matched_file" name="matched_file" value="{{ old('matched_file', $painting->matched_file) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $painting->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="img_url_db">Image</label>
                <input type="file" class="form-control" id="img_url_db" name="img_url_db">
                <small class="form-text text-muted">You can upload a new image file if you wish to update the painting's image.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Painting</button>
        </form>

    </div>
    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</body>
</html>