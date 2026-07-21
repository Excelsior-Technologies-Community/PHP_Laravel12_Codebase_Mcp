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

        .tag-badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin: 3px;
            display: inline-block;
        }

        .comment-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .comment-header {
            background: #f8fafc;
            padding: 10px 15px;
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #eee;
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

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="label">Category</div>
                            <div class="fs-5">
                                {{ $post->category->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="label">Created Date</div>
                            <div class="fs-5">
                                {{ $post->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="label">Views</div>
                            <div class="fs-5">
                                {{ $post->views_count }}
                            </div>
                        </div>
                    </div>

                </div>

                @if($post->tags->count() > 0)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Tags:</h6>

                    @foreach($post->tags as $tag)
                    <span class="tag-badge">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

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

        <!-- Comments Section -->
        <div class="card post-card mt-5">
            <div class="card-header bg-white py-3">
                <h5>💬 Comments ({{ $approvedComments->count() }})</h5>
            </div>

            <div class="card-body p-4">

                <!-- Comment Form -->
                <form id="comment-form" class="mb-4">
                    @csrf

                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>

                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>

                        <div class="col-12">
                            <textarea name="comment" rows="3" class="form-control" placeholder="Write a comment..." required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </div>
                    </div>
                </form>

                <div id="comment-message"></div>

                <!-- Comments List -->
                <div id="comments-list">
                    @forelse($approvedComments as $comment)
                    <div class="comment-card">
                        <div class="comment-header d-flex justify-content-between">
                            <strong>{{ $comment->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $comment->comment }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('comment-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const messageDiv = document.getElementById('comment-message');

            fetch('{{ route('comments.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.innerHTML =
                            '<div class="alert alert-success">Comment submitted for approval. Thank you!</div>';
                        this.reset();
                    }
                })
                .catch(() => {
                    messageDiv.innerHTML = '<div class="alert alert-danger">Something went wrong.</div>';
                });
        });
    </script>

</body>

</html>
