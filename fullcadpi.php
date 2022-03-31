<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Basvelia - Full CADPI</title>
<meta charset="UTF-8">
<html lang="en-US" />
<meta name="keywords" content="Basvelia, CADPI, CADI, online review, review, reviews, anime reviews, anime, book review">
<meta name="author" content="Basvelia">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style>
* {
  box-sizing: border-box;
}
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}
.row:after {
  content: "";
  display: table;
  clear: both;
}
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>

<body style="margin:0px; background-color: #424242; text-align: center;">
<?php include "navbar.php"; ?>
<br><br><div class="container" style="background-color: #424242;">
<h2 style="text-align: center; color: red;">Codice d'Autentificazione per Documenti Parzialmente Integrali (formato cartaceo)<br> <a href="https://basvelia.altervista.org/cadpi.php" style="color: white;">C.A.D.P.I [click here for the private list]</a></h2>
<h2 style="text-align: center; color: red;"><br>Authentication Code for Partially Integral Documents (paper format) A.C.P.I.D</h2>
<h2 style="text-align: center; color: white;"><br>All the CADPI below made by EVERYONE</h2>
<?php
$art = $connection->prepare("SELECT * FROM cadpi ORDER BY date DESC");
$art->bindParam("aut", $aut, PDO::PARAM_STR);
$art->execute();
$resultart = $art->fetchAll();
foreach ($resultart as $rowart) {
$id = $rowart['id'];
$date = $rowart['date'];
$text = $rowart['text'];
$timetext = date('d M Y',$date);
echo '<ul  style="text-align: center; color: white;"><div class="boxart">'.$id.'<br>Desc : '.$text.'<br>Time : '.$timetext.'</div><br><hr style="color: white;"></ul>';
}
?>
</div>
</body>
</html>