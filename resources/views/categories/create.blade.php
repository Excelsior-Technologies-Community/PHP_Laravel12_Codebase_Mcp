<!DOCTYPE html>
<html>

<head>
    <title>Create Category</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header">
            Create Category
        </div>

        <div class="card-body">

            <form action="{{ route('categories.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Category Name</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter Category Name">
                </div>

                <button class="btn btn-success">
                    Save Category
                </button>

                <a href="{{ route('categories.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>