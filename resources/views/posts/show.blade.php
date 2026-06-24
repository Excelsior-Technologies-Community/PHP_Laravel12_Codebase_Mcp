<!DOCTYPE html>
<html>

<head>
    <title>Post Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .post-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        }

        .post-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 25px;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            border-left: 4px solid #4f46e5;
        }

        .content-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            line-height: 1.8;
        }

        .label {
            font-weight: 600;
            color: #6b7280;
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 20px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card post-card">

            <div class="post-header text-white">

                <div class="d-flex justify-content-between align-items-center">

                    <h2 class="mb-0">
                        {{ $post->title }}
                    </h2>

                    @if($post->status == 'Published')
                        <span class="badge bg-success px-3 py-2">
                            Published
                        </span>
                    @elseif($post->status == 'Draft')
                        <span class="badge bg-warning text-dark px-3 py-2">
                            Draft
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2">
                            Archived
                        </span>
                    @endif

                </div>

            </div>

            <div class="card-body p-4">

                <div class="row mb-4">

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <div class="label">Category</div>
                            <div class="fs-5">
                                {{ $post->category->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <div class="label">Created Date</div>
                            <div class="fs-5">
                                {{ $post->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                </div>

                <h5 class="mb-3 text-primary">
                    Post Content
                </h5>

                <div class="content-box">
                    {{ $post->content }}
                </div>

                <div class="mt-4">
                    <a href="{{ route('posts.index') }}"
                        class="btn btn-secondary btn-back">
                        ← Back to Posts
                    </a>
                </div>

            </div>

        </div>

    </div>

</body>

</html>