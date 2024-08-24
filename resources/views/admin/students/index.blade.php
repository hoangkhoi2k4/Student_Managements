@extends('admin.app')

@section('content')
    <style>
        .badges {
            width: 25px;
            font-size: 1em;
            border-radius: 20px;
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
        }
    </style>

    <div class="card p-4 table-responsive">
        <h1>{{ __('Student List') }}</h1>

        <div class="mb-4">
            @can('create_student')
                <a href="{{ route('students.create') }}" class="btn btn-primary">+ {{ __('Create Student') }}</a>
            @endcan
            @can('import_excel')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importExcel">
                    <i class="bi bi-filetype-xlsx"></i> {{ __('Import Scores By Excel') }}
                </button>
            @endcan
        </div>

        {{ Form::open(['method' => 'GET', 'route' => 'students.index']) }}
        <div class="filter row mb-4">
            <!-- PAGINATION -->
            <div class="col-6 col-md-2">
                <div class="d-flex align-items-center gap-1">
                    <span>{{ __('Show') }}</span>
                    {!! Form::select(
                        'size',
                        [10 => 10, 50 => 50, 200 => 200, 500 => 500, 1000 => 1000, 2000 => 2000, 3000 => 3000],
                        request('size'),
                        ['class' => 'form-select', 'id' => 'pagination'],
                    ) !!}
                    <span>{{ __('entries') }}</span>
                </div>
            </div>
            <!-- PAGINATION END -->
        </div>

        <div class="row mb-4">
            <!-- Age Filter -->
            <div class="col-md-3">
                <div class="d-flex align-items-center gap-1">
                    <span>{{ __('Age From') }}</span>
                    {{ Form::number('age_from', request('age_from'), ['class' => 'form-control']) }}
                    <span>{{ __('To') }}</span>
                    {{ Form::number('age_to', request('age_to'), ['class' => 'form-control']) }}
                </div>
            </div>
            <!-- Score Filter -->
            <div class="col-md-3 mb-2">
                <div class="d-flex align-items-center gap-1">
                    <span>{{ __('Score Average') }}</span>
                    {{ Form::number('score_from', request('score_from'), ['class' => 'form-control']) }}
                    <span>{{ __('To') }}</span>
                    {{ Form::number('score_to', request('score_to'), ['class' => 'form-control']) }}
                </div>
            </div>
            <!-- Network Filter -->
            <div class="col-md-2 mb-2">
                {{ Form::select('network[]', \App\Enums\Network::getSelectOptions(), request('network'), ['class' => 'form-select', 'multiple' => true]) }}
            </div>
            <!-- Status Filter -->
            <div class="col-md-2 mb-2">
                {{ Form::select('status[]', \App\Enums\Status::getSelectOptions(), request('status'), ['class' => 'form-select', 'multiple' => true]) }}
            </div>
            <!-- Actions -->
            <div class="col-md-2">
                <a href="{{ route('students.index') }}" class="btn btn-info"><i class="bi bi-arrow-clockwise"></i></a>
                {{ Form::button('<i class="bi bi-search"></i>', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
            </div>
        </div>
        {{ Form::close() }}

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Student Code') }}</th>
                    <th>{{ __('Student Name') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Birthday') }}</th>
                    <th>{{ __('Status') }}</th>
                    {{-- @canany(['update_student', 'destroy_student']) --}}
                    @hasrole('Super Admin')
                        <th class="col-3 mb-1">{{ __('Action') }}</th>
                    @endhasrole
                    {{-- @endcanany --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_code }}</td>
                        <td>{{ $student->user->name }}</td>
                        <td>{{ \App\Enums\Gender::getLabel($student->gender) }}</td>
                        <td>{{ date('d/m/Y', strtotime($student->birthday)) }}</td>
                        <td>
                            @switch($student->status)
                                @case(4)
                                    <span class="badge bg-danger">{{ __('Banned') }}</span>
                                @break

                                @case(1)
                                    <span class="badge bg-primary">{{ __("Haven't studied yet") }}</span>
                                @break

                                @case(2)
                                    <span class="badge bg-info">{{ __('Studying') }}</span>
                                @break

                                @case(3)
                                    <span class="badge bg-success">{{ __('Finished') }}</span>
                                @break
                            @endswitch
                        </td>
                        @hasrole('Super Admin')
                            <td>
                                {{-- @can('show_student') --}}
                                <a href="#" onclick="viewModal(`{{ route('students.show', $student->id) }}`)"
                                    class="btn btn-info"><i class="bi bi-eye-fill"></i>
                                </a>
                                {{-- @endcan --}}
                                {{-- @can('update_student') --}}
                                <a href="#" onclick="viewModal(`{{ route('students.edit', $student->id) }}`)"
                                    class="btn btn-warning"><i class="bi bi-pencil-square"></i>
                                </a>
                                {{-- @endcan --}}
                                {{-- @can('destroy_student') --}}
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['students.destroy', $student->id],
                                    'style' => 'display:inline;',
                                ]) !!}
                                {!! Form::button('<i class="bi bi-trash-fill"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger',
                                    'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                                ]) !!}
                                {!! Form::close() !!}
                                {{-- @endcan --}}
                                {{-- @can('list_subject_registed') --}}
                                <a href="{{ route('students.subject', $student->id) }}" title="Xem những môn đang học"
                                    class="btn btn-secondary position-relative"><i class="bi bi-list-check"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badges rounded-pill bg-danger">
                                        {{ $student->subjects->count('id') }}
                                    </span>
                                </a>
                                {{-- @endcan --}}
                            </td>
                        @endhasrole
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-2">
            <div>
                {{ __('Show') }} {{ $students->count() }} {{ __('of') }} {{ $students->total() }}
                {{ __('student') }}
            </div>
            <div>
                {{ $students->appends(request()->all())->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title border-bottom">{{ __('Import Scores By Excel') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="{{ route('students.get-template') }}">
                        {{ __('Please Download Excel Template Here') }}
                    </a>
                    {!! Form::open([
                        'url' => route('students.import'),
                        'method' => 'POST',
                        'id' => 'importExcelForm',
                        'class' => 'mt-2',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="col-12 mb-2">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                    </div>
                    <span class="text-danger mb-3" id="error"></span>
                    <div class="form-group mt-2">
                        {!! Form::submit(__('Confirm'), ['class' => 'btn btn-primary', 'accept/xlsx, csv']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/upload-excel.js') }}"></script>
@endsection
