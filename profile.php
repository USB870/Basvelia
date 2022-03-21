<?php
session_start();
include "config.php";

$usernamecon = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile | Basvelia</title>
<html lang="en-US" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.rightcolumn2 {
  float: left;
  width: 25%;
  padding-left: 20px;
}
.boxart {
   background-color: #ddd;
   padding: 20px;
   margin-top: 20px;
   width: 85%;
   text-align: center;
   margin-left: 5px;
}

.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}
</style>
</head>

<body style="background-color: #424242; width:100%;">
<?php include "navbar.php"; ?>

<?php
echo '<br><br><br>';
$username = $_GET['p'];
$artpr = $connection->prepare("SELECT * FROM users WHERE username=:username");
$artpr->bindParam("username", $username, PDO::PARAM_STR);
$resultartpr = $artpr->execute();
if ($resultartpr) {
$artpr2 = $connection->prepare("SELECT * FROM article WHERE aut=:username ORDER BY date DESC");
$artpr2->bindParam("username", $username, PDO::PARAM_STR);
$resultartpr2 = $artpr2->execute();
if ($resultartpr2) {
$resultartpr2 = $artpr2->fetchAll();
foreach ($resultartpr2 as $rowartpr) {
$textidarttext = $rowartpr['tit'];
$textidart = $rowartpr['id'];
echo '<a style="text-decoration: none; font-size: 20px;" href="http://basvelia.altervista.org/article.php?a='.$textidart.'"><div class="boxart">'.$textidarttext.'<br></div></a>';
}}}
?>

<div class="footer">
<h2><?php include "footer.php"; ?></h2>
</div>
</body>

</html>