@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buat Pesanan</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        {{-- Customer Info --}}
        <div class="mb-3">
            <label for="customer_name" class="form-label">Nama Customer</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
        </div>

        {{-- Product Grid --}}
        <h5 class="mb-3">Pilih Produk</h5>
        <div class="row">
            @foreach($products as $p)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 product-card" 
                         onclick="selectProduct({{ $p->id }}, '{{ $p->name }}', {{ $p->price }})" 
                         style="cursor: pointer;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $p->name }}</h5>
                            <p class="card-text">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Order Items Section --}}
        <h5 class="mt-4">Produk yang Dipilih</h5>
        <div id="selected-items"></div>

        <button type="submit" class="btn btn-success mt-3">Simpan Pesanan</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>

<script>
let itemIndex = 0;

function selectProduct(id, name, price) {
    const container = document.getElementById('selected-items');

    // cek kalau produk sudah ada di form
    if (document.getElementById('product-' + id)) {
        alert(name + " sudah dipilih!");
        return;
    }

    const html = `
        <div class="row mb-3" id="product-${id}">
            <div class="col-md-5">
                <input type="hidden" name="items[${itemIndex}][product_id]" value="${id}">
                <input type="text" class="form-control" value="${name}" readonly>
            </div>
            <div class="col-md-3">
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" value="Rp ${price.toLocaleString()}" readonly>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${id})">X</button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    itemIndex++;
}

function removeProduct(id) {
    const item = document.getElementById('product-' + id);
    if (item) item.remove();
}
</script>
@endsection
