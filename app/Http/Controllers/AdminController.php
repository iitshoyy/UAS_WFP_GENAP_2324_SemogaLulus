<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Reservasi;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    function getDashboardAdmin(){
        $topCustomers = User::select('users.id', 'users.name', DB::raw('COUNT(reservasis.id) as reservations_count'))
            ->join('reservasis', 'reservasis.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('reservations_count', 'desc')
            ->take(10)
            ->get();

        // Get top hotels
        $topHotels = Hotel::select('hotels.id', 'hotels.name', DB::raw('COUNT(reservasis.id) as reservations_count'))
            ->join('products', 'products.hotel_id', '=', 'hotels.id')
            ->join('reservasis', 'reservasis.product_id', '=', 'products.id')
            ->groupBy('hotels.id', 'hotels.name')
            ->orderBy('reservations_count', 'desc')
            ->take(10)
            ->get();

        // Get top products
        $topProducts = Product::select('products.id', 'products.name', DB::raw('COUNT(reservasis.id) as reservations_count'))
            ->join('reservasis', 'reservasis.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderBy('reservations_count', 'desc')
            ->take(10)
            ->get();
        return view('admin.dashboard',compact('topCustomers', 'topHotels', 'topProducts'));
    }
    public function getCustomerDetails($id)
    {
        $customer = User::findOrFail($id);
        $reservations = Reservasi::where('user_id', $id)
            ->with(['product.hotel', 'transaction'])
            ->get();

        return response()->json([
            'customer' => $customer,
            'reservations' => $reservations
        ]);
    }

    public function getHotelDetails($id)
    {
        $hotel = Hotel::findOrFail($id);
        $reservations = Reservasi::whereHas('product', function($query) use ($id) {
            $query->where('hotel_id', $id);
        })->with(['user', 'product'])->get();

        return response()->json([
            'hotel' => $hotel,
            'reservations' => $reservations
        ]);
    }

    public function getProductDetails($id)
    {
        $product = Product::findOrFail($id);
        $reservations = Reservasi::where('product_id', $id)
            ->with(['user', 'product.hotel'])
            ->get();

        return response()->json([
            'product' => $product,
            'reservations' => $reservations
        ]);
    }

    public function getHotels(){
        $hotels = Hotel::all();
        $types = Type::all();
        return view('admin.listHotel', compact('hotels', 'types'));
    }
    public function addHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        Hotel::create($request->all());

        return redirect()->back()->with('success', 'Hotel added successfully');
    }
    public function addTypeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Type::create($request->all());

        return redirect()->back()->with('success', 'Type added successfully');
    }

    public function getTransactions(){
        $transactions = Transaction::all();
        return view('admin.listTransaction', compact('transactions'));
    }
    public function getTransactionDetails(Request $request){
        try{
            $transaction = Transaction::with(['reservasis.product.hotel'])->find($request->id);
            $reservations = $transaction->reservasis;
            return response()->json([
                'transaction' => $transaction,
                'reservations' => $reservations
            ]);
        }catch(\Exception $e){
            return $e->getMessage();

        }

    }
    public function getProduks(){
        $products = Product::with('productType')->get();
        $productTypes = ProductType::all();
        $hotels = Hotel::all();
        return view('admin.listProduct', compact('products', 'productTypes','hotels'));
    }
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'product_type_id' => 'required|exists:product_types,id',
            'nama_fasilitas' => 'required',
            'deskripsi_fasilitas' => 'required',
        ]);

        Product::create($request->all());
        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function storeProductType(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_types,name',
        ]);

        ProductType::create($request->all());
        return redirect()->back()->with('success', 'Product type created successfully.');
    }
    public function getCustomer(){
        $customers = User::all();
        return view('admin.listCustomer', compact('customers'));
    }
}
