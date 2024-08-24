@can('update_student')
    <div class="modal fade" id="updateStudentModal" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content data">
                <div class="modal-header modal-header-image">
                    <h1 class="modal-title border-bottom">{{ __('Update Student') }}</h1>
                    <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row pb-4 text-align-center">
                        <div class="card-form row">
                            {!! Form::open([
                                'enctype' => 'multipart/form-data',
                                'id' => 'updateForm',
                                'data-id' => $student->id,
                            ]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="w-75" style="max-height: 200px" src="/{{ $student->avatar }}"
                                        alt="">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    {!! Form::label('avatar', __('Change Avatar'), ['class' => 'mb-1']) !!}
                                    {!! Form::file('avatar', ['class' => 'form-control', 'accept' => 'image/*', 'id' => 'avatar']) !!}
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    {!! Form::label('name', __('Student Name'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::text('name', $student->user->name, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Student Name'),
                                        'id' => 'name',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    {!! Form::label('email', __('Email'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::email('email', $student->user->email, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Email'),
                                        'id' => 'email',
                                        'disabled',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    {!! Form::label('phone', __('Phone'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::number('phone', $student->phone, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Phone'),
                                        'id' => 'phone',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    {!! Form::label('gender', __('Gender'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::select('gender', [true => __('Male'), false => __('Female')], $student->gender, [
                                        'class' => 'form-control',
                                        'placeholder' => '--' . __('Choose Gender') . '--',
                                        'id' => 'gender',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    {!! Form::label('birthday', __('Birthday'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::date('birthday', $student->birthday, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Birthday'),
                                        'id' => 'birthday',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    {!! Form::label('address', __('Address'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::text('address', $student->address, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Address'),
                                        'id' => 'address',
                                    ]) !!}
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    {!! Form::label('department_id', __('Choose Department'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                                    {!! Form::select('department_id', $departments, $student->department_id, [
                                        'class' => 'form-control',
                                        'placeholder' => '--' . __('Choose Department') . '--',
                                        'id' => 'department_id',
                                    ]) !!}
                                </div>
                                <div class="form-group mb-3">
                                    {!! Form::label('password', __('Password'), ['class' => 'mb-1']) !!} <small
                                        class="text-secondary">({{ __('If want to update password') }})</small>
                                    {!! Form::text('password', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Password'),
                                        'id' => 'password',
                                    ]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::submit(__('Update Student'), ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/js/update-ajax.js') }}"></script>
@endcan
