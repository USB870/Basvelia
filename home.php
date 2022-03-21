<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Basvelia - Reviews</title>
<html lang="en-US" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<style>
* {
  box-sizing: border-box;
}

img {
  max-width: 180px;
  display: none;
}

input[type=file] {
  padding: 10px;
  background: #2d2d2d;
  color: #FFF;
  display: block;
  margin-bottom: 20px;
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

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}


#img_div{
    width: 80%;
    padding: 5px;
    margin: 15px auto;
    border: 1px solid #cbcbcb;
}
#img_div:after{
    content: "";
    display: block;
    clear: both;
}
img{
    float: left;
    margin: 5px;
    width: 300px;
    height: 140px;
}
</style>
</head>

<body style="margin:0px; background-color: #424242;">
<?php
if(!isset($_SESSION['username'])) {
header("location: login.php");
}
    if (isset($_POST['invia'])) {
        $tit = filter_var($_POST["titolo"], FILTER_SANITIZE_STRING);
        $text = filter_var($_POST["descrizione"], FILTER_SANITIZE_STRING);
        $aut = $_SESSION['username'];
        $keyart= $_POST["key"];
        $date = strtotime("now");
        $id = uniqid();
        $querypost = $connection->prepare("INSERT INTO article(id,tit,text,aut,date,keyart) VALUES (:id,:tit,:text,:aut,:date,:keyart)");
        $querypost->bindParam("id", $id, PDO::PARAM_STR);
        $querypost->bindParam("tit", $tit, PDO::PARAM_STR);
        $querypost->bindParam("text", $text, PDO::PARAM_STR);
        $querypost->bindParam("aut", $aut, PDO::PARAM_STR);
        $querypost->bindParam("date", $date, PDO::PARAM_STR);
        $querypost->bindParam("keyart", $keyart, PDO::PARAM_STR);
        
        $resultpost = $querypost->execute();
        if ($resultpost) {
        header('location:http://basvelia.altervista.org/article.php?a='.$id.'');
        } else {
        echo "Item was NOT saved";
        }
    
    $countfiles = count($_FILES['files']['name']);
    $query = "INSERT INTO imagesart (id,name,image) VALUES(?,?,?)";
    $statement = $connection->prepare($query);

    for ($i = 0; $i < $countfiles; $i++) {
        $filename = $_FILES['files']['name'][$i];
        $target_file = 'upload/'.$filename;
        $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $valid_extension = array("png","jpeg","jpg");
        if (in_array($file_extension, $valid_extension)) {
            if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {
                $statement->execute(
                    array($id,$filename,$target_file));
            }
        }
    } //echo "File Inserito w successo";
}
include "navbar.php"; ?>
<br><br><div class="container" style="background-color: #424242;">
  <form method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-25">
        <label for="fname" style="color: white;">Title</label>
      </div>
      <div class="col-75">
        <input type="text" id="fname" name="titolo" placeholder="Titolo" required />
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="fname" style="color: white;">Keywords (separate with commas)</label>
      </div>
      <div class="col-75">
        <input type="text" id="fname" name="key" placeholder="esempio: istruzione, studio, scuola" required />
      </div>
    </div>
    <div class="row">
        <div class="col-25">
            <label for="fname" style="color: white;">Photos (even more than one)</label>
        </div>
        <div class="col-75">
            <input type="file" name="files[]" id="profile-img" multiple />
            <img id="profile-img-tag" alt="Anteprima" width="90%" />
        </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="subject" style="color: white;">Text</label>
      </div>
      <div class="col-75">
        <textarea id="subject" name="descrizione" placeholder="*for bold*, _for italics_, #forhashtag, http for url" style="height:200px" required></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" name="invia" value="Send" style="background-color: #ff2e2e;">
    </div>
  </form>
</div>

</body>
</html>