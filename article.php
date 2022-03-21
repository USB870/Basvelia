<?php
session_start();
include "config.php";

$idart = $_GET['a'];
$art = $connection->prepare("SELECT * FROM article WHERE id=:idart");
$art->bindParam("idart", $idart, PDO::PARAM_STR);
$resultart = $art->execute();
if ($resultart) {
$resultart = $art->fetchAll();
foreach ($resultart as $rowart) {
$texta = $rowart['text'];
$aut = $rowart['aut'];
$key = $rowart['keyart'];
$tit = $rowart['tit'];
$date = $rowart['date'];

$textas = strip_tags($texta);
$tes = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $textas);
$tes = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="http://basvelia.altervista.org/tag.php?a=$1" style="color: green;">#$1</a>', $tes);

$styles = array ( '*' => 'strong', '&' => 'ul', "€" => 'br', '_' => 'i', '~' => 'strike');

function makeBoldText($orimessage) {
   global $styles;
   return preg_replace_callback('/(?<!\w)([*~_])(.+?)\1(?!\w)/',
      function($m) use($styles) { 
         return '<'. $styles[$m[1]]. '>'. $m[2]. '</'. $styles[$m[1]]. '>';
      },
      $orimessage);
}
$text = $tes;
$text = stripcslashes($text);
}}
//incrementa il num delle views
$viewsselect = $connection->prepare("SELECT * FROM article WHERE id=:idart");
$viewsselect->bindParam("idart", $idart, PDO::PARAM_STR);
$resultviewsselect = $viewsselect->execute();
$resultviewsselect = $viewsselect->fetchAll();
foreach ($resultviewsselect as $rowviews) { $viewsnum = $rowviews['views']; }

$viewsnum = $viewsnum + 1;
$riseviews = $connection->prepare("UPDATE article SET views = :viewsnum WHERE id = :id");
$riseviews->bindParam("viewsnum", $viewsnum, PDO::PARAM_STR);
$riseviews->bindParam("id", $idart, PDO::PARAM_STR);
$resultriseviews = $riseviews->execute();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $tit; ?></title>
<meta charset="UTF-8">
<html lang="en-US">
<meta name="description" content="<?php echo $txt; ?>">
<meta name="keywords" content="<?php echo $key; echo ", Basvelia, online review, review, reviews, anime reviews, anime, book review "; echo $tit; ?>">
<meta name="author" content="<?php echo $aut; ?>">
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 20px;
  /*background: #f1f1f1;*/
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

