{!! CodeHelper::PHPSOL() !!}

namespace App\Api\{{$version}}\{{CodeHelper::plural($model->name)}}\Repository;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use {{$model->complete_name}};
use App\Contratcts\ApiResourceRepositoryInterface;
use App\Api\{{$version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}}Collection;
use App\Api\{{$version}}\{{CodeHelper::plural($model->name)}}\Http\Resources\{{$model->name}} as {{$model->name}}Resource;

class {{CodeHelper::plural($model->name)}}Repository implements ApiResourceRepositoryInterface
{
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
        $data = {{$model->name}}::find($id);

        switch ($request->get('type')) {
            case 'doc':
                return new {{$model->name}}Doc($data);
                break;

            default:
                return new {{$model->name}}Resource($data);
                break;
        }
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
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

        $model = {{$model->name}}::create($validated);

        return response()->json([
            'id' => $model->id,
            'toast' => [
                'success',
                'Novo item criado com sucesso',
                'Criado'
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = {{$model->name}}::find($id);

        $validated = $request->validate([
            @foreach($model->table->columns as $col)
                @if(!CodeHelper::contains('/^id$/',$col->name) && !CodeHelper::contains('/created_at$/',$col->name) && !CodeHelper::contains('/updated_at$/',$col->name) && !CodeHelper::contains('/deleted_at$/',$col->name))
                    @if(!$col->nullable)
                        @if(CodeHelper::contains('/^name$/',$col->name))
            '{{$col->name}}' => ['required','unique:{{$model->table->name}},name,'.$id],
                        @else
            '{{$col->name}}' => ['required'],
                        @endif
                    @else
            '{{$col->name}}' => ['nullable'],
                    @endif
                @endif
            @endforeach
        ]);

        $model->fill($validated);

        $model->save();

        return response()->json([
            'toast' => [
                'success',
                'Alteração salva com sucesso!',
                'Salvo'
            ]
        ]);
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
