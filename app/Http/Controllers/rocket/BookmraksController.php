<?php

namespace App\Http\Controllers\rocket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// подключение библиотеки кастомных методов
use App\Models\library\Base;

// подключение помощника
use Illuminate\Support\Facades\Auth;

class BookmraksController extends Controller
{
    /**
     * Страница закладок
     * @return mixed
     */
    public function bookmarks()
    {
        // сборка данных со стороны авторизованного пользователя
        Base::sessionRefresh();
        // сборка данных со стороны сервиса
        $localstorage = Base::getLocalstorage();

        // получение идентификатора авторизованного пользователя
        $user_id = Auth::id();

        // получение списка событий, которые авторизованный пользователь добавил в закладки
        $events = Base::getEventsList('list_events_bookmarks', $user_id);
        $events = Base::getEventsFinished($events);

        return view('rocketViews.bookmarks', [
            'localstorage' => $localstorage,
            'events' => $events
        ]);
    }

    /**
     * Добавляет событие в закладки
     */
    public function addBookmark($event_id)
    {
        return Base::addIds($event_id, 'bookmarks');
    }

    /**
     * Удаляет событие из закладок
     */
    public function removeBookmark($event_id)
    {
        return Base::removeIds($event_id, 'bookmarks');
    }
}