<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use App\Models\Categories;
use App\Models\Table;
use App\Models\TransactionItem;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['galleries'])
            ->latest()
            ->get();

        $tables = Table::with(['galleries'])
            ->latest()
            ->get();

        $category = Categories::with(['galleri'])
            ->latest()
            ->get();

        return view('pages.frontend.index', compact('products', 'category', 'tables'));
    }

    public function details(Request $request, $slug)
    {
        $product = Product::with(['galleries'])
            ->where('slug', $slug)
            ->firstOrFail();
        $recommendations = Product::with(['galleries'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.frontend.details', compact('product', 'recommendations'));
    }

    public function TableDetails(Request $request, $slug)
    {
        $table = Table::with(['galleries'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.frontend.TableDetails', compact('table'));
    }

    public function cartAdd(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $quantity = $validatedData['quantity'];

        $price = Product::findOrFail($id);

        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id,
            'quantity' => $quantity,
            'total' => $quantity * $price->price,
            
        ]);

        return redirect('cart');
    }

    public function cartDelete(Request $request, $id)
    {
        $item = Cart::findOrFail($id);

        $item->delete();

        return redirect('cart');
    }

    public function cart(Request $request, )
    {
        $carts = Cart::with(['product.galleries'])
            ->where('users_id', Auth::user()->id)
            ->get();

        $tables = Table::with(['galleries'])
            ->latest()
            ->get();

        $qty = Cart::get('quantity');

        return view('pages.frontend.cart', compact('carts', 'tables','qty'));
    }

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        // Get Carts data
        $carts = Cart::with(['product'])
            ->where('users_id', Auth::user()->id)
            ->get();

        // Add to Transaction data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('total');


        // Create Transaction
        $transaction = Transaction::create($data);

        // Create Transaction item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'transactions_id' => $transaction->id,
                'users_id' => $cart->users_id,
                'products_id' => $cart->products_id,
                'qty' => $cart->quantity
            ]);
        }

        // Delete cart after transaction
        Cart::where('users_id', Auth::user()->id)->delete();

        // Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Setup midtrans variable
        $midtrans = [
            'transaction_details' => [
                'order_id' => 'LX-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer'],
            'vtweb' => [],
        ];

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }

    public function BayarKasir(CheckoutRequest $request)
    {
        $data = $request->all();

        // Get Carts data
        $carts = Cart::with(['product'])->where('users_id', Auth::user()->id)->get();

        // Add to Transaction data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('total');


        // Create Transaction
        $transaction = Transaction::create($data);

        // Create Transaction item
        foreach ($carts as $cart) {
            $items[] = TransactionItem::create([
                'transactions_id' => $transaction->id,
                'users_id' => $cart->users_id,
                'products_id' => $cart->products_id,
                'qty' => $cart->quantity
            ]);
        }

        // Delete cart after transaction
        Cart::where('users_id', Auth::user()->id)->delete();

        return view('pages.frontend.success');
    }

    public function formcash(Request $request)
    {
        $tables = Table::with(['galleries'])
            ->latest()
            ->get();

        return view('pages.frontend.formcash', compact('tables'));
    }

    public function formonline(Request $request)
    {
        $tables = Table::with(['galleries'])
            ->latest()
            ->get();

        return view('pages.frontend.formonline', compact('tables'));
    }
}
