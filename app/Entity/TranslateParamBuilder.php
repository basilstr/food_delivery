<?php


namespace App\Entity;


use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use App\Models\Permanent\TypeDelivery;
use App\Models\Permanent\TypeDrive;
use App\Models\Permanent\TypeFood;
use App\Models\Permanent\TypeFoodIngredient;
use App\Models\Permanent\TypePay;

/**
 * створення читабельної форми для відображення змін моделей
 * перегляд історії змін
 * Class TranslateParamBuilder
 * @package App\Entity
 */
class TranslateParamBuilder
{
    private $param;
    private $value;
    private $result;
    private $attributes;

    public static function build($param, $value)
    {
        $model = new self();
        $model->param = $param;
        $model->value = $value;
        $model->result = null;
        $model->attributes = null;
        return $model;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
    public function city()
    {
        if($this->param == 'city_id'){
            $old = Cities::getName($this->value['old'], 'name');
            $new = Cities::getName($this->value['new'], 'name');
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function status($listStatus)
    {
        if($this->param == 'status'){
            $old = $listStatus[$this->value['old']] ?? '';
            $new = $listStatus[$this->value['new']] ?? '';
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function promoteStatus($listStatus)
    {
        if($this->param == 'status'){
            $old = $listStatus[$this->value['old']] ?? '';
            $new = $listStatus[$this->value['new']] ?? '';
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function role()
    {
        if($this->param == 'role'){
            $old = Role::getName($this->value['old']);
            $new = Role::getName($this->value['new']);
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function typePay()
    {
        if($this->param == 'type_pay'){
            $this->typeConvert(TypePay::class);
        }
        return $this;
    }

    public function typeDelivery()
    {
        if($this->param == 'type_delivery'){
            $this->typeConvert(TypeDelivery::class);
        }
        return $this;
    }

    public function typeDrive()
    {
        if($this->param == 'type_drive'){
            $this->typeConvert(TypeDrive::class);
        }
        return $this;
    }

    public function typeFood()
    {
        if($this->param == 'type_food'){
            $old = TypeFood::getName($this->value['old']);
            $new = TypeFood::getName($this->value['new']);
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function foodIngredient()
    {
        if($this->param == 'food_ingredient'){
            $old = TypeFoodIngredient::getName($this->value['old']);
            $new = TypeFoodIngredient::getName($this->value['new']);
            $this->result = $this->addResult($this->param, $old, $new);
        }
        return $this;
    }

    public function workSchedule()
    {
        if($this->param == 'work_schedule'){
            $this->scheduleConvert($this->param);
        }
        return $this;
    }

    public function promoteSchedule()
    {
        if($this->param == 'promote_status'){
            $this->scheduleConvert($this->param);
        }
        return $this;
    }

    public function make()
    {
        if(empty($this->result)){
            $this->result = $this->addResult($this->param, $this->value['old'], $this->value['new']);
        }
        return $this->result;
    }

    private function scheduleConvert($param)
    {
        $diff = Schedule::getDiffArray($this->value['old'], $this->value['new']);
        if(!empty($diff)) {
            $this->result = [
                'attr' =>  $this->attributes[$param], 'params'=>$diff,
            ];
        }
    }

    private function typeConvert($className)
    {
        $old = [];
        $new = [];
        try {
            $oldArray = json_decode($this->value['old']);
            if(is_array($oldArray)) {
                foreach ($oldArray as $val) $old[] = $className::getName($val);
            }
        }catch (\Exception $e){
            $old[] ='-';
        }
        try {
            $newArray = json_decode($this->value['old']);
            if(is_array($newArray)) {
                foreach ($newArray as $val) $new[] = $className::getName($val);
            }
        }catch (\Exception $e){
            $old[] ='-';
        }
        $old = implode(', ', $old);
        $new = implode(', ', $new);
        $this->result = $this->addResult($this->param, $old, $new);
    }

    private function addResult($param, $old, $new)
    {
        return [
            'attr' => $this->attributes[$param],
            'params'=>[
                [
                    'old' => $old ?? '',
                    'new' => $new ?? '',
                ]
            ]
        ];
    }
}
