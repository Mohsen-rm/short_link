<?php
session_start();
include("../config/dbconnect.php");
include("../config/connect.php");
include_once "../include/langs/set_lang.php";
include_once("../find_path.php");
$req = filter_var(htmlentities($_POST['req']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
switch ($req) {
// ============================= [ Login code ] =============================
case 'login_code':
$username = htmlentities($_POST['un'], ENT_QUOTES);
$password = htmlentities($_POST['pd'], ENT_QUOTES);
if($username == null && $password == null){
echo "<p class='alertRed'>".lang('enter_username_to_login')."</p>";
}elseif ($username == null){
    echo "<p class='alertRed'>".lang('enter_username_to_login')."</p>";
}elseif($password == null){
    echo "<p class='alertRed'>".lang('enter_password_to_login')."</p>";
}else{
    $chekPwd = $conn->prepare("SELECT * FROM users WHERE username = :username OR email= :email");
    $chekPwd->bindParam(':email', $username, PDO::PARAM_STR);
    $chekPwd->bindParam(':username',$username,PDO::PARAM_STR);
    $chekPwd->execute();
    while ($row = $chekPwd->fetch(PDO::FETCH_ASSOC)) {
        $rUsername = $row['username'];
        $rEmail = $row['email'];
        $rPassword = $row['password'];
    }

    if(isset($_COOKIE['linAtt']) AND $_COOKIE['linAtt'] == $username) {
        echo "<p class='alertRed'>".lang('cannot_login_attempts').".</p>";
    }else{
    // check if user try to login in his username or email
    $email_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
    if(preg_match($email_pattern, $username)) {
        $un_or_em = $rEmail;
    }else{
        $un_or_em = $rUsername;
    }
    // ========================
    if ($un_or_em != $username) {
        echo "<p class='alertRed'>".lang('un_email_not_exist')."!</p>";
    }elseif (!password_verify($password,$rPassword)) {
        $checkAttempts = $conn->prepare("SELECT login_attempts FROM users WHERE username = :username");
        $checkAttempts->bindParam(':username',$username,PDO::PARAM_STR);
        $checkAttempts->execute();
        while ($attR = $checkAttempts->fetch(PDO::FETCH_ASSOC)) {
            $login_attempts = $attR['login_attempts'];
        }
        if ($login_attempts < 3) {
            $attempts = $login_attempts + 1;
            $addAttempts = $conn->prepare("UPDATE users SET login_attempts =:attempts WHERE username=:username");
            $addAttempts->bindParam(':username',$username,PDO::PARAM_STR);
            $addAttempts->bindParam(':attempts',$attempts,PDO::PARAM_INT);
            $addAttempts->execute();
        }elseif ($login_attempts >= 3) {
            $attempts = 0;
            $addAttempts = $conn->prepare("UPDATE users SET login_attempts =:attempts WHERE Username=:username");
            $addAttempts->bindParam(':username',$username,PDO::PARAM_STR);
            $addAttempts->bindParam(':attempts',$attempts,PDO::PARAM_INT);
            $addAttempts->execute();
            setcookie("linAtt", "$username", time() + (60 * 15), '/');
        }
        $LoginTry = 3 - $login_attempts;
        echo "<p class='alertRed'>".lang('password_incorrect_you_have')." $LoginTry ".lang('attempts_to_login')."</p>";

    }else{
    $loginsql = "SELECT * FROM users WHERE (username= :username OR email= :email) AND password= :rPassword";
    $query = $conn->prepare($loginsql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $username, PDO::PARAM_STR);
    $query->bindParam(':rPassword', $rPassword, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();
    if($num == 0){
        echo "<p class='alertRed'>".lang('un_and_pwd_incorrect')."!</p>";
    }else{
        $_SESSION['attempts'] = 0;
        AddStatistics($conn,'login','login','all');
        include ("GeT_login_WhileFetch.php");
        echo "Welcome...";
    }
    }
    }
}
$conn = null;
break;
// ============================= [ Signup code ] =============================
case 'signup_code':
$signup_id = (rand(0,99999).time()) + time();
$signup_fullname = filter_var(htmlentities($_POST['fn']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$signup_username = filter_var(htmlentities($_POST['un']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$signup_email = filter_var(htmlentities($_POST['em']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// =========================== password hashinng ==================================
$signup_password_var = filter_var(htmlentities($_POST['pd']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$options = array(
    'cost' => 12,
);
$signup_password = password_hash($signup_password_var, PASSWORD_BCRYPT, $options);
// ================================================================================
$signup_cpassword = filter_var(htmlentities($_POST['cpd']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$signup_genderVar = filter_var(htmlentities($_POST['gr']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($signup_genderVar == lang('male')) {
    $signup_gender = "Male";
    $userphoto = "user-male.png";
}elseif ($signup_genderVar == lang('female')) {
    $signup_gender = "Female";
    $userphoto = "user-female.png";
}else{
    $signup_gender = "Male";
    $userphoto = "user-male.png";
}

if (isset($_SESSION['language'])) {
    $signup_language = $_SESSION['language'];
}else{
    $signup_language = "English";
}

$eemsql = "SELECT * FROM users WHERE Email=:signup_email";
$exist_email = $conn->prepare($eemsql);
$exist_email->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
$exist_email->execute();
$num_em_ex = $exist_email->rowCount();
if($signup_fullname == null || $signup_email == null || $signup_password == null || $signup_cpassword == null){
       echo "<p class='alertRed'>".lang('please_fill_required_fields')."</p>";
}elseif($num_em_ex == 1){
        echo "<p class='alertRed'>".lang('email_already_exist')."</p>";
}elseif(strlen($signup_password) < 6){
    echo "<p class='alertRed'>".lang('password_short').".</p>";
}elseif($signup_password_var != $signup_cpassword){
    echo "<p class='alertRed'>".lang('password_not_match_with_cpassword')."</p>";
}elseif (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)) {
    echo "<p class='alertRed'>".lang('invalid_email_address')."</p>";
}else{
    if(strlen($signup_username) < 6){
      echo "<p class='alertRed'>فشل أسم المستخدم أقل من 6 أحرف</p>";
      exit();
    }

    if(strlen($signup_password_var) <= 7){
      echo "<p class='alertRed'>كلمة السر أقل من 8 أحرف</p>";
      exit();
    }

      $signupsql = "INSERT INTO users (fullname,email,password)
      VALUES( :signup_fullname, :signup_email, :signup_password)";
      $query = $conn->prepare($signupsql);
      $query->bindParam(':signup_fullname', $signup_fullname, PDO::PARAM_STR);
      $query->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
      $query->bindParam(':signup_password', $signup_password, PDO::PARAM_STR);
      $query->execute();

    // ========================== login code after signup ============================
    $loginsql = "SELECT * FROM users WHERE email= :signup_email AND password= :signup_password";
    $query = $conn->prepare($loginsql);
    $query->bindParam(':signup_email', $signup_email, PDO::PARAM_STR);
    $query->bindParam(':signup_password', $signup_password, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();

    include ("../include/GeT_login_WhileFetch.php");
    
    echo "Done..";
}
$conn = null;
$con = null;
break;
}
?>
