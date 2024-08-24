@extends('admin.app')
@section('content')
    <div class="card p-4">
        <div class="border-bottom d-flex justify-content-between">
            <div class="card-title d-flex align-items-center gap-5">
                <div>
                    <img width="100" height="100" src="/{{ $students->avatar }}" alt="">
                </div>
                <div>
                    <h1 class="text-primary">
                        {{ $students->user->name }} - {{ $students->student_code }}
                    </h1>
                    <p class="d-flex gap-4">
                        <span>
                            <i class="bi bi-cake2"></i> {{ date('d-m-Y', strtotime($students->birthday)) }}
                        </span>
                        <span>
                            <i class="bi bi-envelope-at"></i> {{ $students->user->email }}
                        </span>
                        <span>
                            <i class="bi bi-telephone-inbound"></i> {{ $students->phone }}
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ isset(auth()->user()->student->id) ? route('profile.edit') : route('students.index') }}"
                    class="btn btn-info">{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-content">
            <h2 class="card-content__title mt-4 d-flex justify-content-between">
                <div>
                    {{ __('Subject List') }}
                </div>
                <div>
                    @canany(['register_subject', 'self_register_subject'])
                        <a href="{{ route('students.register-subject', $students->id) }}" class="btn btn-primary">+
                            {{ __('Register Subject') }}</a>
                    @endcanany
                </div>
            </h2>
            <div class="card-subject__add-subjects pb-3" id="form-update">
                <div class="pb-3 ">
                    <form id="updateScoreForm" method="POST"
                        action="{{ route('students.update-scores', $students->id) }}">
                        @csrf
                        @method('PUT')
                        <div id="subjectsContainer">
                            @if (session()->has('old_html'))
                                @foreach (session('old_html') as $subjectId => $score)
                                    <div class="old_html">
                                        <div class="d-flex justify-content-center subjects gap-2 p-2">
                                            <div class="col-8">
                                                <select name="subject[]" class="form-control">
                                                    <option value="">Chọn 1 môn học</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ $subject->id == $subjectId ? 'selected' : '' }}>
                                                            {{ $subject->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subject.' . $loop->index)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="scores[{{ $subjectId }}][score]"
                                                    value="{{ is_array($score) ? implode(', ', $score) : $score }}" />
                                                @error('scores.' . $subjectId . '.score')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-1">
                                                <a class="removeBtn text-white btn btn-danger">x</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="submit" id="btn-submit"
                            class="btn btn-primary d-none mt-2">{{ __('Update Score') }}</button>
                        @can('update_score')
                            <button type="button" class="btn btn-success mt-2" id="addBtn">+ {{ __('Add Score Subject') }}
                            @endcan
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-content__content table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>{{ __('STT') }}</th>
                        <th>{{ __('Subject Name') }}</th>
                        <th>{{ __('Score') }}</th>
                    </thead>
                    <tbody>
                        @forelse ($students->subjects as $index => $subject)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subject->name }}</td>
                                <td class="col-2">
                                    <div class="position-relative">
                                        <input type="text" disabled name="score" id="get-score-{{ $subject->id }}"
                                            class="form-control pr-5"
                                            value="{{ $subject->pivot->score !== null ? $subject->pivot->score : 'Chưa có điểm' }}" />
                                        @can('update_score')
                                            <button type="button"
                                                onclick="viewModal(`{{ route('students.edit-score', [$students->id, $subject->id]) }}`)"
                                                class="btn btn-outline-warning position-absolute"
                                                style="top: 0; right: 0; height: 100%;">
                                                @if ($subject->pivot->score)
                                                    <i class="bi bi-pen"></i>
                                                @else
                                                    <i class="bi bi-plus"></i>
                                                @endif
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">{{ __('No data') }}</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td @can('update_score') colspan="2" @else colspan="1" @endcan></td>
                            <td class="col-2">
                                {{ __('Score Average') }} :<b> <b>{{ $students->subjects->avg('pivot.score') ?? 0.0 }}</b>
                                </b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if (session()->has('old_html'))
        @php
            $old_html = session('old_html');
        @endphp

        <script>
            window.old_html = @json($old_html);
        </script>
    @endif
    <script src="{{ asset('admin/js/update-scores.js') }}"></script>
@endsection
