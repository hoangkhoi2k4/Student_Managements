<!DOCTYPE html>
<html>

<head>
    <title>Tài khoản sinh viên đã được kích hoạt thành công</title>
</head>

<body>
    <h4>Tài khoản sinh viên đã được kích hoạt thành công</h4>
    <p>Xin chào , <b class="text-primary">{{ $data['name'] }}</b></p>
    <p>Tài khoản của bạn đã được kích hoạt, vui lòng đăng nhập hệ thống bằng thông tin sau:
        Email : {{ $data['email'] }} <br>
        Mật khẩu : {{ $data['password'] }}
    </p>
</body>

</html>
