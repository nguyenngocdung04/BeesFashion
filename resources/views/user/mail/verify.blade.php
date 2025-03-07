<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác thực tài khoản</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; color: #333; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #ddd; border-radius: 8px; padding: 20px;">
        <h2 style="text-align: center; color: #4CAF50;">Xác thực tài khoản của bạn</h2>
        <p>Chào <strong>{{ $email }}</strong>,</p>
        <p>Cảm ơn bạn đã đăng ký tài khoản. Vui lòng nhấp vào nút bên dưới để xác thực tài khoản của bạn:</p>
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('verifyEmail', ['token' => $token]) }}"
               style="background-color: #4CAF50; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px;">
               Xác thực tài khoản
            </a>
        </div>
        <p>Nếu bạn không thực hiện đăng ký tài khoản, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,</p>
        <p>Đội ngũ hỗ trợ: BeesFahion</p>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <p style="font-size: 12px; color: #888;">Nếu bạn gặp sự cố khi nhấp vào nút, vui lòng sao chép và dán liên kết sau vào trình duyệt:</p>
        <p style="font-size: 12px; color: #4CAF50;">{{ route('verifyEmail', ['token' => $token]) }}</p>
    </div>
</body>
</html>
