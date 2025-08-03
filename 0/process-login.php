<?php

$open_connect = 1;
require('connect.php');

    if(isset($_POST['email_account']) && isset($_POST['password_account'])){ ;
      $email_account = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['email_account']));
      $password_account = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['password_account']));
 
      $query_check_account = "SELECT * FROM account WHERE email_account = '$email_account' ";
      //ค้นหาบัญชีว่ามีอีเมลที่ตรงกับผู้ใช้กรอกเข้ามา
      $call_back_check_account = mysqli_query($connect, $query_check_account) ;
      if(mysqli_num_rows($call_back_check_account)==1){
       $result_check_account = mysqli_fetch_assoc($call_back_check_account);
       $hash = $result_check_account[ 'password_account'] ;
       $password_account = $password_account . $result_check_account['salt_account'];

       if(password_verify($password_account,$hash)){ //ตรวจสอบรหัสว่า จริง หรือ เท็จ
            if($result_check_account['role_account'] =='member'){
                die(header('locatin: index.php'));
            }elseif($result_check_account['role_account'] =='admin'){
                die(header('locatin: admin.php'));

            }
       }else{
            die(header('location: from-login.php')); //รหัสผิด
       }
      

      }else{
        die(header('location : from-login.php')); //ไม่มีอีเมลในระบบ
      }

    }else{
        die(header('location: login.php')); // ต้องกรอกข้อมูล
    }
?>