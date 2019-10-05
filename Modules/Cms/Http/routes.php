<?php

Route::group(['middleware' => 'web', 'prefix' => 'cms', 'namespace' => 'Modules\Cms\Http\Controllers'], function()
{
    Route::get('/', 'CmsController@index')->name('cms.index');
    
//     Route::get('/', function()
// {
// 	return Twitter::postTweet(['status' => 'Laravel is beautiful', 'format' => 'json']);
// });
});
