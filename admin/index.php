<?php
session_start();

if (!isset($_SESSION['id_user']) and !isset($_POST['login'])) {
  header("Location: login.php");
  exit();
}


require '../config.php';
require 'parts/header.php';
require 'parts/navbar.php';
require 'parts/sidebar.php';
?>

<div class="main-wrapper">
  <div class="main-container">
    <?php
    if (!empty($url)) {
      include  $url . '.php';
    } else {
      include  'home_admin.php';
    }
    ?>
  </div>
</div>
<?php
require  'parts/footer.php' ?>