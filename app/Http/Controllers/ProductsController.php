<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Validator;

class ProductsController extends Controller
{
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->repository = $productsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendRes('Last added products received successfully.', $this->repository->getProducts(15));
    }

    public function search(Request $request)
    {
        $data = $request->only('keyword');
        return $this->sendRes('Products received successfully.', $this->repository->searchProduct($data['keyword']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->all();
        return $this->sendRes('Product created successfully.', $this->repository->addProduct($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->sendRes('Product received successfully.', $this->repository->getProduct($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->sendRes('Product deleted successfully.', $this->repository->deleteProduct($id));
    }
}
