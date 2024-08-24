@extends('admin.app')
@section('content')
    <div class="card p-4">
        <h1>{{ __('Department List') }}</h1>
        @can('create_department')
            <div class="mb-4">
                <a href="{{ route('departments.create') }}" class="btn btn-primary">+ {{ __('Create Department') }}</a>
            </div>
        @endcan
        {{ Form::open(['method' => 'GET', 'route' => 'departments.index']) }}
        <div class="filter row mb-4">
            {{-- PAGINATION --}}
            <div class="col-6 col-md-2">
                <div class="d-flex align-items-center gap-1">
                    <span>{{ __('Show') }}</span>
                    {!! Form::select(
                        'size',
                        [
                            10 => 10,
                            20 => 20,
                            50 => 50,
                            100 => 100,
                        ],
                        request('size'),
                        [
                            'class' => 'form-select',
                            'id' => 'pagination',
                            'onchange' => 'this.form.submit()',
                        ],
                    ) !!}
                    <span> {{ __('entries') }} </span>
                </div>
            </div>
            {{-- PAGINATION END --}}
        </div>
        {!! Form::close() !!}
        <table class="table table-bordered">
            <thead>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Department Name') }}</th>
            <th>{{ __('Description') }}</th>
            @canany(['update_department','destroy_department'])
                <th>{{ __('Action') }}</th>
            @endcanany
            </thead>
            <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->id }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->description }}</td>
                    @canany(['update_department','destroy_department'])
                        <td>
                            @can('update_department')
                                <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd"
                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            @endcan
                            @can('destroy_department')
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['departments.destroy', $department->id],
                                'style' => 'display:inline;',
                            ]) !!}
                                {!! Form::button('<i class="bi bi-trash-fill"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger',
                                    'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                                ]) !!}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-12">
            {{ $departments->links() }}
        </div>
    </div>
@endsection
