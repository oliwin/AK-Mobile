<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use App\Category;

use App\CategoryTest;

use View;

class CategoryController extends Controller
{

    private $test_id;
    private $category_id;

    public function set(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "category" => 'required|integer|between:1,4',
            "test_id" => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('category')
                ->withErrors($validator)
                ->withInput();
        }

        $this->test_id = $request->test_id;
        $this->category_id = $request->category_id;

        Category::where("test_id", $this->test_id)->update(
            [
                "category_id" => $this->category_id
            ]
        );

        return View::make('cabinet.distributor.category.update');

    }

    public function edit($id)
    {

        $category = CategoryTest::where("test_id", $id)->get()->first();

        return View::make('cabinet.distributor.category.edit', ["category" => $category]);
    }


}
