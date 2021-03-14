{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources;

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
        $result = $this->building($request);

        return $result['builded'] ? $result['data'] : $this->getDefault();
    }

    public function getDefault()
    {
        if (array_key_exists('model', $this->attributesToArray())) {
            $model = $this->model;
            $model["id"] = $this->id;
            return $model;
        } else {
            return [
                @foreach($model->table->columns as $col)
                    '{{$col->name}}' => $this->{{$col->name}},
                @endforeach
            ];
        }
    }
}
