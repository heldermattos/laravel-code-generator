{!! CodeHelper::PHPSOL() !!}

Route::group([
    'prefix' => '{{CodeHelper::camel(CodeHelper::plural($model->name))}}'
], function ($router) {
    Route::get('/', '{{CodeHelper::plural($model->name)}}Controller@list');
    Route::get('/{id}', '{{CodeHelper::plural($model->name)}}Controller@item');
    Route::post('/{id}/files', '{{CodeHelper::plural($model->name)}}Controller@uploadFiles');
    Route::post('/', '{{CodeHelper::plural($model->name)}}Controller@create');
    Route::put('/{id}', '{{CodeHelper::plural($model->name)}}Controller@update');
    Route::patch('/{id}', '{{CodeHelper::plural($model->name)}}Controller@patch');
    Route::delete('/{id}', '{{CodeHelper::plural($model->name)}}Controller@delete');

    Route::get('/{id}/{rel}', '{{CodeHelper::plural($model->name)}}Controller@listRelative');
    Route::post('/{id}/{rel}', '{{CodeHelper::plural($model->name)}}Controller@createRelative');
});
