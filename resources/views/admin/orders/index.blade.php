<x-layouts.app title="Orders">
    <div class="p-6 space-y-6">

        <!-- HEADER -->
        <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
            Order Masuk
        </h1>
        <!-- FILTER -->
        <form method="GET" class="flex flex-col md:flex-row gap-3">

            <!-- ORDER STATUS -->
            <select name="order_status" class="rounded-lg border px-3 py-2 text-sm dark:bg-zinc-900 dark:border-zinc-700">
                <option value="">Semua Status Order</option>
                @foreach (['draft', 'paid', 'processed', 'shipped', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('order_status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <!-- PAYMENT STATUS -->
            <select name="payment_status"
                class="rounded-lg border px-3 py-2 text-sm dark:bg-zinc-900 dark:border-zinc-700">
                <option value="">Semua Status Pembayaran</option>
                @foreach (['pending', 'paid', 'failed'] as $pay)
                    <option value="{{ $pay }}" @selected(request('payment_status') === $pay)>
                        {{ ucfirst($pay) }}
                    </option>
                @endforeach
            </select>

            <button class="px-4 py-2 bg-black text-white rounded-lg text-sm">
                Filter
            </button>

            @if (request()->hasAny(['order_status', 'payment_status']))
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border rounded-lg text-sm text-center">
                    Reset
                </a>
            @endif

        </form>


        <!-- ===================== MOBILE VIEW ===================== -->
        <div class="space-y-4 md:hidden">
            @foreach ($orders as $order)
                <div class="rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 p-4 space-y-3">

                    <div class="flex justify-between items-center">
                        <span class="font-mono text-xs text-zinc-500">
                            {{ $order->order_code }}
                        </span>

                        <a href="{{ route('admin.admin.orders.show', $order) }}" class="text-sm text-blue-600 font-medium">
                            Detail →
                        </a>
                    </div>

                    <div>
                        <p class="text-sm font-semibold">{{ $order->customer_name }}</p>
                        <p class="text-xs text-zinc-500">
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <!-- ORDER STATUS -->
                        <span
                            class="px-2 py-1 text-xs rounded-full
                            @if ($order->order_status === 'draft') bg-gray-100 text-gray-700
                            @elseif($order->order_status === 'paid') bg-green-100 text-green-700
                            @elseif($order->order_status === 'processed') bg-blue-100 text-blue-700
                            @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-700
                            @elseif($order->order_status === 'completed') bg-emerald-100 text-emerald-700
                            @elseif($order->order_status === 'cancelled') bg-red-100 text-red-700 @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>

                        <!-- PAYMENT STATUS -->
                        <span
                            class="px-2 py-1 text-xs rounded-full
                            @if ($order->payment_status === 'paid') bg-green-100 text-green-700
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center border-t pt-3">
                        <span class="text-sm text-zinc-500">Total</span>
                        <span class="font-bold">
                            Rp {{ number_format($order->total_amount) }}
                        </span>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- ===================== DESKTOP VIEW ===================== -->
        <div
            class="hidden md:block overflow-hidden rounded-xl border bg-white dark:bg-zinc-900 dark:border-zinc-700 shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Kode</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Order Status</th>
                        <th class="px-4 py-3 text-left">Payment</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y dark:divide-zinc-700">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                            <td class="px-4 py-3 font-mono text-xs">
                                {{ $order->order_code }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $order->customer_name }}
                            </td>

                            <td class="px-4 py-3 font-semibold">
                                Rp {{ number_format($order->total_amount) }}
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                    @if ($order->order_status === 'draft') bg-gray-100 text-gray-700
                                    @elseif($order->order_status === 'paid') bg-green-100 text-green-700
                                    @elseif($order->order_status === 'processed') bg-blue-100 text-blue-700
                                    @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-700
                                    @elseif($order->order_status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif($order->order_status === 'cancelled') bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                    @if ($order->payment_status === 'paid') bg-green-100 text-green-700
                                    @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-xs text-zinc-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div>
            {{ $orders->links() }}
        </div>

    </div>
</x-layouts.app>
