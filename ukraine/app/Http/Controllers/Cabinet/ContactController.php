<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use View;

use Auth;

use App\Contacts;

use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $contacts = Contacts::where("user_id", Auth::user()->id)->get()->first();

        if(!is_null($contacts)){
          $contacts = json_decode($contacts->name);
        }

        return View::make('cabinet.distributor.contact.index', ["contacts" => $contacts, "id" => Auth::user()->id]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "email.*" => 'required|string',
            "phone.*" => 'required|string',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $contacts = Contacts::where("user_id", Auth::user()->id)->get();

        if ($contacts->count() > 0) {
            $contacts_decode = json_decode($contacts->first()->name);

            foreach($request->all() as $key => $value){
                if($key == "email" || $key == "phone"){
                    foreach ($value as $k => $val){
                        $contacts_decode->{$key}[$k] = $val;
                    }
                }
            }

            $contacts_decode = json_encode($contacts_decode);
            Contacts::where("user_id", Auth::user()->id)->update(['name' => $contacts_decode]);

        } else {

           $arr = [];
           foreach($request->all() as $key => $value){
               if($key == "email" || $key == "phone"){
                    foreach ($value as $val){
                        $arr[$key][] = $val;
                    }
               }
           }

           $contacts = json_encode($arr);
           Contacts::insert(["name" => $contacts, "user_id" => Auth::user()->id]);
        }

        return redirect('cabinet/contacts/1')->with('flash_message', 'Category was updated!');
    }

}
