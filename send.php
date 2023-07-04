<?php 

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if($_SESSION['done'] === 1){
    header("Location: unique.php");
    exit;
}

$_SESSION['done'] = null;

if(isset($_POST['send'])){
    // Check if the username already exists
    $username = explode('@',$_POST['email'])[0];
    $userFile = file_get_contents('user.txt');
$existingUsers = explode(PHP_EOL, $userFile);
foreach ($existingUsers as $user) {
    $userInfo = explode(',', $user);
    $existingUsernames[] = $userInfo[0]; // Extract username from the user info
}

if (in_array($username, $existingUsernames)) {
    echo '<script>alert("用戶名 ' . $username . ' 已經存在, 請用另外一個電郵地址註冊!");</script>';
    echo '<script>window.location.href = "google.php";</script>';
    exit;
}

    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $_SESSION['trial'] = 0;
    $mail = new PHPMailer(true);

    $verificationCode = rand(100000,999999);
    $_SESSION['code'] = $verificationCode;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'billiezmailer@gmail.com';
    $mail->Password = 'jawmumfijhtbvteh';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('billiezmailer@gmail.com');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Your billiez Blog Verification Code';
    $mail->Body = 'Your verification code is: '.$verificationCode.'<br><hr><br>
<table border="0" cellspacing="3" cellpadding="0" style="width:100%">
<tbody><tr>
<td valign="bottom" style="width:25.7%;padding:0.75pt">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0 0 12pt 0;line-height:105%"><span style="color:#6d92d6;font-size:10pt;line-height:105%">Billy Kwan</span><span style="font-size:7pt;line-height:105%"><br aria-hidden="true">
<span style="color:#626469">YouTuber</span><br aria-hidden="true">
<span style="color:#626469">Craftguy</span><br aria-hidden="true">
<span style="color:#626469">CUHK</span></span></p></td>
<td valign="bottom" style="width:41.2%;padding:0.75pt">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0 0 12pt 0;line-height:105%"><span style="color:#5982cf;font-size:7pt;line-height:105%">T&nbsp;&nbsp;</span><span style="color:#626469;font-size:7pt;line-height:105%">852-25136738</span><span style="font-size:7pt;line-height:105%"><br aria-hidden="true">
<span style="color:#5982cf">P&nbsp;&nbsp;</span><span style="color:#626469">852-95323828</span><br aria-hidden="true">
<span style="color:#5982cf">E&nbsp;&nbsp;</span></span><span style="font-size:11pt;line-height:105%"><a href="mailto:mail@craftguy.eu.org" rel="noopener noreferrer" target="_blank"><span style="color:#626469;font-size:7pt;line-height:105%">mail@craftguy.eu.org</span></a></span><span style="font-size:7pt;line-height:105%"></span></p></td>
<td valign="bottom" style="width:33%;padding:0.75pt">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0 0 12pt 0;line-height:105%"><span style="color:#626469;font-size:7pt;line-height:105%">G/F<br aria-hidden="true">Tung Chun Court<br aria-hidden="true">
Shau Kei Wan, HK</span><span style="font-size:7pt;line-height:105%"></span></p></td></tr></tbody></table>
<img src="cid:craftguy" style="width:100%"></div>';

    $mail->AddEmbeddedImage('img/banner.png', 'craftguy');

    $mail->send();

    echo '<script>alert("驗證碼已發送");</script>';
}

elseif(isset($_POST['verify'])){
    if($_SESSION['code'] == $_POST['code']){
        $_SESSION['done'] = 1;
        $_SESSION['alert'] = 1;
        echo '<script>window.location.href = "unique.php";</script>';
        exit;
    }
    else{
        if ($_SESSION['trial'] < 5){
            echo '<script>alert("驗證碼不正確!");</script>';
            $_SESSION['trial']++;
        }
        else{
            session_destroy();
            echo '<script>alert("達到嘗試上限!"); window.location.href = "google.php";</script>';
            exit;
        }
    }
}

elseif(isset($_POST['back'])){
    session_destroy();
    echo '<script>window.location.href = "google.php";</script>';
}

else{
    if(isset($_SESSION['email']) && isset($_SESSION['code'])){
        if(isset($_SESSION['unique'])){
            echo '<script>window.location.href = "unique.php"</script>';
        }
    }
    else{
        echo '<script>window.location.href = "google.php";</script>';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#2b2b2b">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>電郵驗證碼</title>
  <style>
    /* Additional custom styles can be added here */
    @import url("https://fonts.googleapis.com/css?family=Lato:400,400i,700");
  
ol {
  max-width: 350px;
  counter-reset: my-awesome-counter;
  list-style: none;
  padding-left: 40px;
}
ol li {
  margin: 0 0 0.5rem 0;
  counter-increment: my-awesome-counter;
  position: relative;
}
ol li::before {
  content: counter(my-awesome-counter);
  color: #fcd000;
  font-size: 1.5rem;
  font-weight: bold;
  position: absolute;
  --size: 32px;
  left: calc(-1 * var(--size) - 10px);
  line-height: var(--size);
  width: var(--size);
  height: var(--size);
  top: 0;
  transform: rotate(-10deg);
  background: black;
  border-radius: 50%;
  text-align: center;
  box-shadow: 1px 1px 0 #999;
}
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
      <h3><ol><li></li><li>驗證你的電郵</li></ol></h3>
      <br>

        <div class="container">
  <div class="row">
    <div class="container-fluid text-center mt-3">
      <form action="send.php" method="post" class="" autocomplete="off">
      <div class="d-flex">
        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
        <div class="form-group d-inline-block mb-0">
          <input type="text" class="form-control" name="code" placeholder="輸入 6 位數字驗證碼" style="width:100%">
        </div>
        <button type="submit" class="btn btn-outline-secondary" name="send" style="width: 60%;">重發驗證碼</button>
        </div><br>
        <button type="submit" class="btn btn-success" style="width:100%" name="verify">提交驗證碼</button>
        <br><br>
        <input type="submit" class="btn btn-warning btn-block" name="back" value="返回">
      </form>
    </div>
  </div>
</div>


        <br>

      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
