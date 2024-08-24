<!DOCTYPE html>
<html>

<head>
    <title>Thông báo buộc thôi học</title>
</head>

<body>
    <h4>Tài khoản sinh viên đã bị khóa và bị cho thôi học</h4>
    <h5>Xin chào , <b class="text-primary">{{ $student->user->email }}</b></h5>
    <p>Tài khoản của bạn đã bị khóa do điểm trung bình của bạn không đủ 5 điểm , điểm của bạn : {{ $score }} </p>
</body>

</html>
