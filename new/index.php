<?php

session_start();

if(isset($_POST['logout'])){
    session_destroy();
    echo '<script>window.location.href = "http://photograph.eu.org/blog/index.php"</script>';
}
// Get the current page URL
$url = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url .= 's';
}
$url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if($url == "http://photograph.eu.org/blog/" || $url == "http://photograph.eu.org/blog/index.php"){
    echo '<script>window.location.href = "google.php"</script>';
}

// Parse the URL and extract the path
    $path = parse_url($url, PHP_URL_PATH);

    // Remove leading and trailing slashes (if any)
    $path = trim($path, '/');

    // Extract the username part
    $parts = explode('/', $path);
    $username = $parts[1];

    $_SESSION['username'] = $username;

if(!isset($_SESSION['password'])){
    echo '<script>window.location.href = "password.php"</script>';
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
       if (isset($_COOKIE['visited_times'])){
           $visited_times = $_COOKIE['visited_times'] + 1;
           setCookie("visited_times",$visited_times,time()+86400);     
       } 
       else{
           setCookie("visited_times",1,time()+86400);
        }
        break;
    }
}

// If combination doesn't match, redirect to password.php
if (!$combinationMatched) {
    echo '<script>window.location.href = "password.php";</script>';
}

}
?>


<?php

date_default_timezone_set('Asia/Hong_Kong');

// Get the current date in Hong Kong time zone
$currentDate = new DateTime('now');

// Read the contents of the blog.txt file
$fileContents = file_get_contents('blog.txt');
$lines = explode("\n", $fileContents);

$matchingDates = [];

foreach ($lines as $line) {
    // Skip empty lines
    if (empty($line)) {
        continue;
    }

    // Parse the line as JSON
    $data = json_decode($line, true);

    // Extract the timestamp from the data
    $timestamp = $data['timestamp'];

    // Extract the date part from the timestamp
    preg_match('/(\d{4}\/\d{1,2}\/\d{1,2})/', $timestamp, $dateMatches);
    $timestampDate = $dateMatches[1];

    // Compare the date part with the current date in Hong Kong time zone
    if ($timestampDate === $currentDate->format('Y/m/d')) {
        $matchingDates[] = $timestampDate;
    }
}

// Check if the number of matching dates is 5 or above
if (count($matchingDates) >= 5) {
    $limit = 1;
}
else {
    $limit = 0;
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submit']) && $limit != 1) {
    $title = $_POST['title'];
    $happened = $_POST['happened'];
    $learnt = $_POST['learnt'];
    $trimmed = trim($learnt);

    if(strlen($trimmed) < 50){
        echo '
        <script>
          window.location.href = "index.php";
        </script>';
        exit();
    }
    date_default_timezone_set('Asia/Hong_Kong');
    $timestamp = date('Y/m/d H:i:s');
    $i = 0;
    $content = [
      'title' => $title,
      'happened' => $happened,
      'learnt' => $learnt,
      'timestamp' => $timestamp
    ];

    $file = fopen('blog.txt', 'a');
    fwrite($file, json_encode($content) . "\n");
    fclose($file);

    header('Location: index.php');
    exit();
  } elseif (isset($_POST['delete'])) {
    $deleteIndex = $_POST['delete'];
    $blogPosts = [];

    $file = fopen('blog.txt', 'r');
    while (($line = fgets($file)) !== false) {
      $blogPost = json_decode($line, true);
      if ($blogPost !== null) {
        $blogPosts[] = $blogPost;
        $i = $i + 1;
      }
    }
    fclose($file);

    if (isset($blogPosts[$i - $deleteIndex -1])) {
      unset($blogPosts[$i - $deleteIndex -1]);

      $file = fopen('blog.txt', 'w');
      foreach ($blogPosts as $blogPost) {
        fwrite($file, json_encode($blogPost) . "\n");
      }
      fclose($file);

      header('Location: index.php');
      exit();
    }
  }
}

$blogPosts = [];

$file = fopen('blog.txt', 'r');
while (($line = fgets($file)) !== false) {
  $blogPost = json_decode($line, true);
  if ($blogPost !== null) {
    $blogPosts[] = $blogPost;
  }
}
fclose($file);

// Reverse the order of blog posts
$blogPosts = array_reverse($blogPosts);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#23339e">
  <title>比利博客王</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    html,body{
        background-color: #feffeb;
    }
    .a{
        font-size:200px;
    }
  </style>
