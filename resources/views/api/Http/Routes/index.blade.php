{!! CodeHelper::PHPSOL() !!}

Route::group([
    'prefix' => '{{CodeHelper::snake(CodeHelper::plural($model->name))}}'
], function ($router) {
    Route::get('/', '{{$model->name}}Controller@list');
    Route::get('/{id}', '{{$model->name}}Controller@item');
    Route::post('/{id}/files', '{{$model->name}}Controller@uploadFiles');
    Route::post('/', '{{$model->name}}Controller@create');
    Route::put('/{id}', '{{$model->name}}Controller@update');
    Route::patch('/{id}', '{{$model->name}}Controller@patch');
    Route::delete('/{id}', '{{$model->name}}Controller@delete');

    Route::get('/{id}/{rel}', '{{$model->name}}Controller@listRelative');
    Route::post('/{id}/{rel}', '{{$model->name}}Controller@createRelative');
});
