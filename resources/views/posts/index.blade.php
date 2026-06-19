<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Codebase MCP - Blog Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table thead {
            background: #4f46e5;
            color: white;
        }

        .page-title {
            font-weight: 700;
        }

        .badge-category {
            background: #e0e7ff;
            color: #4338ca;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
        }

        .stats-card {
            border-radius: 15px;
            color: white;
            padding: 20px;
        }

        .bg-posts {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .bg-categories {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .pagination {
            justify-content: center;
        }

        .pagination .page-item .page-link {
            border-radius: 8px;
            margin: 0 3px;
            color: #4f46e5;
        }

        .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-custom shadow">
        <div class="container">
            <a class="navbar-brand fw-bold">🚀 Laravel Codebase MCP</a>
        </div>
    </nav>

    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="page-title">Blog Management Dashboard</h2>
                <p class="text-muted">Laravel 12 + MCP Demo</p>
            </div>

            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                + Create Post
            </a>
        </div>

        <!-- Stats -->
        <div class="row mb-4">

            <div class="col-md-6">
                <div class="stats-card bg-posts">
                    <h5>Total Posts</h5>
                    <h2>{{ $posts->total() }}</h2>
                </div>
            </div>

            <div class="col-md-6">
                <div class="stats-card bg-categories">
                    <h5>Total Categories</h5>
                    <h2>{{ \App\Models\Category::count() }}</h2>
                </div>
            </div>

        </div>

        <!-- 🔍 SEARCH BOX -->
        <div class="card card-custom mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('posts.index') }}">

                    <div class="row">

                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search by title, content or category...">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                Search
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-custom">

            <div class="card-header bg-white py-3">
                <h5>📚 Posts List</h5>
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                            <tr>
                                <td>{{ $post->id }}</td>

                                <td>
                                    <span class="badge-category">
                                        {{ $post->category->name }}
                                    </span>
                                </td>

                                <td>{{ $post->title }}</td>

                                <td>{{ Str::limit($post->content, 80) }}</td>

                                <td>{{ $post->created_at->format('d M Y') }}</td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No Posts Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <!-- 🔢 NUMBER ONLY PAGINATION -->
                <div class="mt-4">
                    {{ $posts->onEachSide(0)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    </div>

</body>

</html>