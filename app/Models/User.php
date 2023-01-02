<?php

namespace App\Models;

use App\Entity\Photo;
use App\Entity\Schedule;
use App\Entity\TranslateParamBuilder;
use App\Models\Permanent\Cities;
use App\Models\Permanent\Role;
use App\Models\Traits\Filterable;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Str;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string|null $role
 * @property string $name
 * @property string $avatar
 * @property int $status 1-активний 2-відключений 3-видалений
 * @property string $last_active
 * @property int|null $id_provider id закладу
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @property int|null $provider_id id закладу
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @property int|null $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountId($value)
 * @property-read \App\Models\Provider|null $provider
 * @property int|null $city_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(\App\Http\Filters\FilterInterface $filter)
 * @property string|null $api_token
 * @property string|null $api_token_expiration
 * @method static \Illuminate\Database\Eloquent\Builder|User filterCity()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiTokenExpiration($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable;

    const ADMIN_ID  = 1;

    const ACTIVE    = 1;
    const DISACTIVE = 2;
    const DELETED   = 3;

    const DEFAULT_ICON = '/img/astronaut-icon.png';

    protected $liveSMS = 300; // час активності СМС коду в секундах
    protected $liveToken = 86400; // час активності токена в секундах

    protected static $listStatus = [
        self::ACTIVE    => 'активний',
        self::DISACTIVE => 'неактивний',
    ];

    public static function getListStatus()
    {
        return self::$listStatus;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleName()
    {
        return Role::getName($this->role);
    }

    public function getAvatarAttribute($value)
    {
        if(empty($value)) return self::DEFAULT_ICON;
        $fileName = '/upload/'.class_basename(self::class).'/'.$value;
        if(file_exists(storage_path('app/public') .$fileName)) return asset('/storage'.$fileName);
        return self::DEFAULT_ICON;
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function getCityName()
    {
        return Cities::getName($this->city_id,'name');
    }

    public function isReadOnlyAttribute($attribute)
    {
        return false;
    }

    public function isHiddenAttribute($attribute)
    {
        return false;
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
            'login'       => 'Логін',
            'password'    => 'Пароль',
            'role'        => 'Роль',
            'name'        => 'Ім\'я',
            'avatar'      => 'Аватар',
            'city_id'     => 'Місто',
            'status'      => 'Статус',
            'last_active' => 'Остання активність',
            'provider_id' => 'Заклад',
        ];
    }

    public function saveModel($data)
    {
        $city_id = $data['city_id'] ?? null;
        if(Auth::user()->city_id) $city_id = Auth::user()->city_id;

        $this->login = $data['login'];
        if(!empty($data['password'])) $this->password = Hash::make($data['password']);
        $this->name = $data['name'];
        $this->role = $data['role'];
        $this->status = $data['status'];
        $this->provider_id = intval($data['provider_id']) > 0 ? intval($data['provider_id']) : null;
        $this->city_id = $city_id;
        if(in_array($this->role, ['admin', 'master'])) $this->provider_id = null;
        if(isset($data['avatar']) && $data['avatar']) {
            $this->avatar = Photo::make(class_basename(self::class), $data['avatar'])->getFileName();
        }
        $this->saveOrFail();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function (Model $model) {
            LogAction::saveChangeAttribute($model, 'creating');
        });

        self::updating(function($model){
            LogAction::saveChangeAttribute($model, 'updating');
        });

        self::deleting(function($model){
            LogAction::saveChangeAttribute($model, 'deleting');
        });
    }

    public function updateToken()
    {
        $token = Str::random(80);
        $this->api_token = hash('sha256', $token);
        $this->api_token_expiration = date('Y-m-d H:i:s', time() + $this->liveToken);
        $this->save();
    }

    public static function getApiToken($login, $password)
    {
        $user = User::where('login', $login)->first();
        if($user){
            if($user->status != User::ACTIVE) return [
                'status' => false,
                'message' => 'Blocked',
            ];
            if (Hash::check($password, $user->password)) {
                $user->updateToken();
                return [
                    'status' => true,
                    'token' => $user->api_token,
                    'expiration' => $user->liveToken - 60,
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Not found',
        ];
    }

    public static function parseHistory($change_params)
    {
        $res = [];
        foreach ($change_params as $param => $value){
            if(isset(self::attributeLabels()[$param])){
                $res[] = TranslateParamBuilder::build($param, $value)
                    ->setAttributes(self::attributeLabels())
                    ->city()
                    ->status(self::getListStatus())
                    ->role()
                    ->make();
            }
        }
        return $res;
    }
}
