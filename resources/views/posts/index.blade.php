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

        .popular-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
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

            <div class="d-flex gap-2">

                <a href="{{ route('categories.index') }}" class="btn btn-success">
                    Categories
                </a>

                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    + Create Post
                </a>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
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

                <div class="row mb-4">

                    <div class="col-md-4">
                        <div class="stats-card bg-success">
                            <h5>Published Posts</h5>
                            <h2>{{ $publishedCount }}</h2>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stats-card bg-warning">
                            <h5>Draft Posts</h5>
                            <h2>{{ $draftCount }}</h2>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stats-card bg-danger">
                            <h5>Archived Posts</h5>
                            <h2>{{ $archivedCount }}</h2>
                        </div>
                    </div>

                </div>

                <!-- 🔍 SEARCH BOX -->
                <div class="card card-custom mb-4">
                    <div class="card-body">

                        <form method="GET" action="{{ route('posts.index') }}">

                            <div class="row">

                                <div class="col-md-7">
                                    <input type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Search by title, content, category or status...">
                                </div>

                                <div class="col-md-3">
                                    <select name="status" class="form-select">

                                        <option value="">
                                            All Status
                                        </option>

                                        <option value="Draft"
                                            {{ request('status') == 'Draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>

                                        <option value="Published"
                                            {{ request('status') == 'Published' ? 'selected' : '' }}>
                                            Published
                                        </option>

                                        <option value="Archived"
                                            {{ request('status') == 'Archived' ? 'selected' : '' }}>
                                            Archived
                                        </option>

                                    </select>
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
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($posts as $post)

                                <tr id="post-row-{{ $post->id }}">
                                    <td>{{ $post->id }}</td>

                                    <td>
                                        <span class="badge-category">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>

                                    <td>{{ $post->title }}</td>

                                    <td>{{ Str::limit($post->content, 80) }}</td>

                                    <td>
                                        @if($post->status == 'Published')

                                        <span class="badge bg-success">
                                            Published
                                        </span>

                                        @elseif($post->status == 'Draft')

                                        <span class="badge bg-warning text-dark">
                                            Draft
                                        </span>

                                        @else

                                        <span class="badge bg-danger">
                                            Archived
                                        </span>

                                        @endif
                                    </td>

                                    <td>{{ $post->created_at->format('d M Y') }}</td>

                                    <td>
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="btn btn-info btn-sm">
                                            View
                                        </a>

                                        <button class="btn btn-warning btn-sm"
                                            onclick="editPost({{ $post->id }})">
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm"
                                            onclick="deletePost({{ $post->id }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No Posts Found
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                        <!-- NUMBER ONLY PAGINATION -->
                        <div class="mt-4">
                            {{ $posts->onEachSide(0)->links('pagination::bootstrap-5') }}
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <!-- Popular Posts -->
                <div class="card popular-card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5>🔥 Most Popular Posts</h5>
                    </div>

                    <div class="card-body">
                        @forelse($popularPosts as $post)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded"
                            style="background: #f8f9fa;">
                            <div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none fw-semibold">
                                    {{ Str::limit($post->title, 40) }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $post->views_count }} views</span>
                        </div>
                        @empty
                        <p class="text-muted text-center">No posts yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Post Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit-post-modal-body">
                    Loading...
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete-post-form" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function editPost(id) {
            const modalBody = document.getElementById('edit-post-modal-body');
            const modal = new bootstrap.Modal(document.getElementById('editPostModal'));

            modalBody.innerHTML = 'Loading...';
            modal.show();

            fetch(`/posts/${id}/edit`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;

                    const form = modalBody.querySelector('form');
                    if (form) {
                        form.onsubmit = function(e) {
                            e.preventDefault();

                            const formData = new FormData(form);
                            formData.append('_method', 'PUT');

                            fetch(`/posts/${id}`, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        location.reload();
                                    }
                                });
                        };
                    }
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="text-danger">Failed to load form.</p>';
                });
        }

        function deletePost(id) {
            const form = document.getElementById('delete-post-form');
            form.action = `/posts/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deletePostModal'));
            modal.show();

            form.onsubmit = function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch(`/posts/${id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const row = document.getElementById(`post-row-${id}`);
                            if (row) row.remove();
                            bootstrap.Modal.getInstance(document.getElementById('deletePostModal')).hide();
                        }
                    });
            };
        }
    </script>

</body>

</html>
