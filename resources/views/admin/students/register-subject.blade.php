@extends('admin.app')
@section('content')
    <div class="card p-4">
        <div class="card-title">
            <h1 class="text-primary">
                {{ __('Register Subject') }}
            </h1>
        </div>
        {!! Form::open([
            'route' => ['students.store-register-subject', $id],
            'method' => 'POST',
            'class' => 'w-100',
        ]) !!}
        <div class="p-3">
            <div class="row">
                @forelse ($subjects as $subjectId => $name)
                    <div class="form-check col-md-4 col-6 mb-2">
                        {!! Form::checkbox('subject_id[]', $subjectId, false, ['class' => 'form-check-input']) !!}
                        {!! Form::label('subject_' . $subjectId, $name, ['class' => 'form-check-label']) !!}
                    </div>
                @empty
                    <p>{{ __('No Subject') }}</p>
                @endforelse
                @if ($errors->has('subject_id'))
                    <span class="text-danger">{{ $errors->first('subject_ids') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group mt-2">
            @if ($subjects->isNotEmpty())
                {!! Form::submit(__('Register Subject'), ['class' => 'btn btn-primary']) !!}
            @endif

            {!! Form::close() !!}
            <a href="{{ route('students.subject', $id) }}" class="btn btn-info">{{ __('Back') }}</a>
        </div>
    </div>
@endsection
