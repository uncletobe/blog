<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class BlogCategory
 *
 * @package App\Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string $parentTitle
 */
class BlogCategory extends Model
{
    use SoftDeletes;

    /**
     * ID корня
     */
    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    public function parentCategory() {

        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Пример аксессора (Accessor)
     *
     * @return string
     */
    public function getParentTitleAttribute() { //Начинается с get Имяатрибута Attribute parent_title || parentTitle

        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корень'
                : '???');

        return $title;
    }

    /**
     * Является ли текущий элемент корнем
     * @return bool
     */
    public function isRoot() {
        return $this->id === BlogCategory::ROOT;
    }

    /* Аксессоры и мутаторы нужны, если нужно получить какое-то значение, как Атрибут, т.е. не в сыром виде,
        а как поле для БД
    */

//    /**
//     * Пример аксессора
//     *
//     * @param $valueFromObject
//     *
//     * @return bool|false|mixed|string|string[]|null
//     */
//    public function getTitleAttribute($valueFromObject)
//    {
//        return mb_strtoupper($valueFromObject);
//    }
//
//
//    /**
//     * Пример мутатора
//     *
//     * @param $incomingValue
//     *
//     */
//    public function setTitleAttribute($incomingValue) {
//        $this->attributes['title'] = mb_strtolower($incomingValue);
//    }



























}
