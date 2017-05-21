<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 5:42 PM
 */

namespace App\Http\Controllers;


class AbstractModel
{

    protected $available = "1";

    protected $_id;

    public function validate($request)
    {

        if (is_null($request)) {
            throw new Exception('Empty request array!');
        }

        if (is_null($request->available)) {
            $this->available = "2";
        }
    }

    public function data()
    {

        $exists = get_object_vars($this);

        return $this->except(["_id", "selected"], $exists);
        
    }

    protected function except($except, $data)
    {
        $except = array_flip($except);

        $except = array_diff_key($data, $except);

        return $except;

    }


}