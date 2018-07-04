<?php

namespace App\Repositories;

use App\Models\Categories;
use Intervention\Image\Facades\Image;

class CategoriesRepository
{
    public function getCategories() {
        return Categories::all();
    }

    public function addCategory(array $data) {
        $category = Categories::create($data);
        if ($data['image']) {
            Image::make($data['image'])->save((storage_path('app/public/categories/').$category['id']));
        }

        return $category;
    }

    public function getCategory(string $slug) {
        $category = Categories::where('slug', $slug)->firstOrFail();
        $products = $category->products()->orderBy('id', 'DESC')->simplePaginate(10);

        return compact('category', 'products');
    }

    public function deleteCategory(int $id) {
        $category = Categories::where('id', $id)->firstOrFail();
        $category->products()->delete();
        $category->delete();

        return $category;
    }
}