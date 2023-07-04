
                                                                                                                                                                                                                                                                                                                                                                                                                        
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

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'billiezmailer@gmail.com';
    $mail->Password = 'jawmumfijhtbvteh';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('billiezmailer@gmail.com');

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