<?php

namespace App\Models\Finance;

use App\Models\BaseModels\AbstractBaseModel;
/**
 * App\Models\Finance\SubAccount
 *
 * @property int $id
 * @property int|null $account_id
 * @property int $type_account_id
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Finance\SubAccountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereTypeAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
class SubAccount extends AbstractBaseModel
{

    public static function parseHistory($change_params)
    {
        // TODO: Implement parseHistory() method.
    }
}
