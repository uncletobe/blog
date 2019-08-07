<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * class BlogCategoryRepository
 *
 * @package App\Repositories
 *
 */
class BlogCategoryRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {

        return Model::class;
    }

    /**
     * Get model for edit in adminpanel
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {

        return $this->startConditions()->find($id);
    }

    /**
     *
     * Get list of categories
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $fields = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) as id_title',
        ]);

//        $result[] = $this->startConditions()->all();
//
//        $result[] = $this
//            ->startConditions()
//            ->select('blog_categories.*',
//                \DB::raw('CONCAT (id, ". ", title) as id_title')) //raw - сырые данные, не можем писать классич. запрос через билдер
//            ->toBase() //не нужно агрегировать полученные данные в объекты класса BaseCategory
//            ->get();

        $result = $this
            ->startConditions()
            ->selectRaw($fields)
            ->toBase()
            ->get();

        return $result;

    }


    /**
     * Получить категории для вывода пагинатором
     *
     * @aram int | null $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function getAllWithPaginate($perPage = null)
    {

        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->with([
                'parentCategory:id,title' //связь из модели BlogCategory
            ])
            ->paginate($perPage);

        return $result;
    }


}
























