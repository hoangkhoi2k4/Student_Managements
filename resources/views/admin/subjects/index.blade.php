@extends('admin.app')
@section('content')
    <div class="card p-4">
        <h1>{{ __('Subject List') }}</h1>
        <div class="mb-4">
            @can('create_student')
                <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ {{ __('Create Subject') }}</a>
            @endcan
            @can('self_register_subject')
                <a href="#" onclick="viewModal2()" class="btn btn-warning btn-register d-none">+
                    {{ __('Register Subject') }}</a>
            @endcan
        </div>

        {{ Form::open(['method' => 'GET', 'route' => 'subjects.index']) }}
        <div class="filter row mb-4">
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
        </div>
        {!! Form::close() !!}
        <table class="table table-bordered">
            <thead>
                @can('self_register_subject')
                    <th>{{ __('Option') }}</th>
                @endcan
                <th>{{ __('ID') }}</th>
                <th>{{ __('Subject Name') }}</th>
                <th>{{ __('Description') }}</th>
                @canany(['update_subject', 'destroy_subject'])
                    <th class="col-2">{{ __('Action') }}</th>
                @endcanany
                @can('self_register_subject')
                    <th class="col-1">{{ __('Register Subject') }}</th>
                @endcan
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        @can('self_register_subject')
                            <td class="col-1">
                                <input type="checkbox" name="subjects[]" class="subjects"
                                    {{ in_array($subject->id, $unregistedSubject) ? 'disabled' : '' }}
                                    data-id="{{ $subject->id }}" data-name="{{ $subject->name }}"
                                    onchange="toggleUpdateButton('subjects', 'btn-register')">
                            </td>
                        @endcan
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->description }}</td>
                        @canany(['update_subject', 'destroy_subject'])
                            <td>
                                @can('update_subject')
                                    <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>
                                @endcan
                                @can('destroy_subject')
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['subjects.destroy', $subject->id],
                                        'style' => 'display:inline;',
                                    ]) !!}
                                    {!! Form::button('<i class="bi bi-trash-fill"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger',
                                        'onclick' => !in_array($subject->id, $subjectsHasScores->toArray())
                                            ? 'return confirm("' . __('Are you sure?') . '")'
                                            : 'return false',
                                        'disabled' => in_array($subject->id, $subjectsHasScores->toArray()) ? true : false,
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        @endcanany
                        @can('self_register_subject')
                            <td>
                                @if (!in_array($subject->id, $unregistedSubject))
                                    {!! Form::open([
                                        'route' => ['students.store-register-subject', auth()->user()->student->id],
                                        'style' => 'display:inline;',
                                    ]) !!}
                                    {!! Form::hidden('subject_id', $subject->id) !!}
                                    {!! Form::button('<i class="bi bi-plus"></i>', [
                                        'title' => __('Register'),
                                        'type' => 'submit',
                                        'class' => 'btn btn-primary',
                                        'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                                    ]) !!}
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::button('<i class="bi bi-check-lg"></i>', [
                                        'type' => 'button',
                                        'class' => 'btn btn-secondary',
                                        'disabled' => true,
                                    ]) !!}
                                @endif

                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-12 mt-2">
            {{ $subjects->appends(request()->all())->links() }}
        </div>
    </div>
    @can('self_register_subject')
        <div class="modal fade" id="registerSubjectModal" tabindex="-1" aria-labelledby="registerSubjectModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title border-bottom"> {{ __('Confirm') . ' ' . __('Register Subject') }} </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="registerSubjectForm" method="POST"
                            action="{{ route('students.store-register-subject', auth()->user()->student->id) }}">
                            @csrf
                            <div class="row" id="subjectsContainer"></div>
                            <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('admin/js/register-subject.js') }}"></script>
    @endcan
@endsection
