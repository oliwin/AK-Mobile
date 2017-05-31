<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use View;

use App\Client;

use App\Work;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $title;

    private function _title($status){

        if($status == 1){
            $this->title = "Не обследованных";
        }

        if($status == 2){
            $this->title = "Без заключения";
        }

        if($status == 3){
            $this->title = "С заключением";
        }

        if($status == 4){
            $this->title = "Все";
        }

    }

    public function index(Request $request)
    {

        $status = Input::get('status');
        $typeWork = Work::orderBy('id')->get()->pluck('name', 'id');

        $work_types = $typeWork->map(function ($item, $key) {
            return $key." - ".$item;
        });

        $clients = Client::with("types", "results", "transaction")->where(function ($query) use ($request) {

            if (($term = $request->get("name"))) {
                $query->where('name', 'like', '%' . $term . '%');
                $query->orWhere('secondname', 'like', '%' . $term . '%');
                $query->orWhere('patronymic', 'like', '%' . $term . '%');
            }

            if (($request->get("code"))) {
                $query->where('unique_code', $request->code);
            }

            if (($request->get("group"))) {
                $query->where('group_r', $request->group);
            }

            if (($request->get("factory"))) {
                $query->where('factory_name', 'like', '%' . $request->factory . '%');
            }

            if (($request->get("profession"))) {
                $query->where('profession', 'like', '%' . $request->profession . '%');
            }

            if (($request->get("status"))) {
                $this->_title($request->status);

                if($request->status !== '4') {
                    $query->where('status', $request->status);
                }
            }

            if (($request->get("type_work"))) {
                $query->where('type_work', $request->type_work);
            }

            if (($request->get("date"))) {
                $query->whereDate('created_at', '=', $request->date);
            }

        })->with("results.transaction")->orderBy('id', 'desc')->paginate(100);


        return View::make('cabinet.distributor.statistic.index', ["clients" => $clients, "status" => $status, "title" => $this->title, "work_types" => $work_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('dashboard.category.create');
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
            "name" => 'required|string|min:3|max:50',
            "description" => 'required|string|max:150',
            "status" => 'integer',
            "icon.*" => "required"
        ]);

        if ($validator->fails()) {
            return redirect('category/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Upload files
        if (UploadFiles::initUpload("icon", "category") == FALSE) {
            return back()->withInput()->withErrors($validator);
        }

        $order = new ObjectType();
        $order->name = $request->name;
        $order->description = $request->description;
        $order->status = $request->status;
        $order->icon = UploadFiles::oneImage();
        $order->save();

        return redirect('category')->with('flash_message', 'Category was added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ObjectType::where('id', $id);
        return View::make('dashboard.category.full', ['category' => $category]);
    }

    public function getIDN(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "idn" => 'required|integer',

        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $client = Client::where("unique_code", $request->idn)->get()->first();
        $client->datebirth = date("j-n-Y", strtotime($client->datebirth));

        return response()
            ->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ObjectType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:3|max:50',
            "description" => 'required|string|max:150',
            "status" => 'integer'
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $category->fill($input)->save();

        return redirect('category')->with('flash_message', 'Category was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ObjectType::find($id);
        $category->delete();

        return redirect('category');
    }
}
