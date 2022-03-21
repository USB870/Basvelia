<style>
body {
  margin: 0;
  font-family: Helvetica, sans-serif;
}

a {
  color: #000;
}
.headernav {
  background-color: #fff;
  box-shadow: 1px 1px 4px 0 rgba(0,0,0,.1);
  position: fixed;
  width: 100%;
  z-index: 3;
}

.headernav ul {
  margin: 0;
  padding: 0;
  list-style: none;
  overflow: hidden;
  background-color: #fff;
}

.headernav li a {
  display: block;
  padding: 20px 20px;
  border-right: 1px solid #f4f4f4;
  text-decoration: none;
}

.headernav li a:hover,
.headernav .menu-btn:hover {
  background-color: #f4f4f4;
}

.headernav .logo {
  display: block;
  float: left;
  font-size: 2em;
  padding: 10px 20px;
  text-decoration: none;
}

/* menu */

.headernav .menu {
  clear: both;
  max-height: 0;
  transition: max-height .2s ease-out;
}

/* menu icon */

.headernav .menu-icon {
  cursor: pointer;
  display: inline-block;
  float: right;
  padding: 28px 20px;
  position: relative;
  user-select: none;
}

.headernav .menu-icon .navicon {
  background: #333;
  display: block;
  height: 2px;
  position: relative;
  transition: background .2s ease-out;
  width: 18px;
}

.headernav .menu-icon .navicon:before,
.headernav .menu-icon .navicon:after {
  background: #333;
  content: '';
  display: block;
  height: 100%;
  position: absolute;
  transition: all .2s ease-out;
  width: 100%;
}

.headernav .menu-icon .navicon:before {
  top: 5px;
}

.headernav .menu-icon .navicon:after {
  top: -5px;
}

/* menu btn */

.headernav .menu-btn {
  display: none;
}

.headernav .menu-btn:checked ~ .menu {
  max-height: 240px;
}

.headernav .menu-btn:checked ~ .menu-icon .navicon {
  background: transparent;
}

.headernav .menu-btn:checked ~ .menu-icon .navicon:before {
  transform: rotate(-45deg);
}

.headernav .menu-btn:checked ~ .menu-icon .navicon:after {
  transform: rotate(45deg);
}

.headernav .menu-btn:checked ~ .menu-icon:not(.steps) .navicon:before,
.headernav .menu-btn:checked ~ .menu-icon:not(.steps) .navicon:after {
  top: 0;
}

/* 48em = 768px */

@media (min-width: 48em) {
  .headernav li {
    float: left;
  }
  .headernav li a {
    padding: 20px 30px;
  }
  .headernav .menu {
    clear: none;
    float: right;
    max-height: none;
  }
  .headernav .menu-icon {
    display: none;
  }
}

.buttonalink {

      background: none repeat scroll 0 0;

      border: 1px solid #aa8d56;

      color: #aa8d56;

      outline: medium none;

      text-decoration: none;
}
</style>
<header class="headernav">
  <a href="http://basvelia.altervista.org/home.php" class="logo">Basvelia</a>
  <?php $linkco = $_SERVER['REQUEST_URI']; if (!$_SESSION['username']){echo'<a style="color: red;" class="buttonalink" href="http://basvelia.altervista.org/login.php?li='.$linkco.'">LOG IN or SIGN UP</a>';}?>
  <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="menu">
    <li><a href="http://basvelia.altervista.org/profile.php?p=<?php $nameonlypr = $_SESSION['username'];
 echo $nameonlypr; ?>">Profile</a></li>
 <li><a href="http://basvelia.altervista.org/index.php">Main Articles</a></li>
    <li><a href="http://basvelia.altervista.org/tag.php">Tags</a></li>
    <li><a href="http://basvelia.altervista.org/prog.php">Projects</a></li>
  </ul>
</header>