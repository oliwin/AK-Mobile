<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use View;

use Carbon\Carbon;

use App\Client;

use App\Work;

use Illuminate\Support\Facades\Redirect;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {



        $typeWork = Work::orderBy('name')->get()->pluck('name', 'id');

        $work_types = $typeWork->map(function ($item, $key) {
            return $key . " - " . $item;
        });

        $clients = Client::where(function ($query) use ($request) {

            if (($term = $request->get("name"))) {
                $query->where('name', 'like', '%' . $term . '%');
                $query->orWhere('secondname', 'like', '%' . $term . '%');
                $query->orWhere('patronymic', 'like', '%' . $term . '%');
            }

            if (($request->get("factory"))) {
                $query->where('factory_name', $request->factory);
            }

            if (($request->get("profession"))) {
                $query->where('profession', $request->profession);
            }

            if (($request->get("code"))) {
                $query->where('unique_code', $request->code);
            }

            if (($request->get("type_work"))) {
                $query->where('type_work', $request->type_work);
            }

            if (($request->get("group"))) {
                $query->where('group_r', $request->group);
            }


        })->orderBy('id', 'desc')->paginate(100);

        return View::make('cabinet.distributor.statistic.index', ["title" => "", "clients" => $clients, "work_types" => $work_types]);
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

    public function show($id)
    {
        $category = ObjectType::where('id', $id);
        return View::make('dashboard.category.full', ['category' => $category]);
    }

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

    public function getAllDistributors()
    {
        $users = User::all();
        $users->prepend(["id" => 0, "name" => "Выбрать предприятие"]);

        return $users->pluck("name", "id");
    }

    public function statistic()
    {
        return View::make('cabinet.distributor.statistic.graph', ["users" => $this->getAllDistributors()]);
    }

    public function graph(Request $request)
    {
        $clients = Client::where(function ($query) use ($request) {

            if (($request->get("id"))) {
                $query->where('enterprise_id', $request->id);
            }

            if (($request->get("day"))) {
                $query->whereDay('created_at', '=', $request->day);
            }

            if (($request->get("month"))) {
                $query->whereMonth('created_at', '=', $request->month);
            }

            if (($request->get("year"))) {
                $query->whereYear('created_at', '=', $request->year);
            }

        })->orderBy('id', 'desc')->get();

        return response()->json(["data" => $clients]);

    }
}
