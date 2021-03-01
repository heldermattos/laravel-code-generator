{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Controllers;

use App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Repository\{{CodeHelper::plural($model->name)}}Repository;
use App\Http\Controllers\BaseApiController;

class {{$model->name}}Controller extends BaseApiController
{
    public function __construct({{CodeHelper::plural($model->name)}}Repository $model)
    {
        $this->model = $model;
    }
}
