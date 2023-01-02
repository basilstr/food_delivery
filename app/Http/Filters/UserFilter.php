<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    public const PROVIDER_ID = 'provider_id';
    public const CITY_ID = 'city_id';
    public const NAME = 'name';
    public const STATUS = 'numeric';
    public const ROLE = 'role';

    protected function getCallbacks(): array
    {
        return [
          self::PROVIDER_ID => [$this, 'providerId'],
          self::CITY_ID => [$this, 'cityId'],
          self::NAME => [$this, 'name'],
          self::STATUS => [$this, 'numeric'],
          self::ROLE => [$this, 'role'],
        ];
    }

    public function providerId(Builder $builder, $value)
    {
        $builder->where('provider_id', $value);
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

    public function role(Builder $builder, $value)
    {
        $builder->where('role', $value);
    }
}
