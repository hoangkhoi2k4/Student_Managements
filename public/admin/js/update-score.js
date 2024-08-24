$(document).ready(function () {
    $(".update-score-btn").click(function (e) {
        e.preventDefault();
        let value = $(".score-value").val();
        let hasError = false;

        if (value == "") {
            $("#error").text("Vui lòng nhập điểm");
            hasError = true;
        } else if (value < 0 || value > 10) {
            $("#error").text("Điểm phải từ 0 đến 10");
            hasError = true;
        } else if (isNaN(value)) {
            $("#error").text("Điểm phải là số từ 0 đến 10");
            hasError = true;
        } else {
            $("#error").text("");
        }

        if (!hasError) {
            $(this).closest("form").submit();
        }
    });
});
