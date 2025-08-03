<?php

$open_connect = 1;

require('connect.php');

if (isset($_POST['email_account']) && isset($_POST['password_account1'])) {
    $email_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['email_account']));
    $password_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account1']));

    $query_check_account = "SELECT * FROM account WHERE email_account = '$email_account' ";
    // ค้นหาบัญชีว่ามีอีเมลที่ตรงกับผู้ใช้กรอกเข้ามา
    $call_back_check_account = mysqli_query($connect, $query_check_account);
    
    if (mysqli_num_rows($call_back_check_account) == 1) {
        $result_check_account = mysqli_fetch_assoc($call_back_check_account);
        $hash = $result_check_account['password_account'];
        $password_account = $password_account . $result_check_account['salt_account'];

        if (password_verify($password_account, $hash)) { 
            // ตรวจสอบรหัสว่า จริง หรือ เท็จ
            if ($result_check_account['role_account'] == 'member') {
                header('Location: index.php');
                exit;
            } elseif ($result_check_account['role_account'] == 'admin') {
                header('Location: admin.php');
                exit;
            }
        } else {
            header('Location: from-login.php'); // รหัสผิด
            exit;
        }

    } else {
        header('Location: from-login.php'); // ไม่มีอีเมลในระบบ
        exit;
    }

} else {
    header('Location: login.php'); // ต้องกรอกข้อมูล
    exit;
}
?>