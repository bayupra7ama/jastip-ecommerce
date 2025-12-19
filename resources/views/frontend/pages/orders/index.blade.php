<x-frontend.layouts.app title="Pesanan Saya">

    {{-- BREADCRUMB --}}
    @include('frontend.partials.breadcrumb', [
        'title' => 'Pesanan Saya',
        'subtitle' => 'Riwayat transaksi',
    ])

    <div class="container mt-150 mb-150">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- FILTER STATUS --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="product-filters">
                            <ul>
                                <li class="{{ request('status') == null ? 'active' : '' }}">
                                    <a href="{{ route('orders.index') }}">All</a>
                                </li>

                                <li class="{{ request('status') == 'draft' ? 'active' : '' }}">
                                    <a href="{{ route('orders.index', ['status' => 'draft']) }}">
                                        Draft
                                    </a>
                                </li>

                                {{-- <li class="{{ request('status') == 'paid' ? 'active' : '' }}">
                                    <a href="{{ route('orders.index', ['status' => 'paid']) }}">
                                        Paid
                                    </a>
                                </li> --}}

                                <li class="{{ request('status') == 'processed' ? 'active' : '' }}">
                                    <a href="{{ route('orders.index', ['status' => 'processed']) }}">
                                        Processed
                                    </a>
                                </li>

                                <li class="{{ request('status') == 'shipped' ? 'active' : '' }}">
                                    <a href="{{ route('orders.index', ['status' => 'shipped']) }}">
                                        Dikirim
                                    </a>
                                </li>

                                <li class="{{ request('status') == 'completed' ? 'active' : '' }}">
                                    <a href="{{ route('orders.index', ['status' => 'completed']) }}">
                                        Completed
                                    </a>
                                </li>

                                <li class="{{ request('status') == 'cancelled' ? 'active' : '' }} cart-btn">
                                    <a href="{{ route('orders.index', ['status' => 'cancelled']) }}">
                                        Cancelled
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                {{-- CARD --}}
                <div class="checkout-accordion-wrap">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Daftar Pesanan Saya
                        </h5>
                    </div>

                    <div class="card-body">

                        {{-- TABLE --}}
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Total</th>
                                        <th>Status Order</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_code }}</td>

                                            <td>
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>

                                            <td>
                                                <span
                                                    class="badge
                                                            @if ($order->order_status == 'pending') badge-warning
                                                            @elseif ($order->order_status == 'processed') badge-info
                                                            @elseif ($order->order_status == 'completed') badge-success
                                                            @else badge-danger @endif
                                                        ">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <span
                                                    class="badge
                                                            {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-secondary' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="boxed-btn black btn-sm">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                Belum ada pesanan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- PAGINATION --}}
                        {{-- PAGINATION --}}
                        @if ($orders->hasPages())
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    {{ $orders->withQueryString()->links('vendor.pagination.fruitkha') }}
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>

</x-frontend.layouts.app>
