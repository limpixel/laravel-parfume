@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Orders Dashboard</h2>

    <form method="GET" action="{{ route('orders.index') }}" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by username or order ID" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Total Amount</th>
                <th>Queue Number</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->username }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>{{ $order->queue_number ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No orders found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
