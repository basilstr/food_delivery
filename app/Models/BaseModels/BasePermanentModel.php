<?php

namespace App\Models\BaseModels;

abstract class BasePermanentModel
{
    protected $attributes = [];

    /**
     * @return string
     */
    public static function getName($key = 0, $attribute='')
    {
        $model = new static();
        if(empty($attribute)) {
            return $model->attributes[$key] ?? '';
        }else{
            return $model->attributes[$key][$attribute] ?? '';
        }
    }

    /**
     * @return string[]
     */
    public static function getList($attribute='')
    {
        $model = new static();
        if(empty($attribute)) {
            return $model->attributes;
        }else{
            $res = [];
            foreach ($model->attributes as $key => $attr){
                $res[$key] = $attr[$attribute];
            }
            return $res;
        }
    }

    public static function getListKey()
    {
        $model = new static();
        return array_keys($model->attributes);
    }

    /**
     * видає масив ключ-значення для значень ключа $params
     * @return string[]
     */
    public static function getListOnlyParam($params, $attribute='')
    {
        if (!is_array($params)) return [];
        $model = new static();
        $res = [];
        foreach ($model->attributes as $key => $attr) {
            if(in_array($key, $params)) {
                if (empty($attribute)) {
                    $res[$key] = $model->attributes[$key];
                } else {
                    $res[$key] = $model->attributes[$key][$attribute];
                }
            }
        }
        return $res;
    }
}
