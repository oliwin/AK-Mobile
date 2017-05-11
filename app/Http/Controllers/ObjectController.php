<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Object;

use App\Prototype;

use App\FieldCategories;

use App\FieldCategoriesValues;

use App\ObjectPrototypeFields;

use View;

use Validator;

use App\Helpers\Helper;

use App\FieldsInPrototype;

use App\PrototypeFields;

class ObjectController extends Controller
{

  private $limit = 20;
  private $field_categories = [];
  private $prototypes = [];

  public function __construct(){

    $this->field_categories = Helper::pluckObject(FieldCategories::all(), "id", "name");
    $this->prototypes =  Helper::pluckObject(Prototype::all(), "id", "name", "Select prototype");
  }

  private function prototypes($params = array()){
      return Prototype::visibility($params)->get()->pluck("name", "id");
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $objects = Object::with("category", "prototypes")->where(function ($query) use ($request) {

            // Filter by name
            if (($name = $request->get("name"))) {
                $query->where('name', 'like', '%' . $name . '%');
                $query->orWhere('prefix', 'like', '%' . $name . '%');
            }

            // Filter by status
            if (($request->get("available"))) {
                $query->where('available', $request->status);
            }

            // Filter by ID
            if (($request->get("id"))) {
                $query->where('id', $request->id);
            }

            // Filter by category
            if (($request->get("category"))) {
                $query->where('category_id', $request->category);
            }

            // Filter by prototype
            if (($request->get("prototype"))) {
              $query ->whereHas('prototypes', function ($query) use ($request) {
                $query->where('prototype_id', $request->prototype);
              });
            }

            // Show by
            if (($request->get("limit"))) {
                $this->limit = $request->limit;
            }

            // Filter by fields in prototypes
            if($request->get("fields")){
              // TODO
            }


        })->orderBy('id', 'desc')->paginate($this->limit);

      return View::make('object.index', [
          "objects" => $objects,
          "path" => action("ObjectController@create"),
          "categories" => $this->field_categories,
          "prototypes_list" => $this->prototypes
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      return View::make('object.create', [
          "prototypes" => $this->prototypes(["visibility" => 1]),
          "categories" => $this->field_categories
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
         "available" => "integer|nullable",
         "prefix" => "required|string|min:1",
         "prototype_id" => "integer",
         "visibility" => "required|integer",
         "category_id" => "required|integer",
         "fields.*" => "nullable"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     $object = new Object();
     $object->name = $request->name;
     $object->prefix = $request->prefix;
     $object->visibility = $request->visibility;
     $object->category_id = $request->category_id;
     $object->prototype_id = $request->prototype_id;
     $object->available = (!is_null($request->available)) ? $request->available : 0;
     $object->save();

     // Get all prototype fields
     $fields_prototype = FieldsInPrototype::with("field_details")->where("prototype_id", $request->prototype_id)->get();

     foreach($fields_prototype as $k => $v){
       ObjectPrototypeFields::insert([
         "prototype_id" => $v->prototype_id,
         "object_id" => $object->id,
         "field_id" => $v->field_id
       ]);
     }

     // Update fields values in prototype
     if($request->has("fields")){
        foreach($request->fields as $field_id => $v){

          if(!Helper::validateFiled($v, $this->_getFieldType($field_id))){
            $message = "The filed ".$v." should be contain only number forat";
            return redirect()->back()->withErrors([$message]);
          }

          ObjectPrototypeFields::where("object_id", $object->id)->where("field_id", $field_id)->update([
            "value" => $v
          ]);

        }
     }

     return redirect("objects")->with('success', "Object was created!");

    }

    private function _getFieldType($field_id){
          $collection_fields = PrototypeFields::all();
          return $collection_fields->where("id", $field_id)->first()->only_numbers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $object = Object::with("prototypes")->findOrFail($id);

      return View::make('object.show', [
          "prototypes" => $this->prototypes(),
          "object" => $object
      ]);
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
      $object = Object::with("prototypes", "category")->findOrFail($id);
      $fields = ObjectPrototypeFields::with("name")->where("object_id", $id)->where("prototype_id", $object->prototype_id)->get();

      $multiplied = $fields->map(function ($item, $key) {
          if(is_null($item->value) || empty($item->value)){
            $item->value = $item->name->default;
          }

          return $item;
      });

      $prototypes_with_checkes = $prototypes->map(function ($item, $key) use ($object) {
          $item->checked = ($item->id == $object->prototype_id) ? true : false;
          return $item;
      });

      return View::make('object.edit', [
          "object" => $object,
          "fields" => $fields,
          "prototypes" => $prototypes_with_checkes,
          "categories" => $this->field_categories
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     private function isExistsPrototype($prototype_id, $object_id){
         $fields = ObjectPrototypeFields::where("prototype_id", $prototype_id)->where("object_id", $object_id)->get();
         
         return $fields->contains('prototype_id', $prototype_id);

     }

     private function updatePrototypeFieldsInobject($request, $id){

       if($request->has("fields")){
          foreach($request->fields as $field_id => $value){

            if(!Helper::validateFiled($value, $this->_getFieldType($field_id))){
              $message = "The filed ".$value." should be contain only number forat";
              return redirect()->back()->withErrors([$message]);
            }

            ObjectPrototypeFields::where("object_id", $id)->where("field_id", $field_id)->update([
              "value" => $value
            ]);
          }
       }

     }

    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [

         "name" => "required|string|min:3",
         "available" => "integer|nullable",
         "prefix" => "required|string|min:1",
         "prototype_id" => "nullable",
         "visibility" => "required|integer",
         "category_id" => "required|integer",
         "fields.*" => "nullable"
     ]);

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator->errors());
      }

      Object::with("prototypes")->where("id", $id)->update([
          "name" => $request->name,
          "available" => (!is_null($request->available)) ? $request->available : 0,
          "prefix" => $request->prefix,
          "visibility" => $request->visibility,
          "category_id" => $request->category_id,
          "prototype_id" => $request->prototype_id
      ]);

      if($this->isExistsPrototype($request->prototype_id, $id)){
            $this->updatePrototypeFieldsInobject($request, $id);

      } else {

        // Delete old data from previous Prototype
        ObjectPrototypeFields::where("object_id", $id)->delete();

        // Add new fields that are required in Prototype
        $fields_prototype = FieldsInPrototype::where("prototype_id", $request->prototype_id)->get();

        foreach($fields_prototype as $k => $v){

          if(!Helper::validateFiled($request->fields[$v->field_id], $this->_getFieldType($field_id))){
            $message = "The filed ".$request->fields[$v->field_id]." should be contain only number forat";
            return redirect()->back()->withErrors([$message]);
          }

          ObjectPrototypeFields::insert([
            "prototype_id" => $v->prototype_id,
            "object_id" => $id,
            "field_id" => $v->field_id,
            "value" => $request->fields[$v->field_id]
          ]);
        }

      }

      return redirect("objects")->with('success', "Object was updated!");
    }

    private function checkIfPrototypeExistsInObject($id, $object){
      foreach($object->prototypes as $k => $v){
         if($v->pivot->prototype_id == $id){
           return true;
         }
      }

      return false;
    }

    public function filterByPrototype($prototype_id)
    {

      $objects = Object::with('prototypes')
        ->WhereHas('prototypes', function ($query) use ($prototype_id) {
            $query->where('prototype_id', $prototype_id);
        })->paginate($this->limit);

      return View::make('object.index', [
          "objects" => $objects,
          "path" => action("ObjectController@create")
      ]);

    }

    public function cloneObject(Request $request, $id){

      $validator = Validator::make(array_merge(
            [
                'id' => $id
            ],
            $request->all()
        ), [
            "id" => 'required|integer'
        ]);


      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator->errors());
      }

      // Get requisted object
      $object = Object::findOrFail($id);

      // Create new object except unique fields
      $object_copied = collect($object)->except('id', 'prefix', 'prototypes')->all();

      // Copy object
      $new_object = Object::create(
         $object_copied
      );

      return redirect()->action(
            'ObjectController@edit', ['id' => $new_object->id]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Object::destroy($id);

      return redirect("objects")->with('success', "Object was deleted!");

    }
}
