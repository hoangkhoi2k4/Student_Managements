@extends('admin.app')
@section('content')
    <div class="card p-4">
        <div class="card-title">
            <h1 class="text-primary">{{ $content = isset($subject) ? __('Update Subject') : __('Create Subject') }}
            </h1>
        </div>
        @if (isset($subject))
            {!! Form::model($subject, [
                'route' => ['subjects.update', $subject->id],
                'method' => 'PUT',
                'class' => 'w-100',
            ]) !!}
        @else
            {!! Form::open([
                'route' => ['subjects.store'],
                'method' => 'POST',
                'class' => 'w-100',
            ]) !!}
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('name', __('Subject Name')) !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Subject Name'),
                ]) !!}
                @if ('errors')
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('name', __('Description')) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'placeholder' => __('Description'),
                ]) !!}
                @if ('errors')
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>

        </div>

        <div class="form-group mt-2">
            {!! Form::submit($content, ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
            <a href="{{ route('subjects.index') }}" class="btn btn-info">{{ __('Back') }}</a>
            @can('destroy_subject')
                @if (isset($subject))
                    @if (!in_array($subject->id, $subjectsHasScores->toArray()))
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['subjects.destroy', $subject->id],
                            'style' => 'display:inline;',
                        ]) !!}
                        {!! Form::button(__('Delete'), [
                            'type' => 'submit',
                            'class' => 'btn btn-danger',
                            'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                        ]) !!}
                        {!! Form::close() !!}
                    @endif
                @endif
            @endcan
        </div>
    </div>
@endsection
