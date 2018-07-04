<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends Controller
{
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->repository = $categoriesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendRes('Categories received successfully.', $this->repository->getCategories());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $data = $request->all();
        return $this->sendRes('Category created successfully.', $this->repository->addCategory($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return $this->sendRes('Products category received successfully.', $this->repository->getCategory($slug));
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
        return $this->sendRes('Category deleted successfully.', $this->repository->deleteCategory($id));
    }
}