</head>
<body>
  <header class="container py-3">
    <h1>比利博客王</h1>
    <form id="blogForm" class="<?php echo isset($_POST['submit']) ? '' : 'd-none'; ?>" method="POST" action="index.php">
      <div class="mb-3">
        <label for="titleInput" class="form-label">博客主題</label>
        <input type="text" class="form-control" id="titleInput" name="title" required>
      </div>
      <div class="mb-3">
        <label for="happenedInput" class="form-label">今天發生了什麼事？</label>
        <textarea class="form-control" id="happenedInput" name="happened" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="learntInput" class="form-label">今天學到了甚麼？</label>
        <textarea class="form-control" id="learntInput" name="learnt" rows="3" required></textarea>
      </div>
      <div id="huh" style="color:#f03c2b;display:none">學到的東西就這麼點？ <span id="count"></span></div>
      <br>
      <span id="done" class="px-3" style="display:none;background-color:#e3fce5;border:2px solid green;padding:5px;border-radius:5px;font-size:21px"><span class='symbol tick a' style="font-size:19px;">&#10003;</span> 今天目標已達成</span>
      <span id="reachedLimit" class="px-3" style="display:none;background-color:#f9fad2;border:2px solid #bebf6f;padding:5px;border-radius:5px;font-size:21px"><span class='symbol cross a' style="font-size:19px;">&#10007;</span> 今天發表的博客已達上限 (5/5)</span>
      <span id="notYetDone" class="px-3" style="display:none;background-color:#fce5e3;border:2px solid red;padding:5px;border-radius:5px;font-size:21px"><span class='symbol cross a' style="font-size:19px;">&#10007;</span> 還差一篇博客就達成每日目標</span>
      <br><br>
      <script>
        window.addEventListener("DOMContentLoaded",function(){

            //Indicatior of today progress
            var today = document.getElementById("today");
            var indicator = today.getElementsByTagName("span")[0];
            var done = document.getElementById("done");
            var notYetDone = document.getElementById("notYetDone");
            var reachedLimit = document.getElementById("reachedLimit");
            if (indicator.classList.contains("cross")){
                notYetDone.style.display = "inline";
                done.style.display = "none";
            }
            else {
                if (reachedLimit.style.display == "none"){
                    done.style.display = "inline";
                    notYetDone.style.display = "none";
                }
                else{
                    done.style.display = "none";
                    notYetDone.style.display = "none"; 
                }
            }

            //Media query for styling
            var x = window.matchMedia("(max-width: 450px)");
            var a = document.getElementsByClassName("a");
            if (x.matches) { // If media query matches
                for (var i = 0; i < a.length ; i++){
                    a[i].style.fontSize = "17px";
                }
                done.style.fontSize = "18px";
                notYetDone.style.fontSize = "18px";
            }
            })
      </script>
      <button type="button" class="btn btn-primary" id="btn">提交</button>
      <?php if($limit != 1){ echo'<button type="submit" name="submit" class="btn btn-primary d-none" id="submit">提交</button>';} ?>
      <button type="reset" class="btn btn-danger" id="resetBtn">清除</button>
    </form>
    <br>
    <button id="plusBtn" class="btn btn-primary <?php echo isset($_POST['submit']) ? 'd-none' : ''; ?>">+ 發表博客</button>
    <button id="crossBtn" class="btn btn-secondary <?php echo isset($_POST['submit']) ? '' : 'd-none'; ?>">x</button>
  </header>

  <script>
    //Form validation
    var btn = document.getElementById("btn");
    btn.addEventListener("click",function(){
        var learntInput = document.getElementById("learntInput");
        var trimmed = learntInput.value.trim();
        if(trimmed.length < 50){
            var huh = document.getElementById("huh");
            huh.style.display = "block";
            var count = document.getElementById("count");
            count.innerHTML = "(" + trimmed.length + "/50 字)";
        }
        else{
            var blogForm = document.getElementById("blogForm");
            var submit = document.getElementById("submit");
            submit.click();
            blogForm.submit();
        }
    })
  </script>

  <!-- Calendar -->
