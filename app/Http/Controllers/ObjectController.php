<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Object;

use App\Prototype;

use App\FieldCategories;

use App\FieldCategoriesValues;

use View;

use Validator;

use App\Helpers\Helper;

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

      $objects = Object::with("prototypes", "category")->where(function ($query) use ($request) {

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
         "prototype_id.*" => "integer",
         "visibility" => "required|integer",
         "category_id" => "required|integer"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     $object = new Object();
     $object->name = $request->name;
     $object->prefix = $request->prefix;
     $object->visibility = $request->visibility;
     $object->category_id = $request->category_id;
     $object->available = (!is_null($request->available)) ? $request->available : 0;
     $object->save();
     $object->prototypes()->attach($request->prototype_id);

     return redirect("objects")->with('success', "Object was created!");

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

      $prototypes_with_checkes = $prototypes->map(function ($item, $key) use ($object) {
          $item->checked = $object->prototypes->contains("id", $item->id);
          return $item;
      });

      return View::make('object.edit', [
          "object" => $object,
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
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [

         "name" => "required|string|min:3",
         "available" => "integer|nullable",
         "prefix" => "required|string|min:1",
         "prototype_id.*" => "nullable",
         "visibility" => "required|integer",
         "category_id" => "required|integer"
     ]);

     //dd($request->all());

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator->errors());
      }

      Object::with("prototypes")->where("id", $id)->update([
          "name" => $request->name,
          "available" => (!is_null($request->available)) ? $request->available : 0,
          "prefix" => $request->prefix,
          "visibility" => $request->visibility,
          "category_id" => $request->category_id
      ]);

      // Update object prototypes
      $object = Object::with("prototypes")->findOrFail($id);

      if ($request->has('prototype_id')) {
        foreach($request->prototype_id as $k => $v){

          if(is_null($v)){
            if($this->checkIfPrototypeExistsInObject($k, $object)){
              $object->prototypes()->detach($k);
            }

          } else {
            if(!$this->checkIfPrototypeExistsInObject($k, $object)){
              $object->prototypes()->attach($v);
            }
          }
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

       // Copy prototypes object
       $prototypes_ids = [];
       $prototypes_ids = $object->prototypes()->pluck("prototype_id")->toArray();
       $new_object->prototypes()->attach($prototypes_ids);

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
