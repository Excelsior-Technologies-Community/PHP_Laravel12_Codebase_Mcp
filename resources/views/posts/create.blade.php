<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .form-card {
            max-width: 800px;
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
                Create New Post
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('posts.store') }}">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Category
                        </label>

                        <select name="category_id" class="form-select">

                            @foreach($categories as $category)

                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Post Title
                        </label>

                        <input type="text" name="title" class="form-control" placeholder="Enter Post Title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Content
                        </label>

                        <textarea name="content" rows="6" class="form-control"
                            placeholder="Enter Post Content"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="Draft">
                                Draft
                            </option>

                            <option value="Published">
                                Published
                            </option>

                            <option value="Archived">
                                Archived
                            </option>

                        </select>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-success">
                            Save Post
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>