<x-layouts.app :title="'Categories'">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold dark:text-white">Categories</h1>

        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
            <flux:icon.plus class="size-4" /> Add Category
        </a>
    </div>

    {{-- FLASH MESSAGES --}}
    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-100 text-red-800 px-4 py-2 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif


    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-hidden rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-100 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-sm">Description</th>
                    <th class="px-4 py-3 text-right font-semibold text-sm">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($categories as $cat)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="px-4 py-3 font-medium dark:text-white">
                            {{ $cat->name }}
                        </td>

                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ Str::limit($cat->description, 80) }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">

                                <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                    <flux:icon.pencil-square class="size-4" /> Edit
                                </a>

                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="text-red-600 dark:text-red-400 hover:underline flex items-center gap-1">
                                        <flux:icon.trash class="size-4" /> Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-zinc-600 dark:text-zinc-400 text-sm">
                            No categories yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $categories->links() }}
        </div>
    </div>



    {{-- MOBILE CARD LIST --}}
    {{-- MOBILE CARD LIST --}}
    <div class="md:hidden space-y-4">

        @forelse ($categories as $cat)
            <div class="border rounded-lg p-4 bg-white dark:bg-zinc-900 dark:border-zinc-700 shadow-sm">

                <div class="flex justify-between items-start">

                    {{-- INFO CATEGORY --}}
                    <div>
                        <h2 class="font-semibold text-lg dark:text-white">{{ $cat->name }}</h2>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                            {{ Str::limit($cat->description, 100) }}
                        </p>
                    </div>


                    {{-- FIXED MOBILE ACTION MENU --}}
                    <div x-data="{ open: false }" class="relative">

                        <!-- Trigger -->
                        <button @click="open = !open" class="p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700">
                            <flux:icon.ellipsis-vertical class="size-6 text-zinc-700 dark:text-zinc-300" />
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-40 bg-white dark:bg-zinc-800 shadow-lg rounded-lg border dark:border-zinc-700 z-50">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                class="block px-4 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-100 dark:hover:bg-red-900">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        @empty
            <p class="text-center text-zinc-600 dark:text-zinc-400">No categories found.</p>
        @endforelse

        <div class="py-3">{{ $categories->links() }}</div>

    </div>



</x-layouts.app>
