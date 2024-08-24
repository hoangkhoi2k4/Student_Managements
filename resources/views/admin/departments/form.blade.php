@extends('admin.app')

@section('content')
    <div class="card p-4">
        <div class="card-title">
            <h1 class="text-primary">
                {{ $content = isset($department) ? __('Update Department') : __('Create Department') }}
            </h1>
        </div>
        @if (isset($department))
            {!! Form::model($department, [
                'route' => ['departments.update', $department->id],
                'method' => 'PUT',
                'class' => 'w-100',
            ]) !!}
        @else
            {!! Form::open([
                'route' => ['departments.store'],
                'method' => 'POST',
                'class' => 'w-100',
            ]) !!}
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('name', __('Department Name')) !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Department Name'),
                ]) !!}
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('description', __('Description')) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Description'),
                ]) !!}
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group mt-2">
            {!! Form::submit($content, ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
            <a href="{{ route('departments.index') }}" class="btn btn-info">{{ __('Back') }}</a>
            @can('destroy_department')
                @if (isset($department))
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['departments.destroy', $department->id],
                        'style' => 'display:inline;',
                    ]) !!}
                    {!! Form::button(__('Delete'), [
                        'type' => 'submit',
                        'class' => 'btn btn-danger',
                        'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                    ]) !!}
                    {!! Form::close() !!}
                @endif
            @endcan
        </div>
    </div>
@endsection
