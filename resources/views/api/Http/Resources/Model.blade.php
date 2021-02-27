{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{CodeHelper::plural($model->name)}}\Http\Resources;

use App\Services\AppJsonResource;

class {{$model->name}} extends AppJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $default = [
            'id' => $this->id,
            'name' => $this->name
        ];

        $result = $this->building($request);

        return $result['builded'] ? $result['data'] : $default;
    }
}
