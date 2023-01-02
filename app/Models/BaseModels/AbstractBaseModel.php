<?php

namespace App\Models\BaseModels;

use App\Entity\HistoryInterface;
use App\Entity\Schedule;
use App\Models\LogAction;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * App\Models\BaseModels\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel query()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 */
abstract class AbstractBaseModel extends Model implements HistoryInterface
{
    use HasFactory;

    protected $readOnlyAttribute = []; // перелік атрибутів, які readOnly для переліку ролей
    protected $hiddenAttribute = []; // перелік атрибутів, які hidden для переліку ролей

    protected $liveSMS = 300; // час активності СМС коду в секундах
    protected $liveToken = 86400; // час активності токена в секундах

    public static $listStatus = [];

    public function getListStatus()
    {
        return static::$listStatus;
    }

    /**
     * масив ключів (цифрових індексів) статусів
     * використовується для валідаціх вхідних даних від форми
     * @return array
     */
    public static function getListStatusKey()
    {
        return array_keys(static::$listStatus);
    }

    public function getStatusName()
    {
        return static::$listStatus[$this->status];
    }

    public function getUrlImage($value)
    {
        if(empty($value)) return static::DEFAULT_ICON;
        $fileName = '/upload/'.class_basename(static::class).'/'.$value;
        if(file_exists(storage_path('app/public') .$fileName)) return asset('/storage'.$fileName);
        return static::DEFAULT_ICON;
    }

    public function scopeModeration($query)
    {
        return $query->where('status', static::ON_MODERATION);
    }

    public function scopeSchedule($query)
    {
        return $query->whereIn('status', [static::SCHEDULE_ACTIVE, static::SCHEDULE_PAUSE]);
    }

    public function scopePromoteSchedule($query)
    {
        return $query->whereIn('promote_status', [static::SCHEDULE_ACTIVE, static::SCHEDULE_PAUSE]);
    }

    public static function setActiveStatus($ids)
    {
        if(is_array($ids)) {
            self::query()->whereIn('id', $ids)->update(['status' => static::ON_ACTIVE]);
        }
    }

    /**
     * встановлення робочого/неробочого статусу за графіком
     * @param $attribute
     */
    public function setScheduleActiveStatus($attribute, $statusAttribute)
    {
        if($this->$attribute instanceof Schedule ){
            if($this->$attribute->isActive()){
                $this->$statusAttribute = static::SCHEDULE_ACTIVE;
            }else{
                $this->$statusAttribute = static::SCHEDULE_PAUSE;
            }
            $this->save();
        }
    }

    /**
     * логування змін в моделях
     */
    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            LogAction::saveChangeAttribute($model, 'created');
        });

        self::updated(function($model){
            LogAction::saveChangeAttribute($model, 'updated');
        });

        // для полів, які вказані в масивах як readOnly або hidden для конкретних ролей - не зберігаємо їх нові значення
        self::updating(function (Model $model) {
            if(Auth::guest()) return;
            $readOnlyAttribute = $model->readOnlyAttribute[Auth::user()->role] ?? [];
            $hiddenAttribute = $model->hiddenAttribute[Auth::user()->role] ?? [];

            foreach ($model->getAttributes() as $attribute => $value) {
                if (in_array($attribute, $readOnlyAttribute)) {
                    $model->$attribute = $model->getOriginal($attribute);
                }
                if (in_array($attribute, $hiddenAttribute)) {
                    $model->$attribute = $model->getOriginal($attribute);
                }
            }
        });

        self::deleted(function($model){
            LogAction::saveChangeAttribute($model, 'deleted');
        });
    }

    public function isReadOnlyAttribute($attribute)
    {
        $readOnlyAttribute = $this->readOnlyAttribute[Auth::user()->role] ?? [];
        return in_array($attribute, $readOnlyAttribute);
    }

    public function isHiddenAttribute($attribute)
    {
        $hiddenAttribute = $this->hiddenAttribute[Auth::user()->role] ?? [];
        return in_array($attribute, $hiddenAttribute);
    }

    public function updateToken()
    {
        $token = Str::random(80);
        $this->api_token = hash('sha256', $token);
        $this->api_token_expiration = date('Y-m-d H:i:s', time() + $this->liveToken);
        $this->save();
    }

    /**
     * метод який викликається після оновлення токена - це заглушка, перевизначається в вищому класі
     */
    public function afterUpdateToken()
    {
        return;
    }

    /**
     * метод який викликається перед оновлення токена - це заглушка, перевизначається в вищому класі
     * повернення true означає переривання дії з виконнанням коду
     * @return bool
     */
    public function beforeUpdateToken()
    {
        return false;
    }

    /**
     * генерація нового токена - оновлення старого
     * @param $fields
     * @return array|bool
     */

    public static function getApiToken($fields)
    {
        if(!is_array($fields)) return [];

        $query = self::query();
        foreach ($fields as $name => $field) {
            $query->where($name, $field);
        }

        $model = $query->first();
        if ($model) {
            if ($model->status != static::ACTIVE) {
                return [
                    'status' => false,
                    'message' => 'Blocked',
                ];
            }
            if (($result = $model->beforeUpdateToken()) !== false){
                return $result;
            }
            $model->updateToken();
            $model->afterUpdateToken();
            return [
                'token' => $model->api_token,
                'expiration' => $model->liveToken - 60,
            ];
        }
        return [
            'status' => false,
            'message' => 'Not found',
        ];
    }
}
