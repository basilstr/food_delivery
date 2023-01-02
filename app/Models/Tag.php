<?php

namespace App\Models;

use App\Entity\Photo;
use App\Entity\TranslateParamBuilder;
use App\Models\Foods\Food;
use App\Models\BaseModels\AbstractBaseModel;
use Intervention\Image\Facades\Image;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $description
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Food[] $foods
 * @property-read int|null $foods_count
 * @property-read Tag|null $parentTag
 * @method static \Database\Factories\TagFactory factory(...$parameters)
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel moderation()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel promoteSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|AbstractBaseModel schedule()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereStatus($value)
 */
class Tag extends AbstractBaseModel
{
    const DEFAULT_ICON = '/img/tag_default.png';

    const UNVISIBLE  = 0;
    const VISIBLE    = 1;

    const ON_MODERATION = 0; // статус на модерації - вивід в окремий список
    const ON_ACTIVE = 1; // статус активності після пакетної зміни

    public static $listStatus = [
        self::UNVISIBLE  => 'невидимий', // не показується в додатку
        self::VISIBLE    => 'видимий',   // показується в додатку
    ];

    public function parentTag()
    {
        return $this->hasOne(Tag::class, 'id', 'parent_id');
    }

    public function getPhotoAttribute($value)
    {
        return $this->getUrlImage($value);
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value > 0 ? $value : null;
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_tags', 'tag_id', 'food_id');
    }

    /**
     * Перелік полів, які показуються в списку дій по моделі, ті, які не вказані тут - не будуть показуватись
     * @return string[]
     */
    public static function attributeLabels()
    {
        return [
            'name'        => 'Ім\'я',
            'status'      => 'Статус',
            'photo'       => 'Фото',
        ];
    }

    public function saveModel($data)
    {
        $this->parent_id = $data['parent_id'];
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->status = $data['status'] ?? self::VISIBLE;
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
                    ->status(self::getListStatus())
                    ->make();
            }
        }
        return $res;
    }
}
