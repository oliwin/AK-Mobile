<?php

namespace App\Http\Controllers\Cabinet\Center;

use App\Http\Controllers\Controller;

use App\ResultTest;

use Illuminate\Http\Request;

use App\ResultTestFiles;

use Illuminate\Support\Facades\Input;

use App\Work;

use App\Conclusion;


class TestController extends Controller
{

    public function index(Request $request)
    {

        $status = Input::get('status');

        $tests = ResultTestFiles::where(function ($query) use ($request) {

            if (($request->get("status"))) {
                $query->where('status', $request->status);
            }

        })->with("client")->with("results")->orderBy('created_at', 'desc')->paginate(100);

        return view('cabinet.center.tests.index', ["tests" => $tests, "status" => $status]);
    }

    private function convertO($data){

        $arr = [];
        $data = json_decode($data->O);

        foreach($data as $k => $v){

            $arr[$k] = $v;
        }

        return $arr;
    }

    public function show($id)
    {

        $conclusions = Conclusion::all();
        $test = ResultTest::with("client")->where("client_id", $id)->get()->first();
        $types = Work::orderBy('name')->get()->pluck('name', 'id');

        $conclusion =  $conclusions->filter(function ($item) use ($test)
        {
            return ($item->type_work == $test->type_work && $item->category == $test->category);
        });


        return view('cabinet.center.tests.show', ["conclusion" => $conclusion->first(), "test" => $test, "O" => $this->convertO($test), "types" => $types]);
    }

}
