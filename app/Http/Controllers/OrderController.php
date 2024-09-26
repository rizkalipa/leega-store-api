<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $orders = Order::select('id', 'user_id', 'total', 'status')
            ->where('user_id', $userId)
            ->with(['order_details', 'order_details.product'])
            ->get();

        return $this->sendResponse($orders, 'List orders.');
    }
    public function save(Request $request)
    {
        $validator = Validator::make(request()->json()->all(), [
            'user_id' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 'Validation error.', 400, false, $validator->errors());
        }

        try {
            $data = $request->json()->all();
            $carts = Cart::select('id', 'product_id', 'qty')
                ->where('user_id', $data['user_id'])
                ->where('status', Cart::STATUS_DEFAULT)
                ->with('product', 'product.type_product')
                ->get();

            if ($carts->isEmpty()) {
                return $this->sendResponse([], 'Nothing to checkout.', 400, false);
            }

            $order = Order::create([
                'user_id' => $data['user_id'],
                'total' => trim($data['total']),
                'status' => trim(Order::STATUS_DEFAULT)
            ]);

            foreach ($carts as $cart) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'sub_total' => $cart->qty * $cart->product->price
                ]);

                Cart::where('id', $cart->id)->update(['status' => Cart::STATUS_CHECKOUT]);
            }
        } catch (\Exception $e) {
            return $this->sendResponse([], 'Error while saving data.', 500, false, $e->getMessage());
        }

        return $this->sendResponse($order, 'Success save to cart.', 201);
    }

    public function show(Request $request, $orderId)
    {
        $userId = $request->input('user_id');
        $orders = Order::select('id', 'user_id', 'total', 'status')
            ->where('user_id', $userId)
            ->where('order_id', $orderId)
            ->with('order_details')
            ->first();

        return $this->sendResponse($orders, 'List orders.');
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }
}
