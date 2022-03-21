<?php
session_start();
include('config.php');
if(isset($_SESSION['username'])){
    header("location: home.php");
}
if (isset($_POST['register'])) {
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<p class="error">Username already in use, please change it.</p>';
    }
    elseif ($query->rowCount() == 0) {
        $queryq = $connection->prepare("INSERT INTO users(username,password) VALUES (:username,:password)");
        $queryq->bindParam('username', $username, PDO::PARAM_STR);
        $queryq->bindParam('password', $password_hash, PDO::PARAM_STR);
        $result = $queryq->execute();
        if ($result) {
            $_SESSION['username'] = $username;
            header("location: home.php");
        } else {
            echo '<p class="error">Error with registration. Please try again.</p>';
        }
     } else {echo '<p class="error">System error. Reload and try again to resolve.</p>';}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Basvelia - registrazione</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css.css">
<html lang="en-US" />
</head>

<body style="background-color: #424242;">
<form method="post" name="signup-form">
<h2>Sign up on BASVELIA</h2><br>
<div class="form-element">
<label>Username</label>
<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
</div>
<div class="form-element">
<label>Password</label>
<input type="password" name="password" required />
</div>
<h3>Do you already have a Basvelia profile? <a href="login.php" style="color: #3993ed; text-decoration: none;">Clicca qui</a></h3><br>
<button type="submit" name="register" value="register" style="background-color: #ff2e2e;">Sign me up</button>
</form>

</body>
</html>