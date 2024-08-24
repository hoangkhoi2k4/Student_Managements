    $(document).ready(function() {
    $('#importExcelForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#error').text('');
                $('#importExel').modal('hide');
                alert('Import Successfully');
            },
            error: function(response) {
                if (response.responseJSON.errors.file) {
                    $('#error').text(response.responseJSON.errors.file);
                }
                if (response.responseJSON.message) {
                    $('#error').text(response.responseJSON.message);
                }
                if (response.status == 404) {
                    $('#error').text(response.responseJSON.errors[0]);
                }
            }
        });
    });
});
