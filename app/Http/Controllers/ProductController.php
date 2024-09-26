<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubType;
use App\Models\Type;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['type_product', 'sub_type_product'])->get();
        return $this->sendResponse($products, 'List products.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required',
            'sub_type' => 'required',
            'role' => 'nullable',
            'stock' => 'required',
            'image' => 'nullable|max:20000|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 'Validation error.', 400, false, $validator->errors());
        }

        $data = $request->except('_token');
        $filename = '';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move('product_image', $filename);
        }

        $product = Product::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'sub_type' => $data['sub_type'],
            'stock' => $data['stock'],
            'image' => $filename
        ]);

        return $this->sendResponse($product, 'Success create product.', 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productId)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required',
            'sub_type' => 'required',
            'role' => 'nullable',
            'stock' => 'required',
            'image' => 'nullable|max:20000|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([], 'Validation error.', 400, false, $validator->errors());
        }

        $data = $request->except('_token');
        $product = Product::where('id', $productId)->first();
        $filename = $product->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move('product_image', $filename);
        }

        Product::where('id', $productId)->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'sub_type' => $data['sub_type'],
            'stock' => $data['stock'],
            'image' => $filename
        ]);

        return $this->sendResponse([], 'Success update product.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Product $product, $productId)
    {
        Product::where('id', $productId)->delete();

        return $this->sendResponse([], 'Success delete product.');
    }
}
