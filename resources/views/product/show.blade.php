@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Product Detail</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <p class="card-text"><strong>Description:</strong> {{ $product->description ?? '-' }}</p>
            <p class="card-text"><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
