<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Parameter\Parameter;

use App\Http\Controllers\Prototype\Prototype;

use Illuminate\Http\Request;

use View;

use Validator;

use App\Http\Controllers\Prototype\Prototype as PrototypeLibrary;

use App\Http\Controllers\Parameter\Parameter as ParameterLibrary;

use App\Http\Controllers\Parameter\ParameterModel;

class PrototypeFieldsController extends Controller
{
    private $fields;

    private $prototypeLibrary;

    private $parameterLibrary;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->prototypeLibrary = new PrototypeLibrary();

        $this->parameterLibrary = new ParameterLibrary();
    }


    public function index()
    {

        $this->fields = $this->parameterLibrary->get(array("parent_id" => null));

        return $this->view();
    }

    private function view()
    {

        return View::make('field.index', [
            "fields" => $this->fields,
            "path" => action("PrototypeFieldsController@create"),
            "search_path" => "/fields/search",
            "types" => true
        ]);
    }

    public function create()
    {

        return View::make('field.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "default" => "string|required_without:type",
            "only_numbers" => "integer|nullable",
            "available" => "integer|nullable",
            "type" => "required|integer",
            "prefix" => "required|string",
            "type_value" => "string|nullable"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {

            $parameterModel = new ParameterModel();

            $parameterModel->fill($request);

            $this->parameterLibrary->add($parameterModel);

        } catch (\Exception $e) {

            echo 'Выброшено исключение: ', $e->getMessage();
            dd();
        }

        return redirect("fields")->with('success', "Field was created!");
    }

    public function edit($id)
    {
        $parameter = $this->parameterLibrary->getOne(array("_id" => new \MongoId($id)));
        
        $parameters_all = $this->parameterLibrary->get();

        return View::make('field.edit', [
            "field" => $parameter,
            "all" => $parameters_all
        ]);
    }

    public function search(Request $request)
    {

        $parameters = SearchController::create(SearchController::PARAMETER);

        $search = new SearchController($request, $parameters);

        $this->fields = $search->done();

        return $this->view();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "only_numbers" => "integer|nullable",
            "available" => "integer|nullable",
            "prototype_id.*" => "nullable",
            "default" => "required|string",
            "prefix" => "required|string",
            "type" => "required|integer",
            "field_array.*" => "string"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $parametersModel = new ParameterModel();

        $parametersModel->fill($request);

        $this->parameterLibrary->update(array("_id" => new \MongoId($id)), $parametersModel);

        return redirect("fields")->with('success', "Prototype field was updated!");
    }

    public function fields($type)
    {

        switch ($type) {

            case "2":
                return view('field.list', ['fields' => $this->parameterLibrary->get()]);
                break;

            case "6":
                return view('field.array_objects', ['fields' => $this->parameterLibrary->get(["type_value" => "object"])]);
                break;

            case "3":
                return view('field.list_array');
                break;

            case "4":
                return view('field.list_boolean');
                break;

            case "5":
                return view('field.list_vector');
                break;
        }
    }


    public function fieldsBYID($id)
    {

        $prototype = new Prototype();

        $parameters_id = $prototype->getFieldsPrototype($id);

        /* Get values of parameters */

        $parameters = new Parameter();

        $parameters = $parameters->getValuesParametersByID($parameters_id);
        
        return View::make('object.parameters', ["parameters" => $parameters]);

    }


    public function destroy($id)
    {

        $this->parameterLibrary->delete($id);

        return redirect("fields")->with('success', "Parameter was deleted!");
    }

}
