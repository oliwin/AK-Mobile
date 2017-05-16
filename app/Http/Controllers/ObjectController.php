<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Object;

use App\Prototype;

use App\FieldCategories;

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

    public function __construct()
    {

        $this->field_categories = Helper::pluckObject(FieldCategories::all(), "id", "name", "Category", "name");
        $this->prototypes = Helper::pluckObject(Prototype::all(), "id", "name", "  Prototype", "name");
    }

    private function prototypes($params = array())
    {
        //visibility($params)
        return Prototype::get()->pluck("name", "id");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $objects = Object::with("prototypes")->where(function ($query) use ($request) {

            // Filter by name
            if (($name = $request->get("name"))) {
                $query->where('name', 'like', '%' . $name . '%');
                $query->orWhere('prefix', 'like', '%' . $name . '%');
            }

            // Filter by status
            if (($request->get("available"))) {
                $status = ($request->status == 2) ? 0 : $request->get("available");
                $query->where('available', $status);
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
                $query->whereHas('prototypes', function ($query) use ($request) {
                    $query->where('prototype_id', $request->prototype);
                });
            }

            // Show by
            if (($request->get("limit"))) {
                $this->limit = $request->limit;
            }

            // Filter by fields in prototypes
            if ($request->get("fields")) {
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prefix" => "required|string|min:1",
            "prototype_id" => "required|integer",
            "visibility" => "integer",
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

        if ($request->has("fields")) {

            foreach ($request->fields as $field_id => $v) {
                if (!Helper::validateFiled($v, $this->_getFieldType($field_id))) {
                    $message = "The filed " . $v . " should be contain only number forat";
                    return redirect()->back()->withErrors([$message]);
                }

                $data[] = [
                    "value" => $v,
                    "object_id" => $object->id,
                    "field_id" => $field_id,
                    "prototype_id" => $object->prototype_id
                ];
            }

            ObjectPrototypeFields::insert($data);
        }

        return redirect("objects")->with('success', "Object was created!");

    }


    private function _getFieldType($field_id)
    {
        $collection_fields = PrototypeFields::all();
        return $collection_fields->where("id", $field_id)->first()->only_numbers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    private function fieldsObjectPrototype($object_id, $prototype_id)
    {
        return ObjectPrototypeFields::with("name")->where("object_id", $object_id)->where("prototype_id", $prototype_id)->get();
    }

    private function fieldsObjectValues($object)
    {
        $fields_with_value = $this->fieldsObjectPrototype($object->id, $object->prototype_id)->pluck("value", "field_id");
        $fields_with_default_value = $this->getFieldsByPrototype($object->prototype_id);

        $multiplied = $fields_with_default_value->map(function ($item) use ($fields_with_value) {

            $item->children = $item->field_details->children;

            if (isset($fields_with_value[$item->field_id]) && !empty($fields_with_value[$item->field_id])) {
                $item->field_details->default = $fields_with_value[$item->field_id];
            }

            return $item;
        });

        return $multiplied;


    }

    private function getFieldsByPrototype($prototype_id)
    {
        return FieldsInPrototype::with("field_details.children.name")->where("prototype_id", $prototype_id)->get();
    }

    public function edit($id)
    {

        $prototypes = Prototype::all();
        $object = Object::with("prototypes")->findOrFail($id);
        $fields = $this->fieldsObjectValues($object);

        $prototypes_with_checkes = $prototypes->map(function ($item) use ($object) {
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    private function updatePrototypeFieldsInobject($request, $id)
    {

        if ($request->has("fields")) {

            ObjectPrototypeFields::where("object_id", $id)->delete();

            foreach ($request->fields as $field_id => $value) {

                $data[] = [
                    "object_id" => $id,
                    "field_id" => $field_id,
                    "prototype_id" => $request->prototype_id,
                    "value" => $value
                ];
            }

            ObjectPrototypeFields::insert($data);
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prefix" => "required|string|min:1",
            "prototype_id" => "required|integer",
            "visibility" => "integer",
            "category_id" => "required|integer",
            "fields.*" => "nullable"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        Object::with("prototypes")->where("id", $id)->update([
            "name" => $request->name,
            "prefix" => $request->prefix,
            "visibility" => $request->visibility,
            "category_id" => $request->category_id,
            "prototype_id" => $request->prototype_id,
            "available" => (!is_null($request->available)) ? $request->available : 0
        ]);

        $this->updatePrototypeFieldsInobject($request, $id);

        return redirect("objects")->with('success', "Object was updated!");
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

    public function cloneObject(Request $request, $id)
    {

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Object::destroy($id);

        ObjectPrototypeFields::where("object_id", $id)->delete();

        return redirect("objects")->with('success', "Object was deleted!");

    }
}
