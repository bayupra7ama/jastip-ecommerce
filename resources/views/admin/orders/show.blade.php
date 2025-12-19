<x-layouts.app title="Order Detail">
    <div class="p-4 md:p-6 space-y-6">

        <!-- ================= HEADER ================= -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                    Detail Order
                </h1>
                <p class="text-sm font-mono text-zinc-500">
                    {{ $order->order_code }}
                </p>
            </div>

            <a href="{{ route('admin.admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">
                ← Kembali
            </a>
        </div>

        <!-- ================= STATUS BADGE ================= -->
        <div class="flex flex-wrap gap-2">
            <!-- ORDER STATUS -->
            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                @if ($order->order_status === 'draft') bg-gray-100 text-gray-700
                @elseif($order->order_status === 'paid') bg-green-100 text-green-700
                @elseif($order->order_status === 'processed') bg-blue-100 text-blue-700
                @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-700
                @elseif($order->order_status === 'completed') bg-emerald-100 text-emerald-700
                @else bg-red-100 text-red-700 @endif">
                Order: {{ ucfirst($order->order_status) }}
            </span>

            <!-- PAYMENT STATUS -->
            <span
                class="px-3 py-1 rounded-full text-sm font-medium
                @if ($order->payment_status === 'paid') bg-green-100 text-green-700
                @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700 @endif">
                Payment: {{ ucfirst($order->payment_status) }}
            </span>
        </div>

        <!-- ================= GRID ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ================= LEFT ================= -->
            <div class="lg:col-span-2 space-y-6">

                <!-- CUSTOMER INFO -->
                <div class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5">
                    <h2 class="font-semibold text-lg mb-3">Informasi Customer</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-zinc-500">Nama</p>
                            <p class="font-medium">{{ $order->customer_name }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-500">Email</p>
                            <p class="font-medium">{{ $order->customer_email }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-500">No. HP</p>
                            <p class="font-medium">{{ $order->customer_phone }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-zinc-500">Alamat Pengiriman</p>
                            <p class="font-medium">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- ================= ITEMS (MOBILE) ================= -->
                <div class="space-y-3 md:hidden">
                    <h2 class="font-semibold text-lg">Item Pesanan</h2>

                    @foreach ($order->items as $item)
                        <div class="rounded-lg border p-4 bg-white dark:bg-zinc-900 dark:border-zinc-700">
                            <p class="font-medium">{{ $item->product->name }}</p>

                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-zinc-500">Harga</span>
                                <span>Rp {{ number_format($item->price) }}</span>
                            </div>

                            <div class="flex justify-between text-sm mt-1">
                                <span class="text-zinc-500">Qty</span>
                                <span>{{ $item->quantity }}</span>
                            </div>

                            <div class="flex justify-between font-semibold mt-2 border-t pt-2">
                                <span>Subtotal</span>
                                <span>
                                    Rp {{ number_format($item->price * $item->quantity) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- ================= ITEMS (DESKTOP) ================= -->
                <div
                    class="hidden md:block rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 overflow-hidden">
                    <h2 class="font-semibold p-5 border-b dark:border-zinc-700 text-lg">
                        Item Pesanan
                    </h2>

                    <table class="w-full text-sm">
                        <thead class="bg-zinc-100 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-3 text-left">Produk</th>
                                <th class="px-4 py-3 text-left">Harga</th>
                                <th class="px-4 py-3 text-left">Qty</th>
                                <th class="px-4 py-3 text-left">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y dark:divide-zinc-700">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $item->product->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        Rp {{ number_format($item->price) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3 font-semibold">
                                        Rp {{ number_format($item->price * $item->quantity) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= RIGHT ================= -->
            <div class="space-y-6">

                <!-- SUMMARY -->
                <div class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5">
                    <h2 class="font-semibold text-lg mb-3">Ringkasan</h2>

                    <div class="flex justify-between text-sm">
                        <span class="text-zinc-500">Total</span>
                        <span class="font-bold">
                            Rp {{ number_format($order->total_amount) }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm mt-2">
                        <span class="text-zinc-500">Tanggal Order</span>
                        <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>

                <!-- UPDATE STATUS -->
                <!-- UPDATE STATUS -->
                <div class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-5">
                    <h2 class="font-semibold text-lg mb-4">Update Status</h2>

                    <form method="POST" action="{{ route('admin.admin.orders.update', $order) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- ORDER STATUS -->
                        <div>
                            <label class="text-sm text-zinc-500">Order Status</label>
                            <select name="order_status" class="mt-1 w-full rounded-lg border dark:bg-zinc-800">
                                @foreach (['draft', 'paid', 'processed', 'shipped', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($order->order_status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- PAYMENT STATUS (READ ONLY) -->
                        <div>
                            <label class="text-sm text-zinc-500">Payment Status</label>

                            <div
                                class="mt-1 flex items-center justify-between rounded-lg border px-3 py-2
                        bg-zinc-100 dark:bg-zinc-800 dark:border-zinc-700">
                                <span class="text-sm font-medium">
                                    {{ ucfirst($order->payment_status) }}
                                </span>

                                <span class="text-xs text-zinc-500">
                                    Sistem Update Otomatis
                                </span>
                            </div>
                        </div>

                        <button class="w-full py-2 bg-black text-white rounded-lg hover:opacity-90">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>
