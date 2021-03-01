{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class {{$model->name}}Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
