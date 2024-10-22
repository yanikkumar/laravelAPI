<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
    public function export() {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        $callback = function() {
            $orders = Order::all();
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Quantity', 'Price']);

            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);
                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->quantity, $orderItem->price]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
