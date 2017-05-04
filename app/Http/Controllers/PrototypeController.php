<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use App\Prototype;

use App\PrototypeFields;

use Validator;

class PrototypeController extends Controller
{

  private $limit = 20;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $prototypes = Prototype::where(function ($query) use ($request) {

            // Filter by name
            if (($name = $request->get("name"))) {
                $query->where('name', 'like', '%' . $name . '%');
                $query->orWhere('prefix', 'like', '%' . $name . '%');
            }

            // Filter by status
            if (($request->get("available"))) {
                $query->where('available', $request->status);
            }

            // Show by
            if (($request->get("limit"))) {
                $this->limit = $request->limit;
            }

        })->orderBy('id', 'desc')->paginate($this->limit);

      return View::make('prototype.index', [
          "prototypes" => $prototypes,
          "path" => action("PrototypeController@create")
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      //echo "asd"; die();

      return View::make('prototype.create', [
          "prototype_fields" => $this->prototypeFields(["visibility" => 1])
      ]);
    }

    private function prototypes(){
        return Prototype::get()->pluck("name", "id");
    }

    private function prototypeFields(){
      return prototypeFields::visibility(["visibility" => 1])->get()->pluck("name", "id");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [

         "name" => "required|string|min:3",
         "available" => "integer|nullable",
         "type" => "required|integer",
         "prefix" => "required|string|min:1",
         "visibility" => "required|integer",
         "value" => "string",
         "default" => "required|string"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     $field = new Prototype();
     $field->name = $request->name;
     $field->prefix = $request->prefix;
     $field->default = $request->default;
     $field->value = $request->value;
     $field->visibility = $request->visibility;
     $field->type = (!is_null($request->type)) ? $request->type : 0;
     $field->available = (!is_null($request->available)) ? $request->available : 0;
     $field->save();

     return redirect("prototypes")->with('success', "Prototype was created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $prototype = Prototype::find($id);

      return View::make('prototype.edit', [
          "prototype" => $prototype,
          "prototype_fields" => $this->prototypeFields()
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [

         "name" => "required|string|min:3",
         "available" => "integer|nullable",
         "type" => "required|integer",
         "prefix" => "required|string|min:1",
         "visibility" => "required|integer",
         "value" => "string",
         "default" => "required|string"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     Prototype::where("id", $id)->update([
       "name" => $request->name,
       "prefix" => $request->prefix,
       "default" => $request->default,
       "value" => $request->value,
       "visibility" => $request->visibility,
       "type" => (!is_null($request->type)) ? $request->type : 0,
       "available" => (!is_null($request->available)) ? $request->available : 0
     ]);

     return redirect("prototypes")->with('success', "Prototype was updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Prototype::destroy($id);

      return redirect("prototypes")->with('success', "Prototype was deleted!");
    }
}
