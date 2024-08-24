@extends('admin.app')
@section('content')
    <div class="card p-4">
        <h3>{{ __('Create Role') }}</h3>
        <div class="col-lg-12 mx-auto">
            <div class="card">
                @if (isset($role))
                    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT', 'class' => 'w-100']) !!}
                @else
                    {!! Form::open(['route' => 'roles.store']) !!}
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('name', 'Tên quyền', ['class' => 'col-from-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', $role->name ?? null, ['placeholder' => 'Tên quyền', 'class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <h4 class="pt-4">Chọn quyền</h4>

                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <div class="p-2 border mt-1 mb-2">
                            <label class="d-flex">
                                <span>
                                    {!! Form::checkbox('selectAll', null, false, [
                                        'id' => 'selectAll',
                                        'style' => 'width:18px;height:18px;margin-top:5px;margin-right:5px',
                                    ]) !!}
                                    <span class="slider round"> Chọn tất cả quyền</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    @if ($errors->has('permissions'))
                        <span class="text-danger">{{ $errors->first('permissions') }}</span>
                    @endif
                    @foreach ($permission_groups as $groupIndex => $permission_group)
                        <ul class="list-group mb-4">
                            <li class="list-group-item bg-light" aria-current="true">
                                {{ __($permission_group[0]['group']) }}
                                {!! Form::checkbox('selectSection', null, false, [
                                    'class' => 'selectSection',
                                    'data-group' => $groupIndex,
                                    'style' => 'width:18px;height:18px;margin-left: 20px',
                                ]) !!}
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    @foreach ($permission_group as $permIndex => $permission)
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                            <div class="p-2 border mt-1 mb-2">
                                                <label class="d-flex">
                                                    <span>
                                                        {!! Form::checkbox('permissions[]', $permission->id, $role->permissions ?? false, [
                                                            'class' => 'permission-checkbox',
                                                            'data-group' => $groupIndex,
                                                            'style' => 'width:18px;height:18px;margin-top:5px;margin-right:5px',
                                                        ]) !!}
                                                        <span class="">{{ __($permission->name) }}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    @endforeach
                    <div class="form-group mb-3 mt-3 text-right">
                        {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.selectSection').forEach(selectSectionCheckbox => {
            selectSectionCheckbox.addEventListener('change', function () {
                const groupIndex = this.getAttribute('data-group');
                const checkboxes = document.querySelectorAll(
                    `input.permission-checkbox[data-group="${groupIndex}"]`);
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });

        // Handle global "Select All" functionality
        document.getElementById('selectAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            // Also update each section's "selectSection" checkbox
            document.querySelectorAll('.selectSection').forEach(selectSectionCheckbox => {
                selectSectionCheckbox.checked = this.checked;
            });
        });
    </script>
@endsection
