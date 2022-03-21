<?php
session_start();
include "config.php";

$idart = $_GET['a'];
if (isset($_POST['inviaterm'])) {
$term = $_POST['term'];
header("location:http://basvelia.altervista.org/tag.php?a=".$term."");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Basvelia - Search</title>
<meta charset="UTF-8">
<html lang="en-US" />
<meta name="keywords" content="Basvelia, reviews, anime">
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
input[type=text] {
  width: 50%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}
input[type=submit] {
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
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
<?php
include "navbar.php";
?>

<div class="row">
  <div class="leftcolumn">
    <div class="card">
      <h2>Searched for "<?php echo $idart; ?>"</h2>
      <form method="post"> 
      <input type="text" name="term" required />
      <input type="submit" name="inviaterm" style="background-color: #ff2e2e;" value="Search">
      </form>
      <p style="white-space:pre-wrap;">
      <?php
$art = $connection->prepare("SELECT * FROM article WHERE (keyart LIKE :needle OR tit LIKE :needle OR text LIKE :needle OR aut LIKE :needle) ORDER BY date DESC");
$needle = '%'.$idart.'%';
$art->bindValue(':needle', $needle, PDO::PARAM_STR);
$art->execute();
$resultart = $art->fetchAll();
foreach ($resultart as $rowart) {
$aut = $rowart['aut'];
$key = $rowart['keyart'];
$tit = $rowart['tit'];
$idarta = $rowart['id'];
$date = $rowart['date'];
echo '<ul><li><a style="text-decoration: none; font-size: 20px;" href="http://basvelia.altervista.org/article.php?a='.$idarta.'"><div class="boxart">'.$tit.'<br></div></a><br></li></ul>';
}
if ($art->rowCount() ==0) {
echo '<h3>No results available</h3>';
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