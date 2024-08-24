<div class="modal fade" id="scoreModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-image">
                <h3 class="modal-title border-bottom"> {{ __('Update Score') }} </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pb-4 text-align-center">
                    <div class="col-md-12 mb-2 mt-2">
                        {!! Form::open(['route' => ['students.update-scores', $studentId], 'method' => 'PUT']) !!}
                        <div class="row">
                            <div class="col-md-4"> {{ __('Score') }} :</div>
                            <div class="col-md-8 d-flex gap-2">
                                {!! Form::text('scores[' . $subjectId . '][score]', $score, [
                                    'class' => 'form-control score-value',
                                    'required',
                                    'id' => 'scoreInput',
                                ]) !!}
                                {!! Form::button('<i class="bi bi-check2-circle"></i>', [
                                    'class' => 'btn btn-primary update-score-btn',
                                    'type' => 'submit',
                                ]) !!}
                            </div>
                        </div>
                        <span id="error" class="mt-2 col-8 text-danger float-end"></span>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('admin/js/update-score.js') }}"></script>
