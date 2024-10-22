<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('orderItems')->paginate();
        return OrderResource::collection($orders);
    }

    public function show($id) {
        $order = Order::with('orderItems')->find($id);
        return new orderResource($order);
    }
}
