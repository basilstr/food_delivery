<?php

namespace App\Models\Finance;

use App\Models\BaseModels\AbstractBaseModel;

/**
 * App\Models\Finance\Transaction
 *
 * @property int $id
 * @property int|null $sub_account_from
 * @property string $total_from
 * @property int|null $sub_account_to
 * @property string $total_to
 * @property string $sum
 * @property string $description
 * @property string $extra_param
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Finance\TransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereExtraParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSubAccountFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSubAccountTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTotalFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTotalTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
class Transaction extends AbstractBaseModel
{

    public static function parseHistory($change_params)
    {
        // TODO: Implement parseHistory() method.
    }
}
