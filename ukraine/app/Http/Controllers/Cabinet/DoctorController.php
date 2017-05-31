<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Hash;

use App\Doctor;

use View;

use Validator;

use App\User;

use Auth;


class DoctorController extends Controller
{

  public function index(){

    $doctors = Doctor::with("details", "region")->get();

    return View::make('cabinet.distributor.doctor.index', ["doctors" => $doctors]);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        "name.*" => 'required|string',
        "phone.*" => 'required|string',
        "email.*" => 'required|email',
        "note.*" => 'string'
    ]);

    if ($validator->fails()) {
        return Redirect::back()
            ->withErrors($validator)
            ->withInput();
    }

    foreach($request->name as $k => $v){

        $max_id = User::where("type_account")->max('id');
        $new_id = $max_id + 1;
        $password = str_random(8);

        $user = User::create(
          [
          "password" => bcrypt($password),
          "type_account" => 2,
          "name" => $v,
          "status" => 1,
          "email" => "doctor_".$new_id."@ukraine.com"
        ]
      );

        Doctor::create(
          [
            "name" => $v,
            "phone" => $request->phone[$k],
            "email" => $request->email[$k],
            "note" => $request->note[$k],
            "user_id" => $user->id,
            "password" => $password,
            "region_id" => Auth::user()->region
          ]
        );
    }

    return redirect('cabinet/administration/doctors')->with('flash_message', 'Doctor was added');

  }

  public function create(){
      return View::make('cabinet.distributor.doctor.register');
  }

  public function destroy($id)
  {
      $doctor = Doctor::where("user_id", $id);
      $doctor->delete();

      $user = User::where("id", $id);
      $user->delete();

      return redirect('cabinet/administration/doctors');
  }


}
