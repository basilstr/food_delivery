<?php

namespace App\Models;

use App\Entity\ComparebleInterface;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogAction
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $action
 * @property string|null $model
 * @property int|null $model_id
 * @property array|null $change_params
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereChangeParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAction whereUserId($value)
 * @mixin \Eloquent
 */
class LogAction extends Model
{
    use HasFactory;
    public $parseData;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'model',
        'model_id',
        'action',
        'change_params',
    ];

    protected $casts = [
        'change_params' => 'array',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function saveChangeAttribute(Model $model, $action)
    {
        $user_id = Auth::guest() ? null : Auth::user()->id;

        $diff = [];
        foreach ($model->getAttributes() as $attribute => $value) {
            // не враховуємо дату зміни
            if($attribute == 'updated_at') continue;

            // оригінальний (незмінений) елемент отриманий від аксесора та через cast
            $old = $model->getOriginal($attribute);
            if( $old instanceof ComparebleInterface) {
                if(! $old->hasDiff($value)) continue;
                $old = json_encode($old->toArray());
                $value = json_encode($value);
            }elseif (is_array($old )) {
                // $value не вертаєтсья від аксесора та через cast, а іде строкою, тому беремо так
                $new = $model->$attribute;
                // чи перший масив входить в другий, а другий масив в перший
                $diff_array = array_merge(array_diff($new, $old ), array_diff($old, $new));
                if(empty($diff_array))  continue;
                $old = json_encode($old);
                $value = json_encode($new);
            }else{
                // строкові змінні перевіряємо без використання ассесорів, бо вони підставляють дані при їх фактичній відсутності, наприклад logo
                $old = $model->getRawOriginal($attribute);
                if($value == $old) continue;
            }
            $diff[$attribute]['old'] = $old;
            $diff[$attribute]['new'] = $value;
        }
        if(empty($diff)) return;
        LogAction::create([
            'user_id' => $user_id,
            'action' => $action,
            'model' => $model->getMorphClass(),
            'model_id' => $model->id,
            'change_params' => $diff,
        ]);
    }

    public function parseHistory()
    {
        $this->parseData = ($this->model)::parseHistory($this->change_params);
        return $this;
    }
}
