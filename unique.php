<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['done'])) {
    $_SESSION['unique'] = 1;
    $username = explode('@',$_SESSION['email'])[0];
    echo "<title>設定賬戶密碼</title>";

    // Check if the username already exists
    $userFile = file_get_contents('user.txt');
    $existingUsernames = explode(PHP_EOL, $userFile);
    if (in_array($username, $existingUsernames)) {
        echo '<script>alert("用戶名已存在!");</script>';
        echo '<script>window.location.href = "'.$username.'/index.php";</script>';
        exit;
    }

    // Verification success
    if(isset($_SESSION['alert'])){
        echo '<script>alert("驗證成功!");</script>';
        unset($_SESSION['alert']);
    }
}
else{
    echo '<script>window.location.href = "send.php";</script>';  
}

if(isset($_POST['password'])){

    // Save down password typed
    $_SESSION['password'] = $_POST['password'];

    // Create a folder with the username and copy index.php into it
    $folderName = $username;
    $_SESSION['folderName'] = $folderName;
    mkdir($folderName);
    copy('new/index.php', $folderName . '/index.php');
    copy('new/password.php', $folderName . '/password.php');


    // Retrieve the username and password from session variables
$username = $_SESSION['folderName'];
$password = $_SESSION['password'];

// Append the username and password to the text file
$file = fopen("user.txt", "a"); // Open the file in append mode

if ($file) {
  // Write the username and password in the same line, separated by a comma
  fwrite($file, $username . "," . $password . "\n");

  // Close the file
  fclose($file);
} else {
  // File opening failed
  echo "設定密碼失敗。";
}

    // Welcome words
    echo '<script>alert("歡迎來到我們爲你量身打造的博客網站, '.$username.'!"); window.location.href = "backupmail.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#2b2b2b">
  <style>
    li{
        list-style:none;
    }
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
  <form action="unique.php" method="post" class="container mt-5" autocomplete="off">
  <h3><ol><li></li><li></li><li>設定你的密碼</li></ol></h3>
    <div class="form-group">
      <label for="password">輸入密碼</label>
      <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" value="" placeholder="8-24 位字元的密碼" maxlength="24" minlength="8" onchange="validatePassword()" onload="validatePassword()">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()" id="toggleBtn">👁️</button>
        </div>
      </div>
    </div>
    <div class="form-group">
      <ul>
        <li>
          <span id="requirement1Symbol"></span>
          <span id="requirement1">8-24 位字元</span>
        </li>
        <li>
          <span id="requirement2Symbol"></span>
          <span id="requirement2">至少一個數字和一個英文字母</span>
        </li>
      </ul>
    </div>
    <input type="button" value="設定密碼" class="btn btn-success" onclick="submitForm()">
  </form>

  <script>
    window.addEventListener("DOMContentLoaded",function(){
        validatePassword();
    })

    function validatePassword() {
      var passwordInput = document.getElementById("password").value;
      var requirement1Symbol = document.getElementById("requirement1Symbol");
      var requirement2Symbol = document.getElementById("requirement2Symbol");

      // Define the regular expression patterns for password validation
      var pattern1 = /^.{8,24}$/; // At least 8 characters
      var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)/; // At least one letter and one number

      // Check if each requirement is met and display the corresponding symbol
      requirement1Symbol.textContent = pattern1.test(passwordInput) ? "✔️" : "❌";
      requirement2Symbol.textContent = pattern2.test(passwordInput) ? "✔️" : "❌";
    }

    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password");
      var toggleBtn = document.getElementById("toggleBtn");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleBtn.textContent = "👁️";
      } else {
        passwordInput.type = "password";
        toggleBtn.textContent = "👁️";
      }
    }

    function submitForm() {
      var passwordInput = document.getElementById("password").value;

      // You can add any other validation or form submission logic here if needed
      // For this example, we'll submit the form if the password meets the requirements
      var pattern1 = /^.{8,24}$/; // At least 8 characters
      var pattern2 = /^(?=.*[A-Za-z])(?=.*\d)/; // At least one letter and one number

      if (pattern1.test(passwordInput) && pattern2.test(passwordInput)) {
        document.forms[0].submit();
      } else {
        alert("密碼必須是英文和數字混合，8-24 位字元的字串。");
      }
    }
  </script>
</body>
</html>
