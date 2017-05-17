<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use App\Prototype;

use App\PrototypeFields;

use App\FieldsInPrototype;

use App\ObjectPrototypeFields;

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
                $status = ($request->available == 2) ? 0 : $request->available;
                $query->where('available', $status);
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

    private function prototypeFields()
    {
        return prototypeFields::visibility(["visibility" => 1])->get()->pluck("name", "id");
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

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prefix" => "required|string|min:1",
            //"visibility" => "required|integer"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $field = new Prototype();
        $field->name = $request->name;
        $field->prefix = $request->prefix;
        $field->visibility = $request->visibility;
        $field->available = (!is_null($request->available)) ? $request->available : 0;
        $field->save();

        // Attach fields to prototypes
        if ($request->has('field_id')) {
            foreach ($request->field_id as $k => $v) {
                $fields_prototype = new FieldsInPrototype();
                $fields_prototype->field_id = $v;
                $fields_prototype->prototype_id = $field->id;
                $fields_prototype->save();
            }
        }

        return redirect("prototypes")->with('success', "Prototype was created!");
    }


    public function edit($id)
    {


        $prototype = Prototype::with("fields")->find($id);
        $fields = prototypeFields::visibility(["visibility" => 1])->get();

        $fields_with_checkes = $fields->map(function ($item) use ($prototype) {
            $item->checked = $prototype->fields->contains("field_id", $item->id);
            return $item;
        });

        return View::make('prototype.edit', [
            "prototype" => $prototype,
            "prototype_fields" => $fields_with_checkes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    private function checkIfPrototypeExistsInObject($id, $object)
    {
        foreach ($object->fields as $k => $v) {
            if ($v->field_id == $id) {
                return true;
            }
        }

        return false;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prefix" => "required|string|min:1",
            //"visibility" => "required|integer",
            "field_id.*" => "integer|nullable"
            //"value" => "string",
            //"default" => "required|string"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        Prototype::where("id", $id)->update([
            "name" => $request->name,
            "prefix" => $request->prefix,
            "visibility" => $request->visibility,
            "available" => (!is_null($request->available)) ? $request->available : 0
        ]);

        $object = Prototype::with("fields")->findOrFail($id);

        if ($request->has('field_id')) {
            foreach ($request->field_id as $k => $v) {

                if (is_null($v)) {
                    if ($this->checkIfPrototypeExistsInObject($k, $object)) {
                        FieldsInPrototype::where("prototype_id", $id)->where("field_id", $k)->delete();
                    }

                } else {

                    if (!$this->checkIfPrototypeExistsInObject($k, $object)) {
                        FieldsInPrototype::create(["prototype_id" => $id, "field_id" => $k]);

                    }
                }
            }
        }

        return redirect("prototypes")->with('success', "Prototype was updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Prototype::destroy($id);

        ObjectPrototypeFields::where("prototype_id", $id)->delete();

        FieldsInPrototype::where("prototype_id", $id)->delete();

        return redirect("prototypes")->with('success', "Prototype was deleted!");
    }
}
