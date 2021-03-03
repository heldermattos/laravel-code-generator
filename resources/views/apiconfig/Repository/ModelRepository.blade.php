{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Contratcts\ApiResourceRepositoryInterface;

class {{CodeHelper::plural($model->name)}}Repository implements ApiResourceRepositoryInterface
{
    protected $uri = "{{$model->base_uri}}";

    public function list(Request $request)
    {
        $res = Http::get($this->uri . $request->getRequestUri());

        return response()->json($res->json(), $res->status());
    }

    public function item(Request $request, $id)
    {
        $res = Http::get($this->uri . $request->getRequestUri());

        return response()->json($res->json(), $res->status());
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
