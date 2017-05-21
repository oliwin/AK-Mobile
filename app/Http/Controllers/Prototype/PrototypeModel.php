<?php

namespace App\Http\Controllers\Prototype;

use App\Http\Controllers\AbstractModel;

use Symfony\Component\HttpFoundation\Request;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:41 PM
 */
class PrototypeModel extends AbstractModel
{


    protected $name;

    protected $parameters = [];

    public function fill(Request $request)
    {

        $this->validate($request);

        $this->name = $request->name;
        
        $this->available = $request->available;

        $this->parameters = $request->parameters;

    }

}