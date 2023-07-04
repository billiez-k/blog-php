<?php 
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['done'])){
    session_destroy();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#2b2b2b">
    <meta charset="utf-8">
    <title>創建博客賬戶</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
          <form action="send.php" method="post">
            <h3><ol><li>創建自己專屬的博客賬戶</li></ol></h3>
            <br>
            <div class="form-group">
              <label for="email">電郵:</label>
              <input type="email" class="form-control" id="email" name="email" value="" onchange="emailVerification()">
            </div>
            <div class="my-3">已有賬戶？ <a href="login.php">登入</a></div>
            <button type="submit" class="btn btn-primary" name="send" id="submit" disabled>發送驗證碼</button>
          </form>
          <br>
          <a type="button" class="btn btn-warning" href="index.php">返回公開博客區</a>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
      function emailVerification(){
          var email = document.getElementById("email").value;
          var submit = document.getElementById("submit");

          function hasRepeatedSymbols(str) {
  const symbols = new Set();
  for (let i = 0; i < str.length; i++) {
    const char = str[i];
    if (!symbols.has(char)) {
      symbols.add(char);
    } else {
      return true; // Found a repeated symbol
    }
  }
  return false; // No repeated symbols found
}

function hasExactlyTwoSymbols(str) {
  const symbols = new Set();
  for (let i = 0; i < str.length; i++) {
    const char = str[i];
    if (isSymbol(char)) {
      symbols.add(char);
      if (symbols.size > 2) {
        return false; // More than two symbols found
      }
    }
  }
  return symbols.size === 2; // Return true if exactly two symbols are found
}

function isSymbol(char) {
  const regex = /[!@#$%^&*(),.?":{}|<>]/;
  return regex.test(char);
}



          if(email.trim() == ""){
              
          }
          else if(!hasExactlyTwoSymbols(email)){
submit.setAttribute("disabled","");
          }
          else{
              for (var i = 0 ; i < email.length ; i++){
                  if(email[i] == "@"){
                      for (var j = i + 2 ; j < email.length ; j++){
                          if (email[j] == "."){
                              if(email[j+1] == null){
                                  submit.setAttribute("disabled","");
                              }
                              else{
                                  submit.removeAttribute("disabled");
                              }
                          }
                      }
                  }
              }
          }
      }
    </script>
  </body>
</html>
