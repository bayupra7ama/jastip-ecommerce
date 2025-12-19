<x-layouts.app title="Admin Dashboard">
    <div class="p-6 space-y-6">

        <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
            Dashboard Admin
        </h1>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- PRODUCTS -->
            <a href="{{ route('admin.products.index') }}"
               class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5
                      hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Total Produk</p>
                        <p class="text-3xl font-bold mt-1">
                            {{ $totalProducts }}
                        </p>
                    </div>

                    <div class="text-blue-600 text-3xl">
                        📦
                    </div>
                </div>
            </a>

            <!-- CATEGORIES -->
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5
                      hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Total Kategori</p>
                        <p class="text-3xl font-bold mt-1">
                            {{ $totalCategories }}
                        </p>
                    </div>

                    <div class="text-purple-600 text-3xl">
                        🏷️
                    </div>
                </div>
            </a>

            <!-- ORDERS -->
            <a href="{{ route('admin.admin.orders.index') }}"
               class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5
                      hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Total Pesanan</p>
                        <p class="text-3xl font-bold mt-1">
                            {{ $totalOrders }}
                        </p>
                    </div>

                    <div class="text-green-600 text-3xl">
                        🧾
                    </div>
                </div>
            </a>

        </div>

    </div>
</x-layouts.app>
