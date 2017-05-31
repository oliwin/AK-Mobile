<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parameter\Parameter;

use App\Http\Controllers\Parameter\ParameterObject;

use Illuminate\Http\Request;

use View;

use Validator;

use App\Helpers\Helper;

use App\Http\Controllers\Object\Object as ObjectLibrary;

use App\Http\Controllers\Category\Category as CategoryLibrary;

use App\Http\Controllers\Prototype\Prototype as PrototypeLibrary;

use App\Http\Controllers\Object\ObjectModel;



class ObjectController extends Controller
{

    private $categories = [];
    private $prototypes = [];
    private $objects = [];
    private $objectLibrary;

    public function __construct()
    {

        // Categories

        $categories = new CategoryLibrary();
        $categories->all();
        $this->categories = Helper::pluckObject($categories->document(), "_id", "name", "Category");

        // Prototypes

        $prototypes = new PrototypeLibrary();
        $prototypes->all();
        $this->prototypes = $prototypes->document();

        // Objects

        $this->objectLibrary = new ObjectLibrary();
    }

    public function index()
    {

        $this->objects = $this->objectLibrary->all(true);

        return $this->view();
    }

    private function view()
    {

        return View::make('object.index', [
            "objects" => $this->objects,
            "categories" => $this->categories,
            "prototypes" => $this->prototypes,
            "path" => action("ObjectController@create"),
            "search_path" => "/objects/search"
        ]);
    }

    public function search(Request $request)
    {

        $object = SearchController::create(SearchController::OBJECT);

        $search = new SearchController($request, $object);

        $this->objects = $search->done();

        return $this->view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->prototypes = Helper::pluckObject($this->prototypes, "_id", "name", "Prototype", false);

        return View::make('object.create', [
            "prototypes" => $this->prototypes,
            "categories" => $this->categories
        ]);
    }

    public function store(Request $request)
    {
        $objectModel = new ObjectModel();
        $parameterModel = new ParameterObject();

        $parameterModel->fill($request);
        $objectModel->fill($request);

        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prototype_id" => "required|string",
            "category_id" => "required|string",
            "prefix" => "required|string"
        ]);

        if(! $parameterModel->validateValues()){
            return redirect()->back()->withErrors($parameterModel->errors)->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {

            $this->objectLibrary->add($objectModel, $parameterModel);

        } catch (\Exception $e) {

            echo 'Выброшено исключение на строке: ', $e->getLine(), "\n";
            dd();
        }

        return redirect("objects")->with('success', "Object was created!");

    }

    public function edit($id)
    {

        $object = $this->objectLibrary->getOne(array("_id" => new \MongoId($id)));

        $this->prototypes = Helper::pluckObject($this->prototypes, "_id", "name", "Prototype", false);

        /* PARAMETERS */

        $parameters_object = $this->objectLibrary->parameters($object);

        $prototype = new PrototypeLibrary();

        /* Get all fields from prototype */

        $parameters_id = $prototype->getFieldsPrototype($object["prototype_id"]);

        $parameters = new Parameter();

        $parameters = $parameters->getValuesParametersByID($parameters_id);

        return View::make('object.edit', [
            "object" => $object,
            "parameters" => $parameters,
            "prototypes" => $this->prototypes,
            "categories" => $this->categories,
            "parameters_object" => $parameters_object
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "prototype_id" => "required|string",
            "category_id" => "required|string",
            "prefix" => "required|string"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $objectModel = new ObjectModel();

        $parameterObject = new ParameterObject();

        $parameterObject->fill($request);

        $objectModel->fill($request);

        $this->objectLibrary->update(array("_id" => new \MongoId($id)), $objectModel, $parameterObject);

        return redirect("objects")->with('success', "Object was updated!");
    }


    public function cloneObject(Request $request, $id)
    {

        $validator = Validator::make(array_merge(
            [
                'id' => $id
            ],
            $request->all()
        ), [
            "id" => 'required|string'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $this->objectLibrary->cloning($id);

        return redirect()->action(
            'ObjectController@edit', ['id' => $this->objectLibrary->_insertedID()]
        );
    }


    public function filterByPrototype($id)
    {

        $this->objectLibrary->get(array("prototype_id" => $id));

        $this->objects = $this->objectLibrary->document();

        return $this->view();
    }

    public function destroy($id)
    {

        $this->objectLibrary->delete($id);

        return redirect("objects")->with('success', "Object was deleted!");

    }
}
