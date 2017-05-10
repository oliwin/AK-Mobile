<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PrototypeFields;

use App\FieldsInPrototype;

use App\Prototype;

use View;

use Validator;

class PrototypeFieldsController extends Controller
{

  private $limit = 20;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private function prototypes(){
         return Prototype::get()->pluck("name", "id");
     }


    public function index(Request $request)
    {

      $fields = PrototypeFields::with("prototype.name")->where(function ($query) use ($request) {

        // Filter by ID
        if (($request->get("id"))) {
            $query->where('id', $request->id);
        }


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

      return View::make('field.index', [
          "fields" => $fields,
          "path" => action("PrototypeFieldsController@create")
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $prototypes = Prototype::all();

      return View::make('field.create', [
          "prototypes" => $this->prototypes()
      ]);
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
         "default" => "required|string",
         "only_numbers" => "integer|nullable",
         "available" => "integer|nullable",
         "prefix" => "required|string|min:1",
         "prototype_id.*" => "integer|nullable",
         "visibility" => "required|integer"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     $field = new PrototypeFields();
     $field->name = $request->name;
     $field->prefix = $request->prefix;
     $field->only_numbers = (!is_null($request->only_numbers)) ? $request->only_numbers : 0;
     $field->available = (!is_null($request->available)) ? $request->available : 0;
     $field->visibility = $request->visibility;
     $field->default = $request->default;
     $field->save();

     // Attach fields to prototypes
     if ($request->has('prototype_id')) {
       foreach($request->prototype_id as $k => $v){
         $fields_prototype = new FieldsInPrototype();
         $fields_prototype->field_id = $field->id;
         $fields_prototype->prototype_id = $v;
         $fields_prototype->save();
       }
     }

     return redirect("fields")->with('success', "Field was created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $prototypes = Prototype::all();
      $field = PrototypeFields::with("prototypes")->findOrFail($id);

      $prototypes_with_checkes = $prototypes->map(function ($item, $key) use ($field) {
          $item->checked = $field->prototypes->contains("prototype_id", $item->id);
          return $item;
      });

      return View::make('field.edit', [
          "prototypes" => $prototypes_with_checkes,
          "field" => $field
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
        "only_numbers" => "integer|nullable",
        "available" => "integer|nullable",
        "prefix" => "required|string|min:1",
        "prototype_id.*" => "nullable",
        "default" => "required|string",
        "visibility" => "required|integer"
     ]);

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator->errors());
      }

      $field = PrototypeFields::where("id", $id)->update([
          "name" => $request->name,
          "only_numbers" => (!is_null($request->only_numbers)) ? $request->only_numbers : 0,
          "available" => (!is_null($request->available)) ? $request->available : 0,
          "prefix" => $request->prefix,
          "visibility" => $request->visibility,
          "default" => $request->default
      ]);

      // Attach fields to prototypes
      if ($request->has('prototype_id')) {
        foreach($request->prototype_id as $k => $v){
          if(is_null($v)){

            if($this->checkIfPrototypeExistsInField($k, $id)){
               FieldsInPrototype::where("prototype_id", $k)->where("field_id", $id)->delete();
            }

          } else {
            if(!$this->checkIfPrototypeExistsInField($v, $id)){
               FieldsInPrototype::insert(["prototype_id" => $v, "field_id" => $id]);
            }
          }
        }
      }

      return redirect("fields")->with('success', "Prototype field was updated!");
    }

    private function checkIfPrototypeExistsInField($prototype_id, $field_id){
      $rows = FieldsInPrototype::where("prototype_id", $prototype_id)->where("field_id", $field_id)->get()->count();
      return ($rows > 0 ) ? true : false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      PrototypeFields::destroy($id);

      return redirect("fields")->with('success', "Field was deleted!");
    }
}
