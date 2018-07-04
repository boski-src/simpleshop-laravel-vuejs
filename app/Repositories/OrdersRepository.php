<?php

namespace App\Repositories;

use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class OrdersRepository
{
    public function getOrders(int $limit) {
        return Auth::user()
            ->orders()
            ->paginate($limit);
    }

    public function getAllOrders(int $limit) {
        return Orders::orderBy('id', 'DESC')
            ->paginate($limit);
    }

    public function addOrder(array $data) {
        $products = $data['products'];
        $billing = $data['billing'];

        $order = Orders::create([
            'hash' => md5(serialize([$products, $billing]).str_random(16)),
            'billing' => json_encode($billing),
        ]);

        $price = 0;
        foreach ($products as $product) {
            $item = Products::where('id', $product['id'])->where('status', 1)->first();

            OrdersItems::create([
                'order_id' => $order['id'],
                'product_id' => $product['id'],
                'count' => $product['quantity'],
                'price' => round(($item['price'] * $product['quantity']), 2),
            ]);

            $price += $item['price'] * $product['quantity'];
        }

        $order->price = round($price, 2);
        $order->save();

        return $order;
    }

    public function getOrder(string $hash, $auth = true) {
        if ($auth) {
            $order = Orders::where('created_by', Auth::user()->id)->where('hash', $hash)->firstOrFail();
            $order->items;
        } else {
            $order = Orders::where('hash', $hash)->firstOrFail();
            $order->items;
        }

        return $order;
    }

    public function updateOrder(int $id, array $data) {
        $order = Orders::where('id', $id)->firstOrFail();
        $order->paid = $data['paid'];
        $order->payment_status = $data['payment_status'];
        $order->payment_id = $data['payment_id'];
        $order->status = $data['status'];
        $order->save();

        if ($data['status'] === 'completed') {
            $productRepo = new ProductsRepository();
            foreach ($order->items as $item) {
                $productRepo->deAvailable($item['product_id'], $item['count']);
            }
        }

        return $order;
    }

    public function deleteOrder(string $hash) {
        $order = Orders::where('hash', $hash)->firstOrFail();
        $order->delete();

        return $order;
    }
}