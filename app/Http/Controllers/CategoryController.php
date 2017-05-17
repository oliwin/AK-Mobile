<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use App\FieldCategories;

use Validator;

class CategoryController extends Controller
{

    private $limit = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = FieldCategories::orderBy('id', 'desc')->paginate($this->limit);

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

        $category = new FieldCategories();
        $category->name = $request->name;
        $category->save();

        return redirect("categories")->with('success', "Category was created!");
    }


    public function edit($id)
    {

        $category = FieldCategories::find($id);

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

        FieldCategories::where("id", $id)->update([
            "name" => $request->name
        ]);

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
        FieldCategories::destroy($id);

        return redirect("categories")->with('success', "Category was deleted!");
    }
}
