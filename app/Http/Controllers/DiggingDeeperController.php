<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
    /**
     *
     */
    public function collections() {
        $result = [];


        /**
         * @var \Illuminate\Database\Eloquent\Collection
         */
        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());


        /**
         * @var \Illuminate\Support\Collection
         */
        $collection = collect($eloquentCollection->toArray());

//        dd(
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection
//        );

//        $result['first'] = $collection->first();
//        $result['last'] = $collection->last();

//        $result['where']['data'] = $collection
//            ->where('category_id', 10) //where category_id = 10
//            ->values() //переиндексировать, т.е. массив с 0
//            ->keyBy('id'); //ключи массив
//
//        $result['where']['count'] = $result['where']['data']->count();
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();
//
//        //Получить первый эл. из кол-и, удовлетворяющий условию
//        $result['where_first'] = $collection
//            ->firstWhere('created_at', '>', '2019-01-17 01:35:11');
        
        //Базовая переменная не изменится, просто вернется измененная версия.
//        $result['map']['all'] = $collection->map(function (array $item) {
//           $newItem = new \stdClass(); //преобразовать массив в объект
//           $newItem->item_id = $item['id'];
//           $newItem->item_name = $item['title'];
//           $newItem->exists = is_null($item['deleted_at']);
//
//           return $newItem;
//        });
//
//
//        $result['map']['not_exists'] = $result['map']['all']
//            ->where('exists', '=', false)
//            ->values();


        //Базовая переменная изменится(трансформируется)
        $collection->transform(function (array $item) {
            $newItem = new \StdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;

        });

        //dd($collection);

//        $newItem = new \stdClass();
//        $newItem->id = 9999;
//
//        $newItem2 = new \stdClass();
//        $newItem2->id = 8888;

        //Установить элемент в начало коллекции
//        $newItemFirst = $collection->prepend($newItem);// в начало
//        $newItemLast = $collection->push($newItem2)->last(); // в конец
//        $pulledItem = $collection->pull(1); //забрать первый элемент, т.е. он удаляет его из кол-и и забирает в переменную

        //dd(compact('collection','newItemFirst', 'newItemLast', 'pulledItem'));


//        //Фильтоация. Замена orWhere()
//        $filtered = $collection->filter(function ($item) {
//           $byDay = $item->created_at->isFriday(); //isFriday карбоновский метод,т.к. мы трансформировали массив
//            //и полю created_at присвоили тип карбон
//           $byDate = $item->created_at->day == 12; //day карбоновский метод
//
//           $result = $item->created_at->isFriday() && ($item->created_at->day == 12);
//           $result = $byDay && $byDate;
//
//           return $result;
//        });
//
//        dd(compact('filtered'));

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));

    }
}














































































