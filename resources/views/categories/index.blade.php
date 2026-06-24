<!DOCTYPE html>
<html>

<head>
    <title>Categories</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .category-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .page-title {
            font-weight:700;
        }

        .table thead {
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            color:white;
        }

        .badge-category {
            background:#e0e7ff;
            color:#4338ca;
            padding:8px 14px;
            border-radius:20px;
            font-size:14px;
        }

        .btn-add {
            border-radius:10px;
            padding:10px 18px;
        }

        .pagination {
            justify-content:center;
            margin-top:25px;
        }

        .pagination .page-link {
            border:none;
            border-radius:10px;
            margin:0 4px;
            color:#4f46e5;
            box-shadow:0 3px 8px rgba(0,0,0,.1);
        }

        .pagination .active .page-link {
            background:#4f46e5;
            color:white;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">
                Category Management
            </h2>

            <p class="text-muted">
                Manage your blog categories
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="btn btn-primary btn-add">
            + Add Category
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card category-card">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0">
                📂 Categories List
            </h5>

        </div>

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Created Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>
                            {{ $category->id }}
                        </td>

                        <td>

                            <span class="badge-category">
                                {{ $category->name }}
                            </span>

                        </td>

                        <td>
                            {{ $category->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="text-center text-muted py-4">
                            No Categories Found
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>


            {{ $categories->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

</body>

</html>