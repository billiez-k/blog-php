<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Extract username from email
  $username = substr($email, 0, strpos($email, '@'));

  // Read user.txt file
  $users = file('user.txt', FILE_IGNORE_NEW_LINES);

  // Check if username and password match
  $isLoggedIn = false;
  foreach ($users as $user) {
    list($storedUsername, $storedPassword) = explode(',', $user);
    if ($username === $storedUsername && $password === $storedPassword) {
      $isLoggedIn = true;
      break;
    }
  }

  if ($isLoggedIn) {
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $redirectUrl = "http://photograph.eu.org/blog/".$_SESSION['username']."/index.php";
    echo "<script>window.location.href = '".$redirectUrl."';</script>";
    exit;
  } else {
    echo "<script>alert('登錄失敗，請檢查用戶名和密碼！');history.back();</script>";
    exit;
  }
}

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    $combination = $_SESSION['username'].','.$_SESSION['password'];
// Read the contents of the text file
$fileUrl = 'http://photograph.eu.org/blog/user.txt';
$fileContents = file_get_contents($fileUrl);

// Split the file contents into an array of lines
$fileLines = explode("\n", $fileContents);

// Loop through each line and check if the combination matches
$combinationMatched = false;

foreach ($fileLines as $line) {
    $userData = explode(',', $line);
    $username = $userData[0];
    $password = $userData[1];

    if ($combination === "$username,$password") {
        // Combination matches
        $combinationMatched = true;
        $redirectUrl = "http://photograph.eu.org/blog/".$_SESSION['username']."/index.php";
        echo "<script>window.location.href = '".$redirectUrl."';</script>";
        break;
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="theme-color" content="#2b2b2b">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>登錄頁面</title>
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2>登入</h2>
        <br>
        <form method="POST" action="login.php">
          <div class="form-group">
            <label for="email">電郵：</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">密碼：</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="my-3">還沒有賬戶？ <a href="google.php">註冊</a></div>
          <button type="submit" class="btn btn-primary btn-block">登錄</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.staticfile.org/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
