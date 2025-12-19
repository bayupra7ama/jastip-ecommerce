<x-layouts.app :title="'Add Product'">

    <h1 class="text-3xl font-bold mb-6 dark:text-white">Add Product</h1>

    <div class="max-w-4xl bg-white dark:bg-zinc-900 rounded-xl border p-6">
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 text-red-700 p-3">
                <ul class="list-disc ps-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- CATEGORY --}}
            <div>
                <label class="font-medium">Category</label>
                <select name="category_id"
                    class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">None</option>
                    @foreach (\App\Models\Category::orderBy('name')->get() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- NAME --}}
            <div>
                <label class="font-medium">Product Name</label>
                <input name="name" required value="{{ old('name') }}"
                    class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800" />
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-medium">Description</label>
                <textarea name="description" rows="4"
                    class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- PRICE --}}
                <div>
                    <label class="font-medium">Price</label>
                    <input type="number" name="price" required value="{{ old('price') }}"
                        class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800" />
                </div>

                {{-- STOCK --}}
                <div>
                    <label class="font-medium">Stock</label>
                    <input type="number" name="stock" required value="{{ old('stock') }}"
                        class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800" />
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="font-medium">Status</label>
                    <select name="status"
                        class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- THUMBNAIL --}}
            <div>
                <label class="font-medium">Thumbnail Image</label>
                <input type="file" name="thumbnail" accept="image/*"
                    class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800" />
            </div>

            {{-- GALLERY --}}
            <div>
                <label class="font-medium">Gallery Images (you can select many)</label>
                <input type="file" id="gallery-input" name="images[]" accept="image/*" multiple
                    class="w-full mt-1 p-2 rounded-lg border dark:border-zinc-700 dark:bg-zinc-800" />
                <div id="gallery-preview" class="flex flex-wrap gap-3 mt-3"></div>
            </div>

            <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow">
                Save Product
            </button>
        </form>
    </div>

    {{-- preview script --}}
    <script>
        document.getElementById('gallery-input').addEventListener('change', function(e) {
            const preview = document.getElementById('gallery-preview');
            preview.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = evt => {
                    const img = document.createElement('img');
                    img.src = evt.target.result;
                    img.className = 'h-24 w-24 object-cover rounded border';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

</x-layouts.app>
