<x-layouts.app :title="'Products'">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">

        <h1 class="text-3xl font-bold dark:text-white">Products</h1>

        {{-- Search + Add button --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

            <form method="GET" action="{{ route('admin.products.index') }}"
                class="flex items-center gap-2 w-full sm:w-auto">

                <input name="q" value="{{ request('q') }}" placeholder="Search product..."
                    class="flex-1 px-3 py-2 rounded-lg border dark:bg-zinc-800 dark:border-zinc-700" />

                <button type="submit" class="px-3 py-2 bg-zinc-800 text-white rounded-lg whitespace-nowrap">
                    Search
                </button>
            </form>

            <a href="{{ route('admin.products.create') }}"
                class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow whitespace-nowrap">
                <flux:icon.plus class="size-4" />
                Add Product
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-100 text-red-800 px-4 py-2">{{ session('error') }}</div>
    @endif



    {{-- DESKTOP TABLE (md+) --}}
    <div
        class="hidden md:block overflow-hidden rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">

        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-100 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Product</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Price</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Stock</th>
                    <th class="px-4 py-3 text-right text-sm font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">

                @forelse ($products as $product)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">

                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                class="h-12 w-12 object-cover rounded-lg border dark:border-zinc-700">
                        </td>

                        <td class="px-4 py-2">
                            <div class="font-medium dark:text-white">{{ $product->name }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ Str::limit($product->description, 80) }}
                            </div>
                        </td>

                        <td class="px-4 py-2">Rp {{ number_format($product->price) }}</td>

                        <td class="px-4 py-2">{{ $product->stock }}</td>

                        <td class="px-4 py-2 text-right flex justify-end gap-3">

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                <flux:icon.pencil-square class="size-4" /> Edit
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 dark:text-red-400 hover:underline flex items-center gap-1">
                                    <flux:icon.trash class="size-4" /> Delete
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-zinc-600 dark:text-zinc-400">
                            No products available
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="p-4 flex items-center justify-between">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                Showing {{ $products->firstItem() ?: 0 }} - {{ $products->lastItem() ?: 0 }}
                of {{ $products->total() }} products
            </div>
            <div>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>

    </div>


    {{-- MOBILE CARD VIEW (sm) --}}
    <div class="md:hidden space-y-4">

        @forelse ($products as $product)
            <div class="rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4 shadow-sm">

                <div class="flex gap-4">

                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                        class="h-20 w-20 rounded-lg object-cover border dark:border-zinc-700">

                    <div class="flex-1">
                        <div class="font-semibold dark:text-white text-lg">{{ $product->name }}</div>

                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ Str::limit($product->description, 60) }}
                        </div>

                        <div class="mt-2 text-sm">
                            <span class="text-zinc-600 dark:text-zinc-300">Price:</span>
                            <span class="font-semibold">Rp {{ number_format($product->price) }}</span>
                        </div>

                        <div class="text-sm">
                            <span class="text-zinc-600 dark:text-zinc-300">Stock:</span>
                            {{ $product->stock }}
                        </div>

                    </div>

                </div>

                {{-- Actions --}}
                <div class="mt-4 flex justify-between">

                    <a href="{{ route('admin.products.edit', $product->id) }}"
                        class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm flex items-center gap-1">
                        <flux:icon.pencil-square class="size-4" /> Edit
                    </a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm flex items-center gap-1">
                            <flux:icon.trash class="size-4" /> Delete
                        </button>
                    </form>

                </div>

            </div>

        @empty
            <div class="text-center text-zinc-600 dark:text-zinc-400 py-6">
                No products available
            </div>
        @endforelse

        <div class="pt-2">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>

</x-layouts.app>
