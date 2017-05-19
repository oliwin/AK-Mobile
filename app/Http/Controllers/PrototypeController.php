<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use Validator;

use App\Http\Controllers\Prototype\Prototype as PrototypeLibrary;

use App\Http\Controllers\Parameter\Parameter as ParameterLibrary;

use App\Http\Controllers\Prototype\PrototypeModel;


class PrototypeController extends Controller
{

    private $prototypeLibrary;

    private $parameterLibrary;

    private $prototypes;

    private $fields;


    public function __construct()
    {
        $this->prototypeLibrary = new PrototypeLibrary();
        $this->prototypeLibrary->all();
        $this->prototypes = $this->prototypeLibrary->document();

        $this->parameterLibrary = new ParameterLibrary();
        $this->parameterLibrary->all();
        $this->fields = $this->parameterLibrary->document();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->view();
    }

    public function search(Request $request)
    {

        $prototypes = SearchController::create(SearchController::PROTOTYPE);

        $search = new SearchController($request, $prototypes);

        $this->prototypes = $search->done();

        return $this->view();
    }

    private function view()
    {

        return View::make('prototype.index', [
            "prototypes" => $this->prototypes,
            "path" => action("PrototypeController@create"),
            "search_path" => "/prototypes/search"
        ]);
    }

    public function create()
    {

        return View::make('prototype.create', [
            "fields" => $this->fields
        ]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {

            $prototypeModel = new PrototypeModel();
            $prototypeModel->fill($request);
            
            $this->prototypeLibrary->prepare($prototypeModel->data());
            $this->prototypeLibrary->add();

        } catch (\Exception $e) {

            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
            dd();
        }

        return redirect("prototypes")->with('success', "Prototype was created!");
    }


    public function edit($id)
    {

        $prototype = $this->prototypeLibrary->getOne(array("_id" => new \MongoId($id)));

        return View::make('prototype.edit', [
            "prototype" => $prototype,
            "fields" => $this->fields
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            "name" => "required|string|min:3",
            "available" => "integer|nullable",
            "field_id.*" => "integer|nullable"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $prototypeModel = new PrototypeModel();
        $prototypeModel->fill($request);

        $this->prototypeLibrary->prepare($prototypeModel->data());
        $data = $this->prototypeLibrary->document();
        $this->prototypeLibrary->update(array("_id" => new \MongoId($id)), $data);

        return redirect("prototypes")->with('success', "Prototype was updated!");
    }
    
    public function destroy($id)
    {
        $this->prototypeLibrary->delete($id);

        return redirect("prototypes")->with('success', "Prototype was deleted!");
    }
}
