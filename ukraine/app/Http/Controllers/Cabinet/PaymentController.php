<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use View;

use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        return View::make('cabinet.distributor.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('dashboard.category.create');
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
            "name" => 'required|string|min:3|max:50',
            "description" => 'required|string|max:150',
            "status" => 'integer',
            "icon.*" => "required"
        ]);

        if ($validator->fails()) {
            return redirect('category/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Upload files
        if(UploadFiles::initUpload("icon", "category") == FALSE){
            return back()->withInput()->withErrors($validator);
        }

        $order = new ObjectType();
        $order->name = $request->name;
        $order->description = $request->description;
        $order->status = $request->status;
        $order->icon = UploadFiles::oneImage();
        $order->save();

        return redirect('category')->with('flash_message', 'Category was added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ObjectType::where('id', $id);
        return View::make('dashboard.category.full', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO
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
        $category = ObjectType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:3|max:50',
            "description" => 'required|string|max:150',
            "status" => 'integer'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $category->fill($input)->save();

        return redirect('category')->with('flash_message', 'Category was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ObjectType::find($id);
        $category->delete();

        return redirect('category');
    }
}
