<?php
session_start();

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the user.txt file
    $file = file_get_contents('http://photograph.eu.org/blog/user.txt');

    // Split the file contents into an array of lines
    $lines = explode("\n", $file);

    // Loop through the lines to find a match
    foreach ($lines as $line) {
        // Split the line into username and password using comma as the delimiter
        list($storedUsername, $storedPassword) = explode(',', $line);

        // Trim any whitespace
        $storedUsername = trim($storedUsername);
        $storedPassword = trim($storedPassword);


        // Check if the stored username matches $_SESSION['username']
        if ($storedUsername == $_SESSION['username']) {
            // Check if the entered password matches the stored password
            if ($_POST['password'] == $storedPassword) {
                // Password is correct, save it in $_SESSION['password']
                $_SESSION['password'] = $_POST['password'];

                // Redirect to index.php
                echo '<script>window.location.href = "index.php";</script>';
                exit;
            } else {
                // Incorrect password
                $errorMessage = "密碼不正確。";
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#2b2b2b">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入博客</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form action="" method="post" class="needs-validation">
            <div class="mb-3">
                <label for="password" class="form-label">輸入你的密碼:</label>
                <input type="password" name="password" id="password" class="form-control" value="<?php echo $_SESSION['password']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">提交</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
