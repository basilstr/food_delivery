<?php

namespace App\Models\Foods;

use App\Entity\Photo;
use App\Entity\Schedule;
use App\Entity\TranslateParamBuilder;
use App\Models\BaseModels\AbstractBaseModel;

/**
 * App\Models\Foods\Ingredient
 *
 * @property int $id
 * @property int $parent_food_id
 * @property int $ingredient_food_id
 * @property int|null $weight вага в грамах за одиницю товару
 * @property int|null $amount кількість елементів в порції / упаковці, що має вказану вагу weight
 * @property string|null $price ціна загалом за вказану вагу weight
 * @property string|null $price_package ціна загалом за вказану вагу weight
 * @property int $can_change 1-завжди включений 2-включений по замовчуванню 3-виключений по замовчуванню
 * @property int $type_change 1-radio 2-checkbox 3-none
 * @property int $status
 * @property array|null $work_schedule графік роботи
 * @property int $promote_status
 * @property string|null $promote_description опис акції
 * @property array|null $promote_schedule
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Foods\Food $parentFood
 * @property-read \App\Models\Foods\Food $parentIngredient
 * @method static \Database\Factories\Foods\IngredientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereCanChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIngredientFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereParentFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient wherePricePackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient wherePromoteDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient wherePromoteSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient wherePromoteStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereTypeChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereWorkSchedule($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
class Ingredient extends AbstractBaseModel
{
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

    public static $canChangeList = [
        1 => "завжди включений",
        2 => "включений по замовчуванню",
        3 => "виключений по замовчуванню",
    ];

    public static $typeChangeList = [
        1 => "radio",
        2 => "checkbox",
        3 => "none",
    ];

    protected $fillable = [
        'parent_food_id',
        'ingredient_food_id',
    ];

    public function parentFood()
    {
        return $this->belongsTo(Food::class, 'parent_food_id', 'id');
    }

    public function parentIngredient()
    {
        return $this->belongsTo(Food::class, 'ingredient_food_id', 'id');
    }

    public function getWorkScheduleAttribute($value)
    {
        return new Schedule($value);
    }

    public function setWorkScheduleAttribute($value)
    {
        $this->attributes['work_schedule'] = Schedule::make($value)->toArray();
    }

    public function getPromoteScheduleAttribute($value)
    {
        return new Schedule($value);
    }

    public function setPromoteScheduleAttribute($value)
    {
        $this->attributes['promote_schedule'] = Schedule::make($value)->toArray();
    }

    public function getCanChangeList()
    {
        return self::$canChangeList;
    }
    public function getTypeChangeList()
    {
        return self::$typeChangeList;
    }

    /**
     * Перелік полів, які показуються в списку дій по моделі, ті, які не вказані тут - не будуть показуватись
     * (для логування змін)
     * @return string[]
     */
    public static function attributeLabels()
    {
        return [
            'weight'                => 'Вага',
            'amount'                => 'Кількість',
            'price'                 => 'Ціна',
            'price_package'         => 'Ціна пакування',
            'can_change'            => 'Чи можна виключати',
            'type_change'           => 'Тип вибору',
            'status'                => 'Статус',
            'work_schedule'         => 'Графік роботи',
            'promote_schedule'      => 'Графік акцій',
            'promote_status'        => 'Статус акцій',
            'promote_description'   => 'Опис акцій',
            'sort'                  => 'Порядок сортування',
        ];
    }

    public function saveModel($data)
    {
        $this->weight = $data['weight'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->price_package = $data['price_package'] ?? null;
        $this->can_change = $data['can_change'] ?? 0;
        $this->type_change = $data['type_change'] ?? 0;
        $this->status = $data['status'] ?? null;
        $this->work_schedule = $data['work_schedule'] ?? [];
        $this->promote_status = $data['promote_status'] ?? null;
        $this->promote_description = $data['promote_description'] ?? '';
        $this->promote_schedule = $data['promote_schedule'] ?? [];
        $this->sort = $data['sort'] ?? null;
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
                    ->workSchedule()
                    ->promoteSchedule()
                    ->make();
            }
        }
        return $res;
    }
}
