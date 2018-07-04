<?php

namespace App\Repositories;

use App\Models\Products;
use Intervention\Image\Facades\Image;

class ProductsRepository
{
    public function getProducts(int $limit) {
        return Products::orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function searchProduct(string $keyword) {
        return Products::where('name', 'LIKE', '%'.$keyword.'%')
            ->orderBy('id', 'DESC')
            ->limit(6)
            ->get();
    }

    public function addProduct(array $data) {
        $product = Products::create($data);
        if ($data['image']) {
            Image::make($data['image'])->save((storage_path('app/public/products/').$product['id']));
        }

        return $product;
    }

    public function getProduct(int $id) {
        return Products::where('id', $id)->firstOrFail();
    }

    public function inAvailable(int $id, int $added) {
        $product = Products::where('id', $id)->firstOrFail();
        $product->available += $added;
        $product->save();
    }

    public function deAvailable(int $id, int $removed) {
        $product = Products::where('id', $id)->firstOrFail();
        $product->available -= $removed;
        $product->save();
    }

    public function deleteProduct(int $id) {
        $product = Products::where('id', $id)->firstOrFail();
        $product->delete();

        return $product;
    }
}