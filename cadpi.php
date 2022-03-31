<?php
session_start();
include "config.php";
$aut = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Basvelia - CADPI</title>
<meta charset="UTF-8">
<html lang="en-US" />
<meta name="keywords" content="Basvelia, CADPI, CADI, online review, review, reviews, anime reviews, anime, book review">
<meta name="author" content="Basvelia">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
<script>
function cancel() {
  var x = document.getElementById("cancel_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</head>

<body style="margin:0px; background-color: #424242;">
<?php
if (isset($_POST['invia']) and isset($_SESSION['username'])) {
	$id = filter_var($_POST["id"], FILTER_SANITIZE_STRING);
    $text = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
    $date = strtotime("now");
    $annullante = $_POST['canceldiv'];
    if (strlen($annullante)>=1) {
    	$text = 'ANNULLAMENTO di "'.$annullante.'"; maggiori info : '.$text.'';
    }
    $querypos12 = $connection->prepare("SELECT * FROM cadpi WHERE id =:id");
	$querypos12->bindParam("id", $id, PDO::PARAM_STR);
	$resultpost12 = $querypos12->execute();
	if ($querypos12->rowCount() == 0 and $id<=9) {
    	$querypost = $connection->prepare("INSERT INTO cadpi(id,text,aut,date) VALUES (:id,:text,:aut,:date)");
    	$querypost->bindParam("id", $id, PDO::PARAM_STR);
    	$querypost->bindParam("text", $text, PDO::PARAM_STR);
    	$querypost->bindParam("aut", $aut, PDO::PARAM_STR);
    	$querypost->bindParam("date", $date, PDO::PARAM_STR);
    	$resultpost = $querypost->execute();
    	if (!$resultpost) {
    		echo "<script>swal('Error', 'Item was NOT saved, please retry', 'error')</script>";
    	}
     } else {echo "<script>swal('Error', 'Item was NOT saved, please retry', 'error')</script>";}
}
include "navbar.php"; ?>
<br><br><div class="container" style="background-color: #424242;">
<h2 style="text-align: center; color: red;">Codice d'Autentificazione per Documenti Parzialmente Integrali (formato cartaceo)<br> <a href="https://basvelia.altervista.org/fullcadpi.php" style="color: white;">C.A.D.P.I [click here for the public global list]</a></h2>
  <form method="post">
    <div class="row">
      <div class="col-25">
        <label for="fname">ID (max 9 letters)</label>
      </div>
      <div class="col-75">
        <input type="text" id="fname" name="id" rel="gp" placeholder="Identification Sequence (max 9)" data-size="9" data-character-set="a-z,A-Z,0-9,#" required>
        <span class="input-group-btn"><button type="button" class="btn btn-default getNewPass"><span class="fa fa-refresh"></span></button></span>
      </div>
    </div>
    <button onclick="cancel()">Do you want to cancel an existing CADPI?</button>
<div id="cancel_div" style="display: none;">
  <input id="myInput" type="text" name="canceldiv" placeholder="Search on your CADPI to undo it..">
</div>
    <div class="row">
      <div class="col-25">
        <label for="subject">Description</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="description" placeholder="be careful to write a comprehensive description to make physical recognition more accurate" style="height:100px" required></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" name="invia" value="Send" style="background-color: #ff2e2e;">
    </div>
  </form>
</div>
<h2 style="text-align: center; color: white;">All the CADPI below made at your name</h2>
<?php
$art = $connection->prepare("SELECT * FROM cadpi WHERE aut=:aut ORDER BY date DESC");
$art->bindParam("aut", $aut, PDO::PARAM_STR);
$art->execute();
$resultart = $art->fetchAll();
foreach ($resultart as $rowart) {
$id = $rowart['id'];
$date = $rowart['date'];
$text = $rowart['text'];
$timetext = date('d M Y',$date);
echo '<ul id="myList" style="text-align: center; color: white;"><li><div class="boxart">'.$id.'<br>Desc : '.$text.'<br>Time : '.$timetext.'</div><br><hr style="color: white;"></li></ul>';
}
?>

<script>
function randString(id){
  var dataSet = $(id).attr('data-character-set').split(',');  
  var possible = '';
  if($.inArray('a-z', dataSet) >= 0){
    possible += 'abcdefghijklmnopqrstuvwxyz';
  }
  if($.inArray('A-Z', dataSet) >= 0){
    possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  }
  if($.inArray('0-9', dataSet) >= 0){
    possible += '0123456789';
  }
  if($.inArray('#', dataSet) >= 0){
    possible += '[]%&*$#^~@|';
  }
  var text = '';
  for(var i=0; i < $(id).attr('data-size'); i++) {
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  return text;
}
$('input[rel="gp"]').each(function(){
  $(this).val(randString($(this)));
});
$(".getNewPass").click(function(){
  var field = $(this).closest('div').find('input[rel="gp"]');
  field.val(randString(field));
});
$('input[rel="gp"]').on("click", function () {
   $(this).select();
});
</script>
</body>
</html>