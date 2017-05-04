<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Object;

use App\Prototype;

use View;

use Validator;

class ObjectController extends Controller
{

  private $limit = 20;

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

      $objects = Object::where(function ($query) use ($request) {

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

      return View::make('object.index', [
          "objects" => $objects,
          "path" => action("ObjectController@create")
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
          "prototypes" => $this->prototypes(["visibility" => 1])
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
         "visibility" => "required|integer"
     ]);

     if ($validator->fails()) {
         return redirect()->back()->withErrors($validator->errors());
     }

     $object = new Object();
     $object->name = $request->name;
     $object->prefix = $request->prefix;
     $object->visibility = $request->visibility;
     $object->available = (!is_null($request->available)) ? $request->available : 0;
     $object->save();

     // To bind ptototypes to object
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
      $object = Object::with("prototypes")->findOrFail($id);

      $prototypes_with_checkes = $prototypes->map(function ($item, $key) use ($object) {
        $object->prototypes->each(function ($v, $k) use ($item) {
          $item->checked = ($item->id == $v->id) ? true : false;
        });

        return $item;
      });

      return View::make('object.edit', [
          "object" => $object,
          "prototypes" => $prototypes_with_checkes
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
         "prototype_id.*" => "integer",
         "visibility" => "required|integer"
     ]);

      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator->errors());
      }

      Object::with("prototypes")->where("id", $id)->update([
          "name" => $request->name,
          "available" => (!is_null($request->available)) ? $request->available : 0,
          "prefix" => $request->prefix,
          "visibility" => $request->visibility
      ]);

      // Update object prototypes
      $object = Object::with("prototypes")->findOrFail($id);

      if(is_null($request->prototype_id)){
        $object->prototypes()->detach();

      } else {

        $selected_ptototypes = $object->prototypes()->get()->pluck("name", "id");
        $selected_ptototypes_edit = $selected_ptototypes;

        foreach($request->prototype_id as $k => $v){

          // If value is not in Model

          if(!in_array($v, $selected_ptototypes)){
            $object->prototypes()->attach($v);

          } else {

            // If value in Model, delete it
            unset($selected_ptototypes_edit[$k]);
          }
        }

        // Detach elements if exists
        $object->prototypes()->detach($selected_ptototypes_edit);

      }

      return redirect("objects")->with('success', "Object was updated!");
    }

    public function filterByPrototype($prototype_id)
    {

      $objects = Object::with("prototypes")->paginate(100);

      return View::make('object.index', [
          "objects" => $objects,
          "path" => action("ObjectController@create")
      ]);

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
