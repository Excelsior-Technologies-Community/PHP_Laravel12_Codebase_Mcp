<form method="POST" action="{{ route('posts.update', $post->id) }}" id="edit-post-form">

    @csrf
    @method('PUT')

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Category</label>

            <select name="category_id" class="form-select" id="edit-category-id">

                @foreach($categories as $category)

                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Status</label>

            <select name="status" class="form-select" id="edit-status">

                <option value="Draft" {{ $post->status == 'Draft' ? 'selected' : '' }}>Draft</option>

                <option value="Published" {{ $post->status == 'Published' ? 'selected' : '' }}>Published</option>

                <option value="Archived" {{ $post->status == 'Archived' ? 'selected' : '' }}>Archived</option>

            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Post Title</label>

            <input type="text" name="title" id="edit-title" class="form-control" value="{{ $post->title }}">
        </div>

        <div class="col-12">
            <label class="form-label">Content</label>

            <textarea name="content" id="edit-content" rows="6" class="form-control">{{ $post->content }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Tags</label>

            <select name="tags[]" class="form-select" id="edit-tags" multiple>

                @foreach($tags as $tag)

                <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>

                @endforeach

            </select>
        </div>

        <div class="col-12">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-success">
                    Update Post
                </button>
            </div>
        </div>

    </div>

</form>
