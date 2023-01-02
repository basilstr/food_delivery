<?php

namespace App\Models;

use App\Entity\TranslateParamBuilder;
use App\Models\BaseModels\AbstractBaseModel;
use App\Models\Permanent\Cities;
use App\Models\Traits\Filterable;
use Auth;
use Str;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $phone
 * @property string $name
 * @property int|null $account_id
 * @property int|null $city_id
 * @property string $address адреса по замовчуванню
 * @property string $notes примітки
 * @property int $in_black_list
 * @property int $status 1-активний 2-відключений 3-видалений
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereInBlackList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 * @property string|null $sms_code
 * @property string|null $sms_code_send час відправлення СМС коду
 * @property string|null $api_token
 * @property string|null $api_token_expiration
 * @method static \Illuminate\Database\Eloquent\Builder|Client filter(\App\Http\Filters\FilterInterface $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Client filterCity()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereApiTokenExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSmsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSmsCodeSend($value)
 */
class Client extends AbstractBaseModel
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

    protected $casts = [
        'in_black_list' => 'boolean',
    ];

    public function getCityName()
    {
        return Cities::getName($this->city_id,'name');
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
            'phone'         => 'Телефон',
            'name'          => 'Ім\'я',
            'password'      => 'Пароль',
            'city_id'       => 'Місто',
            'address'       => 'Адреса',
            'notes'         => 'Нотатки',
            'status'        => 'Статус',
            'in_black_list' => 'Чорний список',
        ];
    }

    public function saveModel($data)
    {
        $city_id = $data['city_id'] ?? null;
        if(Auth::user()->city_id) $city_id = Auth::user()->city_id;

        $this->phone = $data['phone'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->city_id = $city_id;
        $this->address = $data['address'] ?? '';
        $this->notes = $data['notes'] ?? '';
        $this->in_black_list = $data['in_black_list'] ?? false;
        $this->status = $data['status'] ?? null;
        $this->saveOrFail();
    }

    /**
     * метод який викликається після оновлення токена
     */
    public function afterUpdateToken()
    {
        $this->sms_code = null;
        $this->sms_code_send = null;
        $this->save();
        return;
    }

    /**
     * метод який викликається перед оновлення токена - це заглушка, перевизначається в вищому класі
     * повернення НЕ false означає переривання дії з виконнанням коду
     * @return array|bool
     */
    public function beforeUpdateToken()
    {
        if (isset($this->sms_code_send) && intval(strtotime($this->sms_code_send)) < time() - $this->liveSMS) {
            return [
                'status' => false,
                'message' => 'SMS Code expirated',
            ];
        }
        return false;
    }

    /**
     * @param $change_params
     * @return array
     */
    public static function parseHistory($change_params)
    {
        $res = [];
        foreach ($change_params as $param => $value){
            if(isset(self::attributeLabels()[$param])){
                $res[] = TranslateParamBuilder::build($param, $value)
                    ->setAttributes(self::attributeLabels())
                    ->city()
                    ->status(self::$listStatus)
                    ->make();
            }
        }
        return $res;
    }
}
