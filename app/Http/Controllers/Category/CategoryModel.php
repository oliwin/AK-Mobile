<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:46 PM
 */

namespace App\Http\Controllers\Category;

use App\Http\Controllers\AbstractModel;

use Symfony\Component\HttpFoundation\Request;


class CategoryModel extends AbstractModel
{

    protected $name;
    
    public function fill(Request $request)
    {
        $this->validate($request);

        $this->name = $request->name;

        $this->available = $request->available;
    }
}