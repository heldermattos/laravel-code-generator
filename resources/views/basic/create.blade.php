@@extends('layouts.app')
@@section('content')
<div class="container">
    <h1> {{CodeHelper::title($model->name)}} Create </h1>
    @@if ($errors->any())
    <ul class="alert alert-danger">
        @@foreach ($errors->all() as $error)
        <li>@{{ $error }}</li>
        @@endforeach
    </ul>

    @@endif

    <form action="{{CodeHelper::doubleCurlyOpen()}}route('{{CodeHelper::slug(CodeHelper::plural($model->name))}}.store'){{CodeHelper::doubleCurlyClose()}}" method="POST">
        @@csrf
        @foreach($model->relations as $rel)
        @if($rel->type === 'BelongsTo')
        <div class="form-group">
            <label for="{{$rel->local_key}}">{{CodeHelper::title($rel->name)}}</label>
            <select class="form-control" name="{{$rel->local_key}}" id="{{$rel->local_key}}">
                {{CodeHelper::arroba()}}foreach((\{{$rel->model->complete_name}}::all() ?? [] ) as ${{$rel->name}})
                <option value="{{CodeHelper::doubleCurlyOpen()}}${{$rel->name}}->id{{CodeHelper::doubleCurlyClose()}}">{{CodeHelper::doubleCurlyOpen()}}${{$rel->name}}->{{collect($rel->model->columns)->first(function($col){
                    return $col == 'String'; })}}{{CodeHelper::doubleCurlyClose()}}</option>
                @@endforeach
            </select>
        </div>
        @endif
        @endforeach

        @foreach($model->table->columns as $column)
        @if(!CodeHelper::contains('/id$/',$column->name) && !CodeHelper::contains('/_at$/',$column->name))
        <div class="form-group">
            <label for="{{$column->name}}">{{CodeHelper::title($column->name)}}</label>
        @if($column->type=='Text')
            <textarea class="form-control"  name="{{$column->name}}" id="{{$column->name}}" cols="30" rows="10">{{CodeHelper::doubleCurlyOpen()}}old('{{$column->name}}'){{CodeHelper::doubleCurlyClose()}}</textarea>
        @else
            <input class="form-control {{$column->type}}" type="text" name="{{$column->name}}" id="{{$column->name}}" value="{{CodeHelper::doubleCurlyOpen()}}old('{{$column->name}}'){{CodeHelper::doubleCurlyClose()}}"
            @if($column->type == '\String')
            maxlength="{{$column->length}}"
            @endif
            @if(!$column->nullable)
            required="required"
            @endif
            >
            @endif
            @@if($errors->has('{{$column->name}}'))
            <p class="text-danger">{{CodeHelper::doubleCurlyOpen()}}$errors->first('{{$column->name}}'){{CodeHelper::doubleCurlyClose()}}</p>
        @@endif
        </div>
        @endif
        @endforeach
        <div>
            <button class="btn btn-primary" type="submit">Create</button>
            <a href="@{{ url()->previous() }}">Back</a>
        </div>
    </form>

</div>
@@endsection