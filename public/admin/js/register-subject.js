

function viewModal2() {
    const checkboxes = document.querySelectorAll('.subjects:checked');
    const subjectsContainer = document.getElementById('subjectsContainer');

    subjectsContainer.innerHTML = '';

    checkboxes.forEach(checkbox => {
        const subjectId = checkbox.getAttribute('data-id');
        const subjectName = checkbox.getAttribute('data-name');
        const inputHtml = `
            <div class="mb-3 col-6">
                <input type="text" value="${subjectName}" class="form-control" readonly/>
                <input type="hidden" name="subject_id[${subjectId}]" value="${subjectId}"/>
            </div>
        `
    ;
        subjectsContainer.insertAdjacentHTML('beforeend', inputHtml);
    });

    var myModal = new bootstrap.Modal(document.getElementById('registerSubjectModal'), {});
    myModal.show();
}