/* Fake image */
.fakeimg {
  background: #ddd;
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
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

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body style="background-color: #424242;">
<?php
include "navbar.php";
$stmt = $connection->prepare('SELECT * FROM imagesart WHERE id = :ided');
$stmt->bindParam("ided", $idart, PDO::PARAM_STR);
$stmt->execute();
$imagelist = $stmt->fetchAll();
    foreach($imagelist as $image) {
    }
$rowcoima = $stmt->rowCount();

if(isset($_POST['deletes'])) {
    $delfot = $_POST['deletes'];
	$sqldel = $connection->prepare("DELETE FROM imagesart WHERE name=:nameart");        
    $sqldel->bindParam("nameart", $delfot, PDO::PARAM_STR);
	$resultartdel = $sqldel->execute();
    
    $path = "upload";
	$filename =  $path . "/" . $delfot;
    if (file_exists($filename)) {
        unlink($filename);
    } else {
        echo 'Could not delete ' . $filename . ', file does not exist. Errore del1';
    }
}
?>

<div class="row">
  <div class="leftcolumn">
    <div class="card">
      <h2><?php echo $tit; ?></h2>
      <?php
      if(($aut == $_SESSION['username']) and $rowcoima >= 1){
      echo '<a href="http://basvelia.altervista.org/edit.php?a='.$idart.'"><button>Edit article</button></a> <button id="myBtn">Edit photos</button>';
      } else{
      echo '<a href="http://basvelia.altervista.org/edit.php?a='.$idart.'"><button>Edit article</button></a>';
      }

$querypos12 = $connection->prepare("SELECT * FROM modifiche WHERE id = :ided");
//controllo se nella tabella modifiche larticolo è gia stato modificato
$querypos12->bindParam("ided", $idart, PDO::PARAM_STR);
$resultpost12 = $querypos12->execute();
if ($resultpost12) {
	if ($querypos12->rowCount() > 0) {
    	$resultart = $querypos12->fetchAll();
		foreach ($resultart as $rowart) {
			$ridate2 = $rowart['ridate'];
        }
        $varpertimetext = date('d M Y',$ridate2);
        $timetext = ' (Changed on '.$varpertimetext.')';
    } else if ($querypos12->rowCount() == 0) {
    	$timetext = '';
    } else { echo 'Errore wqar.'; }
} else { echo 'Errore wer.'; }
      ?>
      
      <h5><a style="text-decoration: none; border: 2px solid green; padding: 4px 8px; text-align: center;" href="http://basvelia.altervista.org/profile.php?p=<?php echo $aut; ?>">Written by <?php echo $aut; ?></a><br><br><?php echo date('d M Y',$date); echo $timetext; ?></h5>
      <h4><?php echo 'Views : '.$viewsnum.'';?></h4>
      <h5><?php
      $arrkey1 = explode(", ",$key);
      foreach ($arrkey1 as $value) {
      echo '<a href="http://basvelia.altervista.org/tag.php?a='.$value.'" style="color: green; text-decoration: none; font-size: 15px;">#'.$value.' </a>';
      } ?></h5>
      
      <?php
    foreach($imagelist as $image) {
    ?>  
    <img src="<?=$image['image']?>" 
        title="<?=$image['name'] ?>" 
        width='90%' height=''>
    <?php
    }
    ?>
    
      <p style="white-space:pre-wrap;"><?php echo makeBoldtext($text); ?></p>
    </div>
  </div>
  
  <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h4>Eliminated images won't be recoverable; so click it to delete them.</h4>
    <form method="POST">
    <?php
    foreach($imagelist as $image) {
    ?>
    <button type="submit" style="width: 35%;" value="<?php echo $image['name']; ?>" name="deletes"><img src="<?php echo $image['image']; ?>" style="width: 100%;" /></button>
   <?php
    }
    ?>
    </form>
  </div>
</div>

<!--sezione dei suggerimenti -->
  <div class="rightcolumn">
    <div class="card">
      <?php
$id1 = $idart;
$items = $arrkey1;
$numw = count($items);

	$vac = 0;
	for ($vac=0; $vac<$numw; $vac++) {
		$casw = $connection->prepare("SELECT * FROM article WHERE keyart LIKE :key ORDER BY RAND()");
		$casw->bindValue(":key", '%' . $items[$vac] . '%');
		$resultartcasw = $casw->execute();
		if ($resultartcasw) {
			if ($casw->rowCount() > 0) {
        		$resultartcasw = $casw->fetchAll();
				foreach ($resultartcasw as $rowartsw) {
					$scelta1 = $rowartsw['tit'];
					$id1 = $rowartsw['id'];
					$key1 = $rowartsw['keyart'];
				}
        		if ($id1 != $idart) { echo '<h3>Related Article with "'.$items[$vac].'"</h3>'; break; }
    		} elseif ($casw->rowCount()==0) {
        		$casw = $connection->prepare("SELECT * FROM article ORDER BY RAND() LIMIT 1");
        		$result = $casw->execute();
        		if ($result) {
            		$result = $casw->fetchAll();
					foreach ($result as $rowartsw) {
						$scelta1 = $rowartsw['tit'];
						$id1 = $rowartsw['id'];
						$key1 = $rowartsw['keyart'];
					}
                    if ($vac == ($numw-1)) { echo '<h3><h3>Random Article</h3>'; $vac = $numw; break; }
        		} else { echo '<p class="error">Error with upload. Please try again.</p>'; }
     		} else { echo '<p class="error">System error. Reload and try again to resolve.</p>'; }
		} else { echo 'An error occurred while loading (Mercury Error).'; }
	}

$arrkey1 = explode(", ",$key1);
echo '<a style="text-decoration: none;" href="http://basvelia.altervista.org/article.php?a='.$id1.'"><h4>'.$scelta1.'</h4>'; 
foreach ($arrkey1 as $value) { echo '<p style="color: green; text-decoration: none;">#'.$value.' </p>'; }
echo '</a>';
?>
    </div>
    <div class="card">
      <h2>Sponsor</h2>
      <!-- qui ci va l'ads di g-->
      <h4>No announcements for now. If you are interested please contact me on <a href="mailto:python.informazioni@gmail.com">E-MAIL</a></h4>
      <script>!function(d,l,e,s,c){e=d.createElement("script");e.src="//ad.altervista.org/js.ad/size=300X250/?ref="+encodeURIComponent(l.hostname+l.pathname)+"&r="+Date.now();s=d.scripts;c=d.currentScript||s[s.length-1];c.parentNode.insertBefore(e,c)}(document,location)</script>
    </div>
  </div>
</div>

<div class="footer">
  <h2><?php include "footer.php"; ?></h2>
</div>

<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>