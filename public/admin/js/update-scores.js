async function listSubjects() {
    try {
        const response = await $.ajax({
            url: `/admin/list-subject-ajax`,
            type: 'GET',
        });

        if (response.success) {
            return response.subjects;
        } else {
            alert(response.message);
            throw new Error(response.message);
        }
    } catch (error) {
        console.error('Error:', error.message);
        throw new Error('An error occurred.');
    }
}

$(document).ready(async function() {
    const $subjectsContainer = $('#subjectsContainer');
    const subjects = await listSubjects();
    let selectedSubjectIds = [];

    if (window.old_html) {
        selectedSubjectIds = Object.keys(window.old_html);
    }

    function hideBtn() {
        if ($('#subjectsContainer').find('select').length >= subjects.length) {
            $('#addBtn').addClass('d-none');
        } else {
            $('#addBtn').removeClass('d-none');
        }
        
        if ($('#subjectsContainer').find('select').length <= 0) {
            $('#btn-submit').addClass('d-none');
        } else {
            $('#btn-submit').removeClass('d-none');
        }
    }

    function getSelectedValues() {
        const selectedValues = [];
        $('select').each((_, select) => {
            const value = $(select).val();
            if (value) {
                selectedValues.push(value);
            }
        });
        return Array.from(new Set(selectedValues));
    }
    

    function updateOptionHtml(currentValue) {
        const selectedValues = getSelectedValues();
        let optionsHtml = '<option value="">Chọn 1 môn học</option>';
        subjects.forEach(subject => {
            if (!selectedValues.includes(String(subject.id)) || subject.id === parseInt(currentValue)) {
                optionsHtml += `<option value="${subject.id}">${subject.name}</option>`;
            }
        });
        return optionsHtml;
    }
    

    function updateAllSelectOptions() {
        $('select').each((_, select) => {
            const $select = $(select);
            const currentValue = $select.val();
            const newOptionsHtml = updateOptionHtml(currentValue);
            $select.html(newOptionsHtml);
            if (currentValue) {
                $select.val(currentValue);
            }
        });
    }
    

    function addSelectForm() {
        const inputHtml = `
            <div class="d-flex justify-content-center subjects gap-2 p-2">
                <div class="col-8">
                    <select name="subject[]" class="form-control">
                        ${updateOptionHtml('')}
                    </select>
                    <span class="text-danger"></span>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control"/>
                    <span class="text-danger"></span>
                </div>
                <div class="col-1">
                    <a class="removeBtn text-white btn btn-danger">x</a>
                </div>
            </div>
        `;
    
        const $div = $(inputHtml);
        $subjectsContainer.append($div);
    
        const $selectElement = $div.find('select');
        const $removeBtn = $div.find('.removeBtn');
        
        $removeBtn.off('click').on('click', function () {
            $div.remove();
            selectedSubjectIds = selectedSubjectIds.filter(subjectId => subjectId !== $selectElement.val());
            updateAllSelectOptions();
            hideBtn();
        });
        
        $selectElement.off('change').on('change', function () {
            const selectedId = $(this).val();
            const $textInput = $div.find('input[type="text"]');
            $textInput.attr({
                name: `scores[${selectedId}][score]`,
                id: `score-${selectedId}`
            });
    
            const score = $(`#get-score-${selectedId}`).val() || '';
            $textInput.val(score);
            selectedSubjectIds = getSelectedValues();
            updateAllSelectOptions();
            hideBtn();
        });
    }
    

    $subjectsContainer.on('click', '.removeBtn', function () {
        $(this).closest('.old_html').remove();
        selectedSubjectIds = selectedSubjectIds.filter(subjectId => subjectId !== $(this).closest('.subjects').find('select').val());
        updateAllSelectOptions();
        hideBtn();
    });

    $('.old_html select').off('change').on('change', function () {
        const selectedId = $(this).val();
        const $parentDiv = $(this).closest('.old_html');
        const $textInput = $parentDiv.find('input[type="text"]');

        $textInput.attr({
            name: `scores[${selectedId}][score]`,
            id: `score-${selectedId}`
        });

        const score = $(`#get-score-${selectedId}`).val() || '';
        $textInput.val(score);
        selectedSubjectIds = getSelectedValues();
        updateAllSelectOptions();
        hideBtn();
    });
    
    $('#addBtn').off('click').on('click', () => {
        addSelectForm();
        hideBtn();
    });
    
    updateAllSelectOptions();
    hideBtn();
});
