<?php
session_start();
include('config.php');
$linkco2 = $_GET['li'];

if (isset($_SESSION['username'])){
    header("location: home.php");
}
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p class="error">The combination of Password and Username is incorrect!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                  if (!empty($linkco2)) {
                     $_SESSION['username'] = $username;
                     header("location: ".$linkco2."");
                  } else {
                     $_SESSION['username'] = $username;
                     header("location: home.php");
                  }
            } else {
                echo '<p class="error">The combination of Password and Username is incorrect!</p>';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Basvelia - login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css.css">
<html lang="en-US" />
</head>

<body style="background-color: #424242;">
<form method="post" name="signin-form">
<h2>Log in to BASVELIA</h2><br>
  <div class="form-element">
    <label>Username</label>
    <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
  </div>
  <div class="form-element">
    <label>Password</label>
    <input type="password" name="password" required />
  </div>
  <h3>Don't have a Basvelia profile? <a href="signin.php" style="color: #3993ed; text-decoration: none;">Click here</a></h3><br>
  <button type="submit" name="login" value="login" style="background-color: #ff2e2e;">Enter</button>
</form>

</body>
</html>