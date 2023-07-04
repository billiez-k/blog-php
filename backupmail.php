
                                                                                                                                                                                                                                                                                                                                                                                                                        
<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_SESSION['folderName']) && isset($_SESSION['done'])){
    $mail = new PHPMailer(true);
    $body = 'Your personalized billiez blog URL: http://photograph.eu.org/blog/'.$_SESSION['folderName'].'/index.php <br><br> Your password: <br>'.$_SESSION['password'].'<br><br>Please do not tell your user credentials to others. If your secret messages got exposed or edited, please contact billiez. Billiez will take a picture of it to record this memorable moment for you. Thanks!<br><hr><br>
';

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'YOUR_USERNAME';
    $mail->Password = 'YOUR_PASSWORD';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('YOUR_EMAIL');

    $mail->addAddress($_SESSION['email']);

    $mail->isHTML(true);

    $mail->Subject = 'Your billiez Blog Website URL';
    $mail->Body = $body;
    $mail->AddEmbeddedImage('img/banner.png', 'craftguy');

    $mail->send();

    echo '<script>const myTimeout = setTimeout(function(){ window.location.href = "http://photograph.eu.org/blog/'.$_SESSION['folderName'].'/index.php"}, 1000); </script>';
    $password = $_SESSION['password'];
    session_destroy();
    $_SESSION['password'] = $password;
}
else{
    header("Location: http://photograph.eu.org/blog/send.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>帳戶創建中...</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .loading-dots {
      display: inline-block;
      font-size: 24px;
    }
    
    .dot {
      animation: loading 1.5s infinite;
      animation-delay: 0s;
    }
    
    .dot:nth-child(2) {
      animation-delay: 0.25s;
    }
    
    .dot:nth-child(3) {
      animation-delay: 0.5s;
    }
    
    .dot:nth-child(4) {
      animation-delay: 0.75s;
    }
    
    .dot:nth-child(5) {
      animation-delay: 1s;
    }
    
    .dot:nth-child(6) {
      animation-delay: 1.25s;
    }
    
    @keyframes loading {
      0%, 100% { opacity: 0; }
      50% { opacity: 1; }
    }
    
    @media (max-width: 576px) {
      .loading-dots {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mt-5">
        <h1 class="loading-dots">賬戶創建成功，正在重新導向你的網站<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></h1>
      </div>
    </div>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.2.1.slim.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<script>
    setTimeout(function () {
            $(document).ready(function () {
                        document.getElementById("loader").style.display = "none";
                                    document.getElementById("myDiv").style.display = "block";
                                            });
                                                 }, 500);
                                                 </script>
                                                  
</div>
