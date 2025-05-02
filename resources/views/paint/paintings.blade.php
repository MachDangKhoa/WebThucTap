<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Manage Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Navbar Style */
        .navbar {
        background: linear-gradient(90deg, #1f2a3f, #4c6e91);
        padding: 15px 30px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
        font-weight: bold;
        color: white;
        font-size: 1.3rem;
        letter-spacing: 1px;
        transition: color 0.3s ease;
        }

        .navbar-brand:hover {
        color: #1abc9c;
        transform: scale(1.1);
        }

        /* Navbar Menu */
        .navbar-nav {
        margin-left: auto;
        display: flex;
        align-items: center;
        }

        .navbar-nav .nav-item {
        margin-left: 20px;
        }

        .navbar-nav .nav-link {
        color: white;
        font-size: 1rem;
        padding: 8px 15px;
        transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
        color: #1abc9c;
        transform: scale(1.1);
        }

        /* Active Link Style */
        .navbar-nav .nav-item.active .nav-link {
        color: #1abc9c;
        font-weight: bold;
        }

        /* Dropdown Menu */
        .navbar-nav .nav-item.dropdown .nav-link {
        position: relative;
        }

        .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
        }    
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🎨 Admin Art Paintings</a>
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

            <h1 class="text-center">Paintings Datasets</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>account_id</th>
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
                        <td>{{ $painting->account_id }}</td>
                        <td>{{ $painting->painting_title }}</td>
                        <td>{{ $painting->artist_db }}</td>
                        <td>{{ $painting->style_db }}</td>
                        <td>{{ $painting->description }}</td>
                        <td>
                            <a href="{{ route('painting.edit_db', $painting->id_db) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('painting.destroy_db', $painting->id_db) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h1 class="text-center">Paintings Google</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>accounts_id</th>
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
                        <td>{{ $painting->accounts_id }}</td>
                        <td>{{ $painting->title_gg }}</td>
                        <td>{{ $painting->artist_gg }}</td>
                        <td>{{ $painting->style_gg }}</td>
                        <td>{{ $painting->year_gg }}</td>
                        <td>{{ $painting->description_gg }}</td>
                        <td>
                            <a href="{{ route('painting.edit_gg', $painting->id_gg) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('painting.destroy_gg', $painting->id_gg) }}" method="POST" style="display:inline;">
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