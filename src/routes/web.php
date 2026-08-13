<?php

use Illuminate\Support\Facades\Route;

Route::get('', 'MessengerController@index')->name(config('messenger.routes.prefix'));
Route::post('messenger/store', 'MessengerController@store')->name('messenger.store');
Route::get('messenger/user', 'MessengerController@getUser')->name('messenger.user.select');
Route::get('messenger/user/conversation', 'MessengerController@getUserConversation')->name('messenger.user.conversation');
Route::get('messenger/message/{id}/render', 'MessengerController@renderMessageHtml')->name('messenger.message.render');
Route::get('messenger/threads/render', 'MessengerController@renderThreadsHtml')->name('messenger.threads.render');
Route::delete('messenger/delete', 'MessengerController@destroy')->name('messenger.delete');
Route::post('messenger/mode/update', 'MessengerController@updateMessengerMode')->name('messenger.mode.update');
Route::post('messenger/message/seen', 'MessengerController@messageSeen')->name('messenger.message.seen');