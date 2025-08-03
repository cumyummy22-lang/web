<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างบัญชี</title>
</head>
<body>
    <h1>สร้างบัญชี</h1>
    <form action="process-register.php" method="POST">
        <div>
            <input name="username_account" type="text" placeholder="ชื่อผู้ใช้" required>
        </div>
        <div>
            <input name="email_account" type="email" placeholder="อีเมล" required>
        </div>
         <div>
            <input name="password_account1" type="password" placeholder="รหัสผ่าน" require>
        </div>
        <div>
            <input name="password_account2" type="password" placeholder="ยืนยันรหัสผ่าน" require>
        </div>
        <button type="submit">สร้างบัญชี</button>
        <a href="from-login.php">มีบัญชีแล้ว?</a>
   </form>
</body>
</html>