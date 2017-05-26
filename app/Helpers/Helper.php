<?php
/**
 * Created by PhpStorm.
 * User: Designer
 * Date: 08.10.2016
 * Time: 18:02
 */

namespace App\Helpers;

use Auth;

use App\Helpers;


class Helper
{

    public static function pluckObject($object, $key, $value, $placeholder = "Select", $replace = true)
    {
        $arr = [];
        if ($replace) {
            $arr = ["" => $placeholder];
        }
        foreach ($object as $k => $v) {
            $id = $v[$key]->{'$id'};
            $arr[$id] = $v[$value];
        }
        return $arr;
    }

    public static function getMongoIDString($id)
    {

        return new \MongoId($id);

    }

    private static function mongoIDString($id)
    {

        return (string)$id;
    }

    public static function getTypeParameterName($type)
    {

        switch ((int)$type) {

            case 1:
                return "Scalar";
                break;

            case 2:
                return "Object";
                break;

            case 3:
                return "Array";
                break;

            case 4:
                return "Boolean";
                break;

            case 5:
                return "Vector";
                break;
        }

    }

    public static function reformatArrayToList($array)
    {

        $arr = [0 => "Prototype"];

        foreach ($array as $k => $v) {

            $key = self::mongoIDString($v["_id"]);

            $arr[$key] = $v["name"];
        }

        return $arr;
    }

    public static function inArray($value, $array)
    {

        return (key_exists($value, $array)) ? $array[$value] : "-";

    }

    public static function parameterTypes()
    {

        return ["" => "Select type", 1 => "Scalar", 2 => "Array objects", 3 => "Array", 4 => "Boolean", 5 => "Vector"];
    }

    public static function parameterTypesValue($key = null)
    {

        $arr = ["" => "Select parameter type", "integer" => "Integer", "string" => "String", "float" => "Float", "boolean" => "Boolean", "vector2" => "Vector 2", "vector3" => "Vector 3"];


        if (is_null($key)) {

            return $arr;
        }

        return $arr[$key];
    }


}
