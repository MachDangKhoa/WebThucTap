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
        <h1>Edit Painting</h1>

        <form action="{{ route('painting_gg.update', $painting->id_gg) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title_gg">Title</label>
                <input type="text" class="form-control" id="title_gg" name="title_gg" value="{{ old('title_gg', $painting->title_gg) }}" required>
            </div>

            <div class="form-group">
                <label for="artist_gg">Artist</label>
                <input type="text" class="form-control" id="artist_gg" name="artist_gg" value="{{ old('artist_gg', $painting->artist_gg) }}" required>
            </div>

            <div class="form-group">
                <label for="style_gg">Style</label>
                <input type="text" class="form-control" id="style_gg" name="style_gg" value="{{ old('style_gg', $painting->style_gg) }}" required>
            </div>

            <div class="form-group">
                <label for="genre_gg">Genre</label>
                <input type="text" class="form-control" id="genre_gg" name="genre_gg" value="{{ old('genre_gg', $painting->genre_gg) }}" required>
            </div>

            <div class="form-group">
                <label for="year_gg">Year</label>
                <input type="text" class="form-control" id="year_gg" name="year_gg" value="{{ old('year_gg', $painting->year_gg) }}" disabled>
                <small class="form-text text-muted">This field cannot be edited.</small>
            </div>

            <div class="form-group">
                <label for="description_gg">Description</label>
                <textarea class="form-control" id="description_gg" name="description_gg" rows="4" required>{{ old('description_gg', $painting->description_gg) }}</textarea>
            </div>

            <div class="form-group">
                <label for="artistic_features_gg">Artistic Features</label>
                <textarea class="form-control" id="artistic_features_gg" name="artistic_features_gg" rows="4" required>{{ old('artistic_features_gg', $painting->artistic_features_gg) }}</textarea>
            </div>

            <div class="form-group">
                <label for="additional_info_gg">Additional Information</label>
                <textarea class="form-control" id="additional_info_gg" name="additional_info_gg" rows="4" required>{{ old('additional_info_gg', $painting->additional_info_gg) }}</textarea>
            </div>

            <div class="form-group">
                <label for="img_url_gg">Image</label>
                <input type="file" class="form-control" id="img_url_gg" name="img_url_gg">
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