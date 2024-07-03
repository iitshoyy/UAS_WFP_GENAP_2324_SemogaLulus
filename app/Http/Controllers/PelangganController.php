<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\Reservasi;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    function detailHotel($id)
    {
        $hotel = Hotel::find($id);
        $products = Product::where('hotel_id', $id)->get();
        return view('detailHotel', compact('hotel', 'products'));
    }

    function reservasi(Request $request)
    {
        try {
            // Get logged-in user
            $user = Auth::user();

            // Get the hotel ID and quantities from the form
            $hotelId = $request->input('hotel_id');
            $quantities = $request->input('quantities');

            // Calculate the total price and create transaction
            $subtotal = 0;
            foreach ($quantities as $productId => $quantity) {
                if ($quantity > 0) {
                    $product = Product::findOrFail($productId);

                    $subtotal += $product->price * $quantity;
                }
            }

            $fee = $subtotal * 0.11;
            $totalPrice = $subtotal + $fee;

            $transaction = Transaction::create([
                'price' => $subtotal,
                'invoice' => 'INV-' . time(),
                'total_price' => $totalPrice
            ]);

            // Create reservations
            foreach ($quantities as $productId => $quantity) {
                if ($quantity > 0) {
                    Reservasi::create([
                        'tanggal_jam' => now(),
                        'keterangan' => 'Reserved through website',
                        'product_id' => $productId,
                        'user_id' => $user->id,
                        'transaction_id' => $transaction->id
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Reservation successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
