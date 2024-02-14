<?php
session_start();
if(isset($_SESSION['email'])){

}else{
    // تحديد الرابط الذي تريد الانتقال إليه
    $redirect_url = 'sing_in.php';
    // إعادة توجيه المستخدم إلى الرابط
    header("Location: $redirect_url");
}



?>