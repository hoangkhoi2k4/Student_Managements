@extends('admin.app')
@section('content')
    <div class="card p-4">
        <h1>{{ __('Role List') }}</h1>
        @can('create_role')
            <div class="mb-4">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">+ {{ __('Create Role') }}</a>
            </div>
        @endcan
        <table class="table table-bordered table-responsive">
            <thead class="header">
            <tr>
                <th class="text-center">ID</th>
                <th>{{ __('Role Name') }}</th>
                @canany('update_role','destroy_role')
                    <th>{{ __('Action') }}</th>
                @endcanany
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td class="text-center col-1">{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="col-2 text-nowrap">
                        @can(['update_role'])
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd"
                                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                        @endcan
                        @can(['destroy_role'])
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['roles.destroy', $role->id],
                                'style' => 'display:inline;',
                                'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                            ]) !!}
                            {!! Form::button('<i class="bi bi-trash-fill"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger',
                            ]) !!}
                            {!! Form::close() !!}
                        @endcan

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-2">
            {{ $roles->links() }}
        </div>
    </div>
@endsection
