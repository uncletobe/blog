<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

/**
 * Управление категориями блога
 *
 * @package App\Http\Controllers\Blog\Admin
 */
class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$paginator = BlogCategory::paginate(15);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        //$categoryList = BlogCategory::all();

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogCategoryCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

 //       Ушло в обсервер
//        if(empty($data['slug'])) {
//            $data['slug'] = Str::slug($data['title']);
//        }

        //Создаст объект и добавит в БД
//        $item = new BlogCategory($data);
//        $item->save();

        //

        $item = (new BlogCategory($data))->create($data); //второй вариант

        if($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                -withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
        //$categoryRepository = app(BlogCategoryRepository::class); либо, как в скобках(аргументы экшона) лара создаст сам

//        $item = BlogCategory::find($id);
//        $item = BlogCategory::findorFail($id);
//        $item = BlogCategory::where('id', $id)->first();

//        $item = BlogCategory::findorFail($id);
//        $categoryList = BlogCategory::all();

        $item = $categoryRepository->getEdit($id);
//
//        $v['title_before'] = $item->title; //Получили из базы и аксессор в модели BlogCategory
//        // getTitleAttribute($valueFromObject)
//        //автоматом применится к данным с базы ПРИ ВЫВОДЕ
//
//        $item->title = 'Asasadadd qasad 1213'; //При сохранении в объект срабатывает мутатор!
//        // setTitleAttribute($incomingValue)
//
//        $v['title_after'] = $item->title;
//        $v['getAttribute'] = $item->getAttribute('title');
//        $v['attributesToArray'] = $item->attributesToArray();
//        $v['attributes'] = $item->attrbute['title'];
//        $v['getAttributeValue'] = $item->getAttributeValue('title');
//        $v['getMutatedAttribute'] = $item->getMutatedAttributes(); //Получить поля, для которых есть мутаторы
//        $v['hasGetMutator for title'] = $item->hasGetMutator('title');
//        $v['toArray'] = $item->toArray();
//
//        dd($v, $item);

        if(empty($item)) {
            abort(404);
        }
        $categoryList = $categoryRepository->getForComboBox();


        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
//        $rules = [
//            'title' => 'required|min:5|max:200',
//            'slug' => 'max:200',
//            'description' => 'string|max:500|min:3',
//            'parent_id' => 'required|integer|exists:blog_categories,id',
//        ];


        //$validateData = $this->validate($request, $rules);

        //$validateData = $request->validate($rules);

        //$item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);

        if(empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"]) //запись в сессию
                ->withInput(); //на шаг назад с возвратом предыдущих данных(введенных юзером)
        }

        $data = $request->all();

//        Ушло в обсеревер
//        if(empty($data['slug'])) {
//            $data['slug'] = Str::slug($data['title']);
//        }

        $result = $item->fill($data)->save();
        //$result = $item->update($data);

        if($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }


}


























