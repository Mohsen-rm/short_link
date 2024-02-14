<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>أنشاء حساب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>

    </style>

  </head>
  <body style="background-color: #00B0D4;">

  <section class="vh-100" style="background-color: #00B0D4;">
  <div class="container py-5 h-100" style="background-color: #00B0D4;">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/pexels-kelly-3127155.jpg"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create an account</h5>

                <div class="form-outline mb-4">
                  <input type="text" id="fn" name="fn" class="form-control form-control-lg" minlength="4" required/>
                  <label class="form-label" for="fn">Fullname</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="email" id="em" name="em" class="form-control form-control-lg" minlength="8" required/>
                  <label class="form-label" for="em">Email address</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="pd" name="pd" class="form-control form-control-lg" minlength="8" required />
                  <label class="form-label" for="pd">Password</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="cpd" name="cpd" class="form-control form-control-lg" minlength="8" required />
                  <label class="form-label" for="cpd">Password</label>
                </div>
                <p id="login_wait" style="margin: 0px;"></p>
                <div class="pt-1 mb-4">
                  <button class="btn btn-dark btn-lg btn-block" type="button" id="signupFunCode" name="signupFunCode">Create</button>
                </div>

                <a class="small text-muted" href="forgot_password">Forgot password?</a>
                <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="sing_up.php"
                    style="color: #393f81;">Register here</a></p>
                <a href="terms_of_use.php" class="small text-muted">Terms of use.</a>
                <a href="privacy_policy.php" class="small text-muted">Privacy policy</a>
      

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
  <script type="text/javascript">
function signupUser(){
var fullname = document.getElementById("fn").value;
var username = document.getElementById("fn").value;
var emailAdd = document.getElementById("em").value;
var password = document.getElementById("pd").value;
var cpassword = document.getElementById("cpd").value;
var gender = document.getElementById("fn").value;
$.ajax({
type:'POST',
url:'data/login_signup_codes.php',
data:{'req':'signup_code','fn':fullname,'un':username,'em':emailAdd,'pd':password,'cpd':cpassword,'gr':gender},
beforeSend:function(){
$('.login_signup_btn2').hide();
$('#login_wait').html("<b><? echo lang('creating_your_account'); ?></b>");
},
success:function(data){
$('#login_wait').html(data);
if (data == "Done..") {
    $('#login_wait').html("<p class='alertGreen'><? echo lang('done'); ?>..</p>");
    setTimeout(' window.location.href = " index"; ',2000);
}else{
    $('.login_signup_btn2').show();
}
},
error:function(err){
alert(err);
}
});
}
$('#signupFunCode').click(function(){
signupUser();
});

$(".login_signup_textfield").keypress( function (e) {
    if (e.keyCode == 13) {
        signupUser();
    }
});
</script>
</html>

<?php
//POST Create Account

// if(isset($_POST['create'])){
//   //
//   $fullname = filter_var(htmlentities($_POST['fn']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//   $email = filter_var(htmlentities($_POST['em']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//   $signup_password_var = filter_var(htmlentities($_POST['pd']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//   $signup_cpassword = filter_var(htmlentities($_POST['cpd']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//   //check fullname
//   if(strlen($fullname) <= 4) {
//     $msg = msgHtml("Your name must be more than 4 letters");
//   }elseif(strlen($email) <= 10) {
//     $msg = msgHtml("Your name must be more than 4 letters");
//   }elseif(strlen($signup_password_var) <= 8) {
//     $msg = msgHtml("Your name must be more than 4 letters");
//   }elseif(strlen($signup_cpassword) <= 8) {
//     $msg = msgHtml("Your name must be more than 4 letters");
//   }else{
// echo "ggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg\n fdddddddddddddd";

//     $chekPwd = $conn->prepare("SELECT * FROM users WHERE email= :email");
//     $chekPwd->bindParam(':email', $email, PDO::PARAM_STR);
//     $chekPwd->execute();
//     while ($row = $chekPwd->fetch(PDO::FETCH_ASSOC)) {
//         $rEmail = $row['email'];
//         $rPassword = $row['password'];
//     }

//     $msg = msgHtml("g");

//     if(isset($_COOKIE['linAtt']) AND $_COOKIE['linAtt'] == $email) {
//         echo "<p class='alertRed'>".lang('cannot_login_attempts').".</p>";
//     }else{
//       // check if user try to login in his username or email
//       $email_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
//       if(preg_match($email_pattern, $username)) {
//           $un_or_em = $rEmail;
//       }else{
//           $un_or_em = $rUsername;
//       }
//       // ========================
//       if ($un_or_em != $username) {
//           echo "<p class='alertRed'>".lang('un_email_not_exist')."!</p>";
//       }elseif (!password_verify($password,$rPassword)) {
//           $checkAttempts = $conn->prepare("SELECT login_attempts FROM users WHERE username = :username");
//           $checkAttempts->bindParam(':username',$username,PDO::PARAM_STR);
//           $checkAttempts->execute();
//           while ($attR = $checkAttempts->fetch(PDO::FETCH_ASSOC)) {
//               $login_attempts = $attR['login_attempts'];
//           }
//           if ($login_attempts < 3) {
//               $attempts = $login_attempts + 1;
//               $addAttempts = $conn->prepare("UPDATE users SET login_attempts =:attempts WHERE username=:username");
//               $addAttempts->bindParam(':username',$username,PDO::PARAM_STR);
//               $addAttempts->bindParam(':attempts',$attempts,PDO::PARAM_INT);
//               $addAttempts->execute();
//           }elseif ($login_attempts >= 3) {
//               $attempts = 0;
//               $addAttempts = $conn->prepare("UPDATE users SET login_attempts =:attempts WHERE Username=:username");
//               $addAttempts->bindParam(':username',$username,PDO::PARAM_STR);
//               $addAttempts->bindParam(':attempts',$attempts,PDO::PARAM_INT);
//               $addAttempts->execute();
//               setcookie("linAtt", "$username", time() + (60 * 15), '/');
//           }
//           $LoginTry = 3 - $login_attempts;
//           echo "<p class='alertRed'>".lang('password_incorrect_you_have')." $LoginTry ".lang('attempts_to_login')."</p>";

//       }else{
//       $loginsql = "SELECT * FROM users WHERE (username= :username OR email= :email) AND password= :rPassword";
//       $query = $conn->prepare($loginsql);
//       $query->bindParam(':username', $username, PDO::PARAM_STR);
//       $query->bindParam(':email', $username, PDO::PARAM_STR);
//       $query->bindParam(':rPassword', $rPassword, PDO::PARAM_STR);
//       $query->execute();
//       $num = $query->rowCount();
//       if($num == 0){
//           echo "<p class='alertRed'>".lang('un_and_pwd_incorrect')."!</p>";
//       }else{
//           $_SESSION['attempts'] = 0;
//           AddStatistics($conn,'login','login','all');
//           include ("GeT_login_WhileFetch.php");
//           echo "Welcome...";
//       }
//       }
//     }
//   }

//   $options = array(
//     'cost' => 12,
//   );
  
//   $signup_password = password_hash($signup_password_var, PASSWORD_BCRYPT, $options);


// }


// function msgHtml($msg){
//   return '<div class="alert alert-warning d-flex align-items-center" role="alert">
//   <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
//      <div>' . $msg . '</div>
//    </div>';
// }

?>