<?php

namespace App\Models\Foods;

use App\Entity\Photo;
use App\Entity\Schedule;
use App\Entity\TranslateParamBuilder;
use App\Models\Provider;
use App\Models\Tag;
use App\Models\BaseModels\AbstractBaseModel;

/**
 * App\Models\Foods\Food
 *
 * @property int $id
 * @property int|null $provider_id
 * @property string $name
 * @property string|null $photo
 * @property int $type_food 1-порційна 2-вагова
 * @property int|null $weight вага в грамах за одиницю товару
 * @property int|null $amount кількість елементів в порції / упаковці, що має вказану вагу weigth
 * @property string $description опис блюда / товару
 * @property string $price ціна загалом за вказану вагу weigth
 * @property string $price_pack ціна за пакування
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Provider|null $provider
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Foods\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\Foods\FoodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePricePack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereTypeFood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereWeigth($value)
 * @mixin \Eloquent
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereStatus($value)
 * @property int $food_ingredient 1-блюдо 2-інградієнт, 3-блюдо+інградієнт
 * @property array|null $description_design json опис полів в дизайні додатку
 * @property array|null $work_schedule графік роботи
 * @property int $promote_status
 * @property string|null $promote_description опис акції
 * @property array|null $promote_schedule
 * @property int|null $sort
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereDescriptionDesign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereFoodIngredient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePromoteDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePromoteSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food wherePromoteStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereWorkSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
class Food extends AbstractBaseModel
{
    const DEFAULT_ICON = '/img/pizza.jpg';

    const DISACTIVE         = 0;
    const ACTIVE            = 1;
    const DELETED           = 2;
    const MODERATION        = 3;
    const SCHEDULE_ACTIVE   = 4;
    const SCHEDULE_PAUSE    = 5;

    const ON_MODERATION = 3; // статус на модерації - вивід в окремий список
    const ON_ACTIVE = 1; // статус активності після пакетної зміни

    public static $listStatus = [
        self::DISACTIVE         => 'неактивний', // не показується в додатку
        self::ACTIVE            => 'активний завжди', // розклад ігнорується
        self::DELETED           => 'видалений',
        self::MODERATION        => 'на модерації', // не показується в додатку
        self::SCHEDULE_ACTIVE   => 'робочий за розкладом',
        self::SCHEDULE_PAUSE    => 'не робочий за розкладом', // показується в додатку
    ];

    protected $casts = [
        'description_design' => 'array',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'food_tags', 'food_id', 'tag_id');
    }

    public function getWorkScheduleAttribute($value)
    {
        return new Schedule($value);
    }

    public function setWorkScheduleAttribute($value)
    {
        $this->attributes['work_schedule'] =  json_encode(Schedule::make($value)->toArray());
    }

    public function getPromoteScheduleAttribute($value)
    {
        return new Schedule($value);
    }

    public function setPromoteScheduleAttribute($value)
    {
        $this->attributes['promote_schedule'] =  json_encode(Schedule::make($value)->toArray());
    }

    public function getPhotoAttribute($value)
    {
        return $this->getUrlImage($value);

    }

    public function getPromoteStatusName()
    {
        return static::$listStatus[$this->promote_status];
    }

    /**
     * Перелік полів, які показуються в списку дій по моделі, ті, які не вказані тут - не будуть показуватись
     * (для логування змін)
     * @return string[]
     */
    public static function attributeLabels()
    {
        return [
            'name'                  => 'Ім\'я',
            'photo'                 => 'Фото',
            'type_food'             => 'Тип страви',
            'food_ingredient'       => 'Інгредієнт',
            'description'           => 'Опис',
            'description_design'    => 'Опис в додатку',
            'weight'                => 'Вага',
            'amount'                => 'Кількість',
            'price'                 => 'Ціна',
            'status'                => 'Статус',
            'work_schedule'         => 'Графік роботи',
            'promote_status'        => 'Статус акцій',
            'promote_description'   => 'Опис акцій',
            'promote_schedule'      => 'Графік акцій',
            'sort'                  => 'Порядок сортування',
        ];
    }

    public function saveModel($data)
    {
        $this->provider_id  = $data['provider_id'];
        $this->name = $data['name'] ?? '';
        $this->type_food = $data['type_food'] ?? null;
        $this->food_ingredient = $data['food_ingredient'] ?? null;
        $this->description = $data['description'] ?? '';
        $this->description_design = $data['description_design'] ?? [];
        $this->weight = $data['weight'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->work_schedule = $data['work_schedule'] ?? [];
        $this->promote_status = $data['promote_status'] ?? null;
        $this->promote_description = $data['promote_description'] ?? '';
        $this->promote_schedule = $data['promote_schedule'] ?? [];
        $this->sort = $data['sort'] ?? null;
        if(isset($data['photo']) && $data['photo']) {
            $this->photo = Photo::make(class_basename(self::class), $data['photo'])->getFileName();
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
                    ->status(self::$listStatus)
                    ->promoteStatus(self::$listStatus)
                    ->typeFood()
                    ->foodIngredient()
                    ->workSchedule()
                    ->promoteSchedule()
                    ->make();
            }
        }
        return $res;
    }
}
