{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Repository;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use {{$model->complete_name}};
use App\Contratcts\ApiResourceRepositoryInterface;
use App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}}Collection;
use App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}} as {{$model->name}}Resource;

class {{CodeHelper::plural($model->name)}}Repository implements ApiResourceRepositoryInterface
{
    public function list(Request $request)
    {

    }

    public function item(Request $request, $id)
    {

    }

    public function create(Request $request)
    {


    }

    public function update(Request $request, $id)
    {



    }

    public function patch(Request $request, $id)
    {

    }

    public function delete(Request $request, $id)
    {

    }

    public function listRelative(Request $request, $id, $rel)
    {

    }

    public function createRelative(Request $request, $id, $rel)
    {
        
    }

    public function updateRelative(Request $request, $id, $rel)
    {
        
    }

    public function uploadFiles(Request $request, $id)
    {
        
    }
}
