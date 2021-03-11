{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Controllers;

use App\Traits\HttpService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class {{$model->name}}Controller extends Controller
{
    use HttpService;

    protected $msBaseUrl = "";
    
    protected $msSecretKey = "";

    protected $request = "";

    public function __construct(Request $request)
    {
        $this->msBaseUrl = config('microservices.{{$model->name}}.base_url');

        $this->msSecretKey = config('microservices.{{$model->name}}.secret_key');

        $this->request = $request;
    }
    
    public function list()
    {
        return $this->get();
    }

    public function item()
    {
        return $this->get();
    }

    public function create()
    {
        return $this->post();
    }

    public function update()
    {
        return $this->put();
    }

    public function patch()
    {
        return $this->patch();
    }

    public function delete()
    {
        return $this->delete();
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
