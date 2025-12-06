<x-layouts.app :title="'Edit Product'">

    <h1 class="text-3xl font-bold mb-6 dark:text-white">Edit Product</h1>

    <div class="max-w-4xl mx-auto bg-white dark:bg-zinc-900 rounded-xl border p-6">

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 text-red-700 p-3">
                <ul class="list-disc ps-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data"
            class="space-y-6">
            @csrf @method('PUT')

            {{-- CATEGORY --}}
            <div>
                <label class="font-medium">Category</label>
                <select name="category_id"
                    class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">None</option>
                    @foreach (\App\Models\Category::orderBy('name')->get() as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NAME --}}
            <div>
                <label class="font-medium">Product Name</label>
                <input name="name" value="{{ $product->name }}" required
                    class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-medium">Description</label>
                <textarea name="description" rows="4"
                    class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700">{{ $product->description }}</textarea>
            </div>

            {{-- PRICE / STOCK / STATUS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="font-medium">Price</label>
                    <input type="number" name="price" value="{{ $product->price }}" required
                        class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />
                </div>

                <div>
                    <label class="font-medium">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required
                        class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />
                </div>

                <div>
                    <label class="font-medium">Status</label>
                    <select name="status"
                        class="w-full mt-1 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
            </div>

            {{-- THUMBNAIL --}}
            <div>
                <label class="font-medium">Current Thumbnail</label>

                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                    class="h-24 rounded border dark:border-zinc-700 mt-2" />

                <input type="file" name="thumbnail"
                    class="w-full mt-3 p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />
            </div>

            {{-- GALLERY --}}
            {{-- GALLERY --}}
            {{-- GALLERY --}}
            <div class="space-y-4">

                <label class="font-medium">Gallery Images</label>

                {{-- EXISTING IMAGES --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">

                    @foreach ($product->images as $img)
                        <div class="relative group" data-image-id="{{ $img->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="h-24 w-full object-cover rounded border dark:border-zinc-700">

                            {{-- DELETE (AJAX) --}}
                            <button type="button"
                                data-delete-url="{{ url('admin/products/' . $product->id . '/image/' . $img->id) }}"
                                class="delete-image-btn absolute top-1 right-1 opacity-0 group-hover:opacity-100 
                               transition bg-red-600 text-white rounded px-2 py-1 text-xs">
                                Delete
                            </button>
                        </div>
                    @endforeach

                </div>

                {{-- ADD NEW IMAGES --}}
                <div>
                    <label class="block font-medium mb-2">Add more images</label>

                    <input type="file" id="gallery-input-edit" name="images[]" accept="image/*" multiple
                        class="w-full p-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />

                    {{-- Preview of newly selected images --}}
                    <div id="gallery-preview-edit"
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 mt-3">
                    </div>
                </div>

            </div>


            {{-- SUBMIT --}}
            <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow">
                Update Product
            </button>

        </form>
    </div>

    {{-- JS PREVIEW --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            // DELETE IMAGE (AJAX)
            document.querySelectorAll('.delete-image-btn').forEach(btn => {
                btn.addEventListener('click', async () => {

                    const url = btn.dataset.deleteUrl;
                    if (!url) return alert('URL not found');

                    if (!confirm('Delete this image?')) return;

                    btn.disabled = true;
                    const original = btn.textContent;
                    btn.textContent = '...';

                    try {
                        const res = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        if (!res.ok) throw new Error(`Server responded ${res.status}`);

                        const parent = btn.closest('[data-image-id]');
                        if (parent) parent.remove();

                    } catch (err) {
                        alert("Failed to delete image: " + err.message);
                        btn.disabled = false;
                        btn.textContent = original;
                    }

                });
            });


            // PREVIEW NEW IMAGES
            const input = document.getElementById('gallery-input-edit');

            if (input) {
                input.addEventListener('change', function(e) {

                    const preview = document.getElementById('gallery-preview-edit');
                    preview.innerHTML = '';

                    Array.from(e.target.files).forEach(file => {

                        if (!file.type.startsWith('image/')) return;

                        const reader = new FileReader();
                        reader.onload = event => {
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className =
                                'h-24 w-full object-cover rounded border dark:border-zinc-700';
                            preview.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    });

                });
            }

        });
    </script>


</x-layouts.app>
