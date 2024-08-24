$(document).ready(function () {
    $('#updateForm').on('submit', function (event) {
        event.preventDefault();

        let form = $(this);
        let formData = new FormData(form[0]);
        formData.append('_method', 'PUT');
        let id = form.data('id');
        $.ajax({
            url: 'students/'+id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $('#updateStudentModal').modal('hide');
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                $('.text-danger').remove();
                $.each(errors, function (field, messages) {
                    let input = $('[name="' + field + '"]');
                    let errorHtml = '<span class="text-danger">' + messages.join('<br>') + '</span>';
                    input.after(errorHtml);
                });
            }
        });
    });
});
