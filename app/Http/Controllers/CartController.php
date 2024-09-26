<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $cart = Cart::select('id', 'user_id', 'product_id', 'qty')
            ->where('user_id', $userId)
            ->with('product', 'product.type_product')
            ->get();

        return $this->sendResponse($cart, 'List cart.');
    }

    public function save(Request $request)
    {
        $validator = Validator::make(request()->json()->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'qty' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 'Validation error.', 400, false, $validator->errors());
        }

        $data = $request->json()->all();
        $cart = Cart::create([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'qty' => $data['qty']
        ]);

        return $this->sendResponse($cart, 'Success save to cart.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
