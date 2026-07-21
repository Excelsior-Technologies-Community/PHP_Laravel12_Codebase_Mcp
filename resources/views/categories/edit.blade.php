<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .form-card {
            max-width: 600px;
            margin: 50px auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card form-card">

            <div class="card-header py-3">
                Edit Category
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('categories.update', $category->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $category->name }}">
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('categories.index') }}"
                           class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-success">
                            Update Category
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
