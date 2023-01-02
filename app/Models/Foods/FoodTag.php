<?php

namespace App\Models\Foods;

use App\Models\BaseModels\AbstractBaseModel;

/**
 * App\Models\Foods\FoodTag
 *
 * @property int $id
 * @property int $food_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Foods\FoodTagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodTag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
class FoodTag extends AbstractBaseModel
{
    public $timestamps = false;

    public static function parseHistory($change_params)
    {
        // TODO: Implement parseHistory() method.
    }
}
