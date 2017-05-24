<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use Validator;

use App\Http\Controllers\Category\Category as CategoryLibrary;

use App\Http\Controllers\Category\CategoryModel;

class CategoryController extends Controller
{

    private $categoryLibrary;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->categoryLibrary = new CategoryLibrary();
    }

    public function index()
    {

        $this->categoryLibrary->all();

        $categories = $this->categoryLibrary->document();

        return View::make('category.index', [
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return View::make('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:3"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {

            $categoryModel = new CategoryModel();
            $categoryModel->fill($request);

            $this->categoryLibrary->add($categoryModel);

        } catch (\Exception $e) {

            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
            dd();
        }

        return redirect("categories")->with('success', "Category was created!");
    }


    public function edit($id)
    {

        $category = $this->categoryLibrary->getOne(array("_id" => new \MongoId($id)));

        return View::make('category.edit', [
            "category" => $category
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:3"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $this->categoryLibrary->update(array("_id" => new \MongoId($id)), array("name" => $request->name));

        return redirect("categories")->with('success', "Category was updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->categoryLibrary->delete($id);

        return redirect("categories")->with('success', "Category was deleted!");
    }
}
