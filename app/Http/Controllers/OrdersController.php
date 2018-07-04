<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->repository = $ordersRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendRes('Orders received successfully.',
            $this->repository->getOrders($request->query('limit', 10)));
    }

    public function all(Request $request)
    {
        return $this->sendRes('All orders received successfully.', $this->repository->getAllOrders($request->query('limit', 10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->all();
        return $this->sendRes('Order created successfully.', $this->repository->addOrder($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($hash)
    {
        return $this->sendRes('Order recived successfully.', $this->repository->getOrder($hash));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateOrderRequest $request)
    {
        return $this->sendRes('Order updated successfully.', $this->repository->updateOrder($id, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
