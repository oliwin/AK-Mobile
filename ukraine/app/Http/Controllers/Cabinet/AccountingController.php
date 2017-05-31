<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use View;

use Auth;

use App\User;

use App\Settings;

use Illuminate\Support\Facades\Redirect;

class AccountingController extends Controller
{


    public function index()
    {
        return View::make('cabinet.distributor.conclusion.index');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'email' => 'required|email',
            'short_name' => 'required|max:100',
            'post_index' => 'required|numeric',
            'city' => 'required|integer',
            'address' => 'required|string',
            'tax_type' => 'required|string|max:50',
            'instructor' => 'required|string|max:50',
            'doctor' => 'required|string|max:50'
        ]);

        if ($request->has('email')) {
            Settings::where("user_id", Auth::user()->id)->update([
                "email_admin" => $request->email
            ]);
        }

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();
        $user->fill($input)->save();

        return redirect('cabinet/administration')->with('flash_message', 'Category was updated!');
    }
}
