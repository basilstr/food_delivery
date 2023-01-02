<?php

namespace App\Models;

use App\Entity\TranslateParamBuilder;
use App\Models\BaseModels\AbstractBaseModel;
use App\Models\Permanent\Cities;
use App\Models\Permanent\TypeDrive;
use App\Models\Traits\Filterable;
use Auth;

/**
 * App\Models\Courier
 *
 * @property int $id
 * @property string $phone
 * @property string $name
 * @property string|null $password
 * @property int|null $account_id
 * @property int|null $city_id
 * @property int|null $type_drive
 * @property string $notes примітки
 * @property int $status
 * @property string|null $api_token
 * @property string|null $api_token_expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Courier filter(\App\Http\Filters\FilterInterface $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier filterCity()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|Courier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Courier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|Courier query()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereApiTokenExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereTypeDrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Courier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Courier extends AbstractBaseModel
{
    use Filterable;
    const ACTIVE    = 1;
    const DISACTIVE = 2;
    const DELETED   = 3;

    public static $listStatus = [
        self::ACTIVE            => 'активний',
        self::DISACTIVE         => 'неактивний',
        self::DELETED           => 'видалений',
    ];

    public function getCityName()
    {
        return Cities::getName($this->city_id,'name');
    }

    public function getTypeDriveName()
    {
        return TypeDrive::getName($this->type_drive,);
    }

    public function scopeFilterCity($query)
    {
        if(Auth::user()->city_id) return $query->where('city_id', Auth::user()->city_id);
        return  $query;
    }

    /**
     * Перелік полів, які показуються в списку дій по моделі, ті, які не вказані тут - не будуть показуватись
     * (для логування змін)
     * @return string[]
     */
    public static function attributeLabels()
    {
        return [
            'phone'       => 'Телефон',
            'name'        => 'Ім\'я',
            'password'    => 'Пароль',
            'city_id'     => 'Місто',
            'type_drive'  => 'Тип доставки',
            'notes'       => 'Нотатки',
            'status'      => 'Статус',
        ];
    }

    public function saveModel($data)
    {
        $city_id = $data['city_id'] ?? null;
        if(Auth::user()->city_id) $city_id = Auth::user()->city_id;

        $this->phone = $data['phone'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->city_id = $city_id;
        $this->type_drive = $data['type_drive'] ?? '';
        $this->notes = $data['notes'] ?? '';
        $this->status = $data['status'] ?? null;
        $this->saveOrFail();
    }

    public static function parseHistory($change_params)
    {
        $res = [];
        foreach ($change_params as $param => $value){
            if(isset(self::attributeLabels()[$param])){
                $res[] = TranslateParamBuilder::build($param, $value)
                    ->setAttributes(self::attributeLabels())
                    ->city()
                    ->status(self::$listStatus)
                    ->typeDrive()
                    ->make();
            }
        }
        return $res;
    }
}
