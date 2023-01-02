<?php

namespace App\Models;

use App\Entity\Photo;
use App\Entity\Schedule;
use App\Entity\TranslateParamBuilder;
use App\Models\Foods\Food;
use App\Models\Permanent\Cities;
use App\Models\BaseModels\AbstractBaseModel;
use App\Models\Permanent\TypeDelivery;
use App\Models\Permanent\TypePay;
use Auth;


/**
 * App\Models\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string|null $lat
 * @property string|null $lon
 * @property int|null $city_id
 * @property int $status
 * @property string|null $address
 * @property int|null $account_id
 * @property array|null $work_schedule графік роботи
 * @property string|null $about про заклад
 * @property string|null $rating загальний рейтинг по результатам оцінок користувачів
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProviderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereWorkSchedule($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @property int $type_pay способи оплати
 * @property int $type_delivery способи доставки
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereTypeDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereTypePay($value)
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereSort($value)
 * @property string|null $aliases варіанти назви закладу - використовується для пошуку
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAliases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider filterCity()
 * @property string|null $description короткий опис закладу
 * @property string|null $min_price мінімальне замовлення
 * @property int $total_votes загальна кількість голосів
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereTotalVotes($value)
 */
class Provider extends AbstractBaseModel
{
    const DEFAULT_ICON = '/img/big-sandwich.jpg';

    const DISACTIVE         = 0;
    const ACTIVE            = 1;
    const DELETED           = 2;
    const MODERATION        = 3;
    const SCHEDULE_ACTIVE   = 4;
    const SCHEDULE_PAUSE    = 5;

    const ON_MODERATION = 3; // статус на модерації - вивід в окремий список
    const ON_ACTIVE = 5; // статус активності після пакетної зміни

    protected $readOnlyAttribute = [
        'admin' => ['address'],
        'master' => ['address', 'work_schedule', 'city_id', 'type_delivery']
    ];

    protected $hiddenAttribute = [
        'master' => ['address']
    ];

    public static $listStatus = [
        self::ACTIVE            => 'активний завжди',
        self::DISACTIVE         => 'неактивний', // не показується в додатку
        self::DELETED           => 'видалений',
        self::MODERATION        => 'на модерації', // не показується в додатку
        self::SCHEDULE_ACTIVE   => 'робочий за розкладом',
        self::SCHEDULE_PAUSE    => 'не робочий за розкладом', // показується в додатку
    ];

    protected $casts = [
        'type_pay' => 'array',
        'type_delivery' => 'array',
    ];

    public function getCityName()
    {
        return Cities::getName($this->city_id,'name');
    }

    public function getLogoAttribute($value)
    {
        return $this->getUrlImage($value);

    }

    public function users()
    {
        return $this->hasMany(User::class, 'provider_id', 'id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'provider_id', 'id');
    }

    public function getWorkScheduleAttribute($value)
    {
        return new Schedule($value);
    }

    public function setWorkScheduleAttribute($value)
    {
        $this->attributes['work_schedule'] = json_encode(Schedule::make($value)->toArray());
    }

    // По замовчуванню місто в якому знаходиться заклад
    public function getLatAttribute($value)
    {
        return empty($value) ? Cities::getName($this->city_id, 'lat') : $value;
    }

    // По замовчуванню місто в якому знаходиться заклад
    public function getLonAttribute($value)
    {
        return empty($value) ? Cities::getName($this->city_id, 'lon') : $value;
    }

    public function scopeFilterCity($query)
    {
        if(Auth::user()->city_id) return $query->where('city_id', Auth::user()->city_id);
        return  $query;
    }

    /**
     * Перелік полів, які показуються в списку дій по моделі, ті, які не вказані тут - не будуть показуватись
     * @return string[]
     */
    public static function attributeLabels()
    {
        return [
            'name'          => 'Ім\'я',
            'aliases'       => 'Альяси',
            'logo'          => 'Лого',
            'lat'           => 'Широта',
            'lon'           => 'Довгота',
            'city_id'       => 'Місто',
            'status'        => 'Статус',
            'address'       => 'Адреса',
            'work_schedule' => 'Графік роботи',
            'type_pay'      => 'Способи оплати',
            'type_delivery' => 'Способи доставки',
            'about'         => 'Про заклад',
            'sort'          => 'Порядок сортування',
        ];
    }

    public function saveModel($data)
    {
        $city_id = $data['city_id'] ?? null;
        if(Auth::user()->city_id) $city_id = Auth::user()->city_id;

        $this->name = $data['name'] ?? '';
        $this->aliases = $data['aliases'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->min_price = $data['min_price'] ?? '';
        $this->about = $data['about'] ?? '';
        $this->lat = $data['lat'] ?? '';
        $this->lon = $data['lon'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->city_id = $city_id;
        $this->work_schedule = $data['work_schedule'] ?? [];
        $this->type_pay = $data['type_pay'] ?? [];
        $this->type_delivery = $data['type_delivery'] ?? [];
        $this->status = $data['status'] ?? null;
        $this->sort = $data['sort'] ?? 0;
        if(isset($data['logo']) && $data['logo']) {
            $this->logo = Photo::make(class_basename(self::class), $data['logo'])->getFileName();
        }
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
                    ->typePay()
                    ->typeDelivery()
                    ->workSchedule()
                    ->make();
            }
        }
        return $res;
    }
}
