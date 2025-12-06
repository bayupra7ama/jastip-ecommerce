<x-layouts.app :title="'Edit Category'">
    <h1 class="text-3xl font-bold mb-6 dark:text-white">Edit Category</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 text-red-700 p-3">
            <ul class="list-disc ps-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl bg-white dark:bg-zinc-900 rounded-xl border p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input name="name" value="{{ old('name', $category->name) }}" required
                    class="mt-1 w-full rounded-lg border p-2 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div>
                <label class="block text-sm font-medium">Slug (optional)</label>
                <input name="slug" value="{{ old('slug', $category->slug) }}"
                    class="mt-1 w-full rounded-lg border p-2 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('slug')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div> --}}

            <div>
                <label class="block text-sm font-medium">Description (optional)</label>
                <textarea name="description" rows="4"
                    class="mt-1 w-full rounded-lg border p-2 dark:border-zinc-700 dark:bg-zinc-800">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Update Category</button>
            </div>
        </form>
    </div>
</x-layouts.app>
