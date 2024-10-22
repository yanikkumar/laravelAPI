<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(Request $request)
    {

        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        return new ProductResource(Product::find($id));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->only('title', 'description', 'image', 'price'));

        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        Product::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
