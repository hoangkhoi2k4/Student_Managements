@extends('admin.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-title">
                    <h1>
                        {{ __('Account') }}
                    </h1>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $user->avatar }}" alt="user-avatar" class="d-block rounded" height="100"
                             width="100"/>
                        <form class="button-wrapper" method="post"
                              action="{{ route('profile.update-avatar', $user->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="upload" class="btn btn-outline-secondary  me-2 mb-4" tabindex="0">
                                <span><i class="bi bi-upload"></i> {{ __('Change Avatar') }} </span>
                                <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                                       accept="image/*" onchange="this.form.submit()"/>
                            </label>
                            @if ($errors->has('avatar'))
                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                        </form>
                    </div>
                    @can('show_their_transcript')
                        <div class="mt-5">
                            <a href="{{ route('students.subject', auth()->user()->student->id) }}"
                               class="btn btn-primary">
                                {{ __('My Transcript') }}</a>
                        </div>
                    @endcan
                </div>
                <hr class="my-0"/>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label"> {{ __('Student Code') }} </label>
                            <input class="form-control" type="text" value="{{ $user->student->student_code }}"
                                   disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label"> {{ __('Student Name') }} </label>
                            <input class="form-control" type="text" value="{{ $user->name }}" disabled/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" value="{{ $user->email }}" disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input class="form-control" type="text" value="{{ $user->student->phone }}" disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label"> {{ __('Birthday') }} </label>
                            <input class="form-control" type="text" value="{{ $user->student->birthday }}" disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label"> {{ __('Address') }} </label>
                            <input class="form-control" value="{{ $user->student->address }}" disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label"> {{ __('Gender') }} </label>
                            <input class="form-control"
                                   value="{{ \App\Enums\Gender::getLabel($user->student->gender) }}"
                                   disabled/>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label"> {{ __('Department') }} </label>
                            <input class="form-control" value="{{ $user->student->department->name }}" disabled/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
