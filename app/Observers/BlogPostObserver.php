<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    /**
     * Обработка ПЕРЕД созданием записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

        $this->setHtml($blogPost);

        $this->setUser($blogPost);
    }

    /**
     * Обработка ПЕРЕД обновлением записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
        $test[] = $blogPost->isDirty(); //Изменялась ли модель, вернет true, если хоть одно поле изменилось
        $test[] = $blogPost->isDirty('is_published'); //Проверяет, изменялось ли конкретное поле
        $test[] = $blogPost->isDirty('user_id');
        $test[] = $blogPost->getAttribute('is_published'); //значение измененного атрибута(которое сейчас запишется в базу)
        $test[] = $blogPost->is_published; //значение измененного атрибута(которое сейчас запишется в базу)
        $test[] = $blogPost->getOriginal('is_published'); //Старое значение, которое в базе


        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);
    }

    /**
     * @param App\Models\BlogPost $blogPost
     */
    public function deleting(BlogPost $blogPost)
    {
        //dd(__METHOD__, $blogPost);
        //return false; //действие не произойдет
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }


    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Если дата публикации не установлена и происходит отправка флага - опубликовано,
     * то устанавливаем дату публикации на текущую.
     *
     *
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost) {
        if(empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Если поле slug пустое, то заполняем его конвертацией заголовка
     *
     * @param BlogPost $blogPost
     *
     */
    protected function setSlug(BlogPost $blogPost) {
        if(empty($blogPost->slug)) {
            $blogPost->slug = \Str::slug($blogPost->title);
        }
    }

    /**
     * Установка значения полю content_html относительно content_raw
     *
     * @param BlogPost $blogPost
     */
    protected function setHtml(BlogPost $blogPost) {

        if($blogPost->isDirty('content_raw')) { //Изменилось ли отправленное поле, т.е. новые ли значения относ базы
            //TODO: тут должна быть генерация markdown -> html
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Если не указан user_id, то устанавливаем пользователя по-умолчанию
     *
     * @param BlogPost $blogPost
     *
     */
    protected function setUser(BlogPost $blogPost) {

        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER; //если авторизован, то берем id, иначе - ставим неизвестного
    }

}








































