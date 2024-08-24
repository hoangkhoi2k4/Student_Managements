<div class="modal fade" id="" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content data">
            <div class="modal-header modal-header-image">
                <h3 class="modal-title border-bottom"><img width="30" class="rounded"
                        src="/{{ $student->avatar }}">|{{ $student->user->name }} -
                    {{ $student->student_code }} </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pb-4 text-align-center">
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4"> {{ __('Phone') }} :</div>
                            <div class="col-md-8 "> {{ $student->phone }} </div>
                        </div>
                    </div>
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4">Email:</div>
                            <div class="col-md-8 "> {{ $student->user->email }} </div>
                        </div>
                    </div>
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4"> {{ __('Gender') }} :</div>
                            <div class="col-md-8"> {{ $student->gender ? __('Male') : __('Female') }} </div>
                        </div>
                    </div>
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4"> {{ __('Birthday') }} :</div>
                            <div class="col-md-8"> {{ date('d/m/Y', strtotime($student->birthday)) ?? '' }} </div>
                        </div>
                    </div>
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4"> {{ __('Address') }} :</div>
                            <div class="col-md-8"> {{ $student->address }} </div>
                        </div>
                    </div>
                    <div class="col-md-12 border-bottom mb-2 mt-2">
                        <div class="row">
                            <div class="col-md-4"> {{ __('Department') }} :</div>
                            <div class="col-md-8"> {{ $student->department->name }} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