<div class=" container calendar">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="7" style="font-size:22px;"><?php date_default_timezone_set('Asia/Hong_Kong'); echo date('n'); ?>月</th>
      </tr>
      <tr>
        <th>日</th>
        <th>一</th>
        <th>二</th>
        <th>三</th>
        <th>四</th>
        <th>五</th>
        <th>六</th>
      </tr>
    </thead>
    <tbody>
      <?php

        //Calendar
        date_default_timezone_set('Asia/Hong_Kong');
        $firstDayOfMonth = date('N', strtotime('first day of this month'));
        $currentDay = 1;
        $totalDays = date('t');
        $week = 0;
        $firstDay = $firstDayOfMonth;

        if ($totalDays == 28 && $firstDay == 1){
            $maxWeek = 3;
        }
        elseif ($totalDays + $firstDay > 35){
            $maxWeek = 5;
        }
        else{
            $maxWeek = 4;
        }

        // Retrieve blog dates from blog.txt
        $blogDates = [];
        $file = fopen('blog.txt', 'r');
        while (($line = fgets($file)) !== false) {
          $blogPost = json_decode($line, true);
          if ($blogPost !== null) {
            $blogDate = date('Y-m-d', strtotime($blogPost['timestamp']));
            $blogDates[$blogDate] = true;
          }
        }
        fclose($file);

        echo "<tr>";
        while ($week <= $maxWeek) {
          for ($i = 1; $i <= 7; $i++) {
            if ($firstDay > 0 && $currentDay === 1) {
              echo "<td></td>";
              $firstDay--;
            } elseif ($currentDay <= $totalDays) {
              echo "<td";
              if ($currentDay == date('j')) {
                echo " style='background-color:#b6ecfa' id='today'";
              }
              echo ">";

              // Check if there is a blog post for the current day
              $date = date('Y-m-d', strtotime('+' . ($currentDay - 1) . ' days', strtotime('first day of this month')));
              if (isset($blogDates[$date])) {
                echo "<span class='symbol tick'>&#10003;</span>";
              } else {
                echo "<span class='symbol cross'>&#10007;</span>";
              }

              echo "<br>$currentDay</td>";

              $currentDay++;
            } else {
              echo "<td></td>";
            }
          }

          echo "</tr>";
          $week++;
          echo "<tr>";
        }
      ?>
    </tbody>
  </table>
</div>

<style>
  .symbol {
    font-size: 12px;
    margin-top: 4px;
    display: inline-block;
  }

  .tick {
    color: green;
  }

  .cross {
    color: red;
  }
</style>

<br><form class="container" action="index.php" method="post" onsubmit="return confirm('確認登出?');"><input type="submit" class="btn btn-secondary" value=">> 登出" name="logout"></form><br>

  <main class="container my-3">
    <?php
$file = "blog.txt";

// Check if the file exists
if (file_exists($file)) {
    // Read the file content
    $content = file_get_contents($file);
    
    // Check if the file contains blog contents
    if (!empty($content)) {
        // Decode the JSON content into an associative array
        $blog = json_decode($content, true);
        
        // Echo h2
        echo "<h2><em>以往博客</em></h2>";
    }
}
$i = 0;
?>
    <?php foreach ($blogPosts as $index => $blogPost): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h3 class="card-title"><strong><?php echo $blogPost['title']; ?></strong></h3>
          <p class="card-text"><strong>日期:</strong><br> <?php echo $blogPost['timestamp']; ?></p>
          <p class="card-text"><strong>發生的事:</strong><br> <?php echo $blogPost['happened']; ?></p>
          <p class="card-text"><strong>學到的東西:</strong><br> <?php echo nl2br($blogPost['learnt']); ?></p>
          <form method="POST" action="index.php" style="display: inline;" onsubmit="return confirm('確定刪除?');">
            <input type="hidden" name="delete" value="<?php echo $index; ?>">
            <?php $i++; ?>
            <button type="submit" class="btn btn-danger" <?php if($i>10){ echo 'disabled';} ?>>刪除</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    const plusBtn = document.getElementById('plusBtn');
    const crossBtn = document.getElementById('crossBtn');
    const blogForm = document.getElementById('blogForm');

    plusBtn.addEventListener('click', () => {
      plusBtn.classList.add('d-none');
      crossBtn.classList.remove('d-none');
      blogForm.classList.remove('d-none');
    });

    crossBtn.addEventListener('click', () => {
      plusBtn.classList.remove('d-none');
      crossBtn.classList.add('d-none');
      blogForm.classList.add('d-none');
    });
  </script>

  <?php
date_default_timezone_set('Asia/Hong_Kong');

// Get the current date in Hong Kong time zone
$currentDate = new DateTime('now');

// Read the contents of the blog.txt file
$fileContents = file_get_contents('blog.txt');
$lines = explode("\n", $fileContents);

$matchingDates = [];

foreach ($lines as $line) {
    // Skip empty lines
    if (empty($line)) {
        continue;
    }

    // Parse the line as JSON
    $data = json_decode($line, true);

    // Extract the timestamp from the data
    $timestamp = $data['timestamp'];

    // Extract the date part from the timestamp
    preg_match('/(\d{4}\/\d{1,2}\/\d{1,2})/', $timestamp, $dateMatches);
    $timestampDate = $dateMatches[1];

    // Compare the date part with the current date in Hong Kong time zone
    if ($timestampDate === $currentDate->format('Y/m/d')) {
        $matchingDates[] = $timestampDate;
    }
}

// Check if the number of matching dates is 5 or above
if (count($matchingDates) >= 5) {
    // Execute your script here
    echo "
    <script>
      
      var reachedLimit = document.getElementById('reachedLimit');
      reachedLimit.style.display = 'inline';
      var done = document.getElementById('done');
      done.style.display = 'none';
      var btn = document.getElementById('btn');
      btn.setAttribute('disabled','');
      
    </script>";
    // Add your script logic here

    $limit = 1;
}
?>
</body>
</html>
