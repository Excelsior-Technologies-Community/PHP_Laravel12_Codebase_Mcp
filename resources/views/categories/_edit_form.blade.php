<div class="row g-3">

    <div class="col-12">
        <label class="form-label">Category Name</label>

        <input type="text" name="name" id="edit-category-name" class="form-control" value="{{ $category->name }}">

        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    <div class="col-12">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            <button type="submit" class="btn btn-success">
                Update Category
            </button>
        </div>
    </div>

</div>
