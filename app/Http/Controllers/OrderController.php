<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB; // ← ini yang kurang

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        $orders = Order::with('items.product')->get();
        return view('orders.index', compact('orders', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // ambil semua product
        $products = Product::orderBy('name', 'asc')->get();

        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'items'    => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        // Generate nomor antrian acak (misal 1000–9999)
        $queueNumber = random_int(1000, 9999);

        // Buat order dulu
        $order = Order::create([
            'username'     => $request->username,
            'total_amount' => 0, // akan dihitung di bawah
            'queue_number' => $queueNumber,
        ]);

        $total = 0;

        // Loop item pesanan
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            // Simpan item order
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $product->id,
                'quantity'  => $item['quantity'],
                'price'     => $product->price,
            ]);

            // Update stok produk
            $product->decrement('stock', $item['quantity']);
        }

        // Update total nominal order
        $order->update(['total_amount' => $total]);

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'Order berhasil dibuat! Nomor antrian: '.$queueNumber);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Order $orders)
    {
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
