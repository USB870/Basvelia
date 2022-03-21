<?php
session_start();
include "config.php";

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Main Articles</title>
<meta charset="UTF-8">
<html lang="en-US" />
<meta name="keywords" content="Basvelia, online review, review, reviews, anime reviews, anime, book review">
<meta name="author" content="Basvelia">
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 20px;
}

/* Header/Blog Title */
.header {
  padding: 20px;
  font-size: 40px;
  text-align: center;
  background: #ddd;
}

/* Left column */
.leftcolumn {   
  float: left;
  width: 75%;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 25%;
  padding-left: 20px;
}

.card {
   background: #ddd;
   padding: 20px;
   margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}

@media screen and (min-width: 801px) {
.row {margin-top:50px;}
}

@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
    background: #424242;
  }
  body {
  padding: 0px;
  }
}
</style>
</head>

<body style="background-color: #424242;">
<?php include "navbar.php"; ?>
<div class="row">
  <div class="leftcolumn">
    <div class="card">
      <h2>Most viewed Articles</h2>
      <p style="white-space:pre-wrap;">
      <?php
$art = $connection->prepare("SELECT * FROM article ORDER BY views DESC LIMIT 12");
$art->execute();
$resultart = $art->fetchAll();
foreach ($resultart as $rowart) {
$aut = $rowart['aut'];
$key = $rowart['keyart'];
$tit = $rowart['tit'];
$idarta = $rowart['id'];
$date = $rowart['date'];
$views = $rowart['views'];
$arrkey = explode(", ",$key);
echo '<ul><li><a style="text-decoration: none; font-size: 20px;" href="http://basvelia.altervista.org/article.php?a='.$idarta.'"><div class="boxart">'.$tit.'<br>Views : '.$views.'</div>';
foreach ($arrkey as $value) { echo '<p style="color: green; text-decoration: none;">#'.$value.' </p>'; }
echo '</a><br></li></ul>';
}
?></p>
    </div>
  </div>
  
  <div class="rightcolumn">
    <div class="card">
      <h3>Interesting Article</h3>
      <?php 
$casw = $connection->prepare("SELECT * FROM article ORDER BY RAND() LIMIT 1");
$resultartcasw = $casw->execute();
if ($resultartcasw) {
$resultartcasw = $casw->fetchAll();
foreach ($resultartcasw as $rowartsw) {
$scelta1 = $rowartsw['tit'];
$id1 = $rowartsw['id'];
$key1 = $rowartsw['keyart'];
}}
$arrkey1 = explode(", ",$key1);
echo '<a style="text-decoration: none;" href="http://basvelia.altervista.org/article.php?a='.$id1.'"><h4>'.$scelta1.'</h4>'; 
foreach ($arrkey1 as $value) { echo '<p style="color: green; text-decoration: none;">#'.$value.' </p>'; }
?>
    </div>
    <div class="card">
      <h2>Sponsor</h2>
      <!-- qui ci va l'ads di g-->
      <h4>No announcements for now. If you are interested please contact me on <a href="mailto:python.informazioni@gmail.com">python.informazioni@gmail.com</a></h4>
    </div>
  </div>
</div>

<div class="footer">
  <h2><?php include "footer.php"; ?></h2>
</div>

</body>
</html>