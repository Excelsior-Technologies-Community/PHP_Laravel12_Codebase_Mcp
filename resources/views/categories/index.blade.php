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
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($categories as $category)

                    <tr id="category-row-{{ $category->id }}">

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

                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}')">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm"
                                onclick="deleteCategory({{ $category->id }})">
                                Delete
                            </button>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center text-muted py-4">
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

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="edit-category-modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category? Posts in this category will be uncategorized.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-category-form" method="POST" class="d-inline">
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
    function editCategory(id, name) {
        const modalBody = document.getElementById('edit-category-modal-body');
        const modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));

        modalBody.innerHTML = `
            <form id="edit-category-form" class="row g-3">
                <div class="col-12">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" id="edit-category-name" class="form-control" value="${name}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Category</button>
                    </div>
                </div>
            </form>
        `;

        modal.show();

        const form = modalBody.querySelector('form');
        form.onsubmit = function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch(`/categories/${id}`, {
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

    function deleteCategory(id) {
        const form = document.getElementById('delete-category-form');
        form.action = `/categories/${id}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
        modal.show();

        form.onsubmit = function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch(`/categories/${id}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById(`category-row-${id}`);
                        if (row) row.remove();
                        bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal')).hide();
                    }
                });
        };
    }
</script>

</body>

</html>
