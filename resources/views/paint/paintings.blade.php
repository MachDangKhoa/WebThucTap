<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Manage Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin Paintings</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paintings.index') }}"><i class="fas fa-users"></i> Manage Paintings</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="container">
            <h1>Paintings List</h1>

            <h2>Painting DB</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Style</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paintingDb as $painting)
                    <tr>
                        <td>{{ $painting->painting_title }}</td>
                        <td>{{ $painting->artist_db }}</td>
                        <td>{{ $painting->style_db }}</td>
                        <td>{{ $painting->description }}</td>
                        <td>
                            <a href="{{ route('painting.edit', $painting->id_db) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('painting.destroy', $painting->id_db) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h2>Painting Google</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Style</th>
                        <th>Year</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paintingGoogle as $painting)
                    <tr>
                        <td>{{ $painting->title_gg }}</td>
                        <td>{{ $painting->artist_gg }}</td>
                        <td>{{ $painting->style_gg }}</td>
                        <td>{{ $painting->year_gg }}</td>
                        <td>{{ $painting->description_gg }}</td>
                        <td>
                            <a href="{{ route('paintinggoogle.edit', $painting->id_gg) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('paintinggoogle.destroy', $painting->id_gg) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>