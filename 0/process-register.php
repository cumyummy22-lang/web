<?php

$open_connect = 1;
require('connect.php');

if (
    isset($_POST['username_account']) &&
    isset($_POST['email_account']) &&
    isset($_POST['password_account1']) &&
    isset($_POST['password_account2'])
) {
    $username_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['username_account']));
    $email_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['email_account']));
    $password_account1 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account1']));
    $password_account2 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account2']));

    if ($password_account1 !== $password_account2) {
        die(header('location: from-register.php?error=password_mismatch'));
    }
    // ตรวจสอบว่ารหัสผ่านตรงกันไหม

    $query_check_account = "SELECT email_account FROM account WHERE email_account = '$email_account' ";
    if (!filter_var($email_account, FILTER_VALIDATE_EMAIL)) {
        die(header('location: from-register.php?error=invalid_email'));
    }
    // ตรวจสอบว่ารูปแบบการเขียนอีเมลถูกต้อง

    $call_back_query_check_email_account = mysqli_query($connect, $query_check_account);
    if (mysqli_num_rows($call_back_query_check_email_account) > 0) {
        die(header('location: from-register.php?error=email_exists')); // อีเมลซ้ำ
    } else {
        $length = random_int(16, 32);
        $salt_account = bin2hex(random_bytes($length)); // สร้างค่าเกลือ
        $password_with_salt = $password_account1 . $salt_account; // เอารหัสต่อกับค่าเกลือ

        // เปลี่ยนรหัสเป็นตัวอักษรแบบ random
        $algo = PASSWORD_ARGON2ID;
        $options = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS
        ];
        $password_account = password_hash($password_with_salt, $algo, $options);

        // เพิ่มคำสั่ง SQL จริง (ต้องระบุชื่อคอลัมน์ทั้งหมดที่ใช้จริงในฐานข้อมูล)
        $query_create_account = "INSERT INTO account (username_account, email_account, password_account, salt_account, role_account) 
                                 VALUES ('$username_account', '$email_account', '$password_account', '$salt_account', 'member')";

        $call_back_create_account = mysqli_query($connect, $query_create_account);
        if ($call_back_create_account) {
            die(header('location: from-login.php')); // สร้างบัญชีสำเร็จ
        } else {
            die(header('location: from-register.php?error=insert_failed')); // สร้างบัญชีไม่ได้
        }
    }

} else {
    die(header('location: from-register.php?error=missing_fields'));
}
?>
