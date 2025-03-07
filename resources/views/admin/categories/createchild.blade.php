<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tạo danh mục mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Tên danh mục -->
                    <div class="mt-3 mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh -->
                    <div class="mt-3 mb-3">
                        <label for="image" class="form-label">Ảnh</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mô tả -->
                    <div class="mt-3 mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" cols="40" rows="4"
                            class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thuộc danh mục -->
                    <div class="mt-3 mb-3">
                        <label for="parent_category_id" class="form-label">Thuộc danh mục</label>
                        <select name="parent_category_id" id="parent_category_id" class="form-control">
                            <option value="" {{ old('parent_category_id') == '' ? 'selected' : '' }}>Danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="mt-3 mb-3">
                        <label for="is_active" class="form-label">Trạng thái</label>
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active') ? 'checked' : '' }} checked>
                    </div>
            </div>

            <!-- Nút hành động -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Tạo mới</button>
            </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#exampleModalCenter').modal('show');
        });
    </script>
@endif