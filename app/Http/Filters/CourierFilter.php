<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class CourierFilter extends AbstractFilter
{
    public const CITY_ID = 'city_id';
    public const NAME = 'name';
    public const STATUS = 'numeric';

    protected function getCallbacks(): array
    {
        return [
          self::CITY_ID => [$this, 'cityId'],
          self::NAME => [$this, 'name'],
          self::STATUS => [$this, 'numeric'],
        ];
    }

    public function cityId(Builder $builder, $value)
    {
        $builder->where('city_id', $value);
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function status(Builder $builder, $value)
    {
        $builder->where('status', $value);
    }
}
