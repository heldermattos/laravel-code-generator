{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Repository;

use {{$model->complete_name}};
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Contratcts\ApiResourceRepositoryInterface;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}}Collection;
use App\Api\{{$options->version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}} as {{$model->name}}Resource;

class {{CodeHelper::plural($model->name)}}Repository implements ApiResourceRepositoryInterface
{
    use ProvidesConvenienceMethods,
        ApiResponser;

    public function list(Request $request)
    {
        switch ($request->get('type')) {
            case 's':
                $model = {{$model->name}}::search($request->get('q'))->constrain(new {{$model->name}});
                break;

            case 'cf':
                // custom filter
                break;

            case 'qb':
            default:
                $model = QueryBuilder::for({{$model->name}}::class);
                break;
        }

        if ((bool) $request->get('pg'))
        {
            $data
                = ($request->get('type') == 's')
                ? $model->paginate($request->get('size'))
                : $model->jsonPaginate();
        }
        else
        {
            $data = $model->get();
        }

        return new {{$model->name}}Collection($data);
    }

    public function item(Request $request, $id)
    {
        $data = {{$model->name}}::findOrFail($id);

        return new {{$model->name}}Resource($data);
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            @foreach($model->table->columns as $col)
                @if(!CodeHelper::contains('/^id$/',$col->name) && !CodeHelper::contains('/created_at$/',$col->name) && !CodeHelper::contains('/updated_at$/',$col->name) && !CodeHelper::contains('/deleted_at$/',$col->name))
                    @if(!$col->nullable)
                        @if(CodeHelper::contains('/^name$/',$col->name))
            '{{$col->name}}' => ['required','unique:{{$model->table->name}}'],
                            @else
            '{{$col->name}}' => ['required'],
                            @endif
                    @else
            '{{$col->name}}' => ['nullable'],
                    @endif
                @endif
            @endforeach
        ]);

        if (array_key_exists('model', $model->table->columns)) {
            $validated["model"] = $request->all();
        }

        $model = {{$model->name}}::create($validated);

        return $this->created($model);
    }

    public function update(Request $request, $id)
    {
        $model = {{$model->name}}::findOrFail($id);

        $validated = $this->validate($request, [
            @foreach($model->table->columns as $col) @if(!CodeHelper::contains('/^id$/',$col->name) && !CodeHelper::contains('/created_at$/',$col->name) && !CodeHelper::contains('/updated_at$/',$col->name) && !CodeHelper::contains('/deleted_at$/',$col->name)) @if(!$col->nullable) @if(CodeHelper::contains('/^name$/',$col->name))
            '{{$col->name}}' => ['required','unique:{{$model->table->name}},name,'.$id], 
            @else '{{$col->name}}' => ['required'], 
            @endif @else '{{$col->name}}' => ['nullable'],
            @endif
            @endif
            @endforeach
        ]);

        if (array_key_exists('model', $model->table->columns)) {
            $validated["model"] = $request->all();
        }


        $model->fill($validated);

        if ($model->isClean()) {
            return $this->isClean();
        }

        $model->save();

        return $this->updated();
    }

    public function patch(Request $request, $id)
    {

    }

    public function delete(Request $request, $id)
    {

    }

    public function listRelative(Request $request, $id, $rel)
    {
        $model = {{$model->name}}::find($id);

        if ($request->query("type") == "list") {

            $ucfirst = Str::ucfirst($rel);
            $singular = Str::singular($ucfirst);

            $data = $model->{$rel}()->jsonPaginate();

            $class = "App\Api\\$ucfirst\Http\Resources\\{$singular}Collection";

            return new $class($data);
        }
    }

    public function createRelative(Request $request, $id, $rel)
    {
        $model = {{$model->name}}::find($id);
    }

    public function updateRelative(Request $request, $id, $rel)
    {
        $model = {{$model->name}}::find($id);
    }

    public function uploadFiles(Request $request, $id)
    {
        $model = {{$model->name}}::find($id);
    }
}
