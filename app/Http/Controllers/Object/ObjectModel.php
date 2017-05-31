<?php

namespace App\Http\Controllers\Object;

use App\Http\Controllers\AbstractModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:40 PM
 */
class ObjectModel extends AbstractModel
{

    protected $name;

    protected $category_id;

    protected $prototype_id;

    protected $prefix;
    

    public function fill(Request $request)
    {
        $this->validate($request);

        $this->name = $request->name;

        $this->prefix = $request->prefix;

        $this->category_id = $request->category_id;

        $this->prototype_id = $request->prototype_id;


    }
}