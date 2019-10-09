<?php
use Core\Session;
use App\Models\Users;
 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/fontawesome.all.min.css">
    <link rel="stylesheet" type="text/css" href="<?=PROOT?>css/custom.css">

    <script type="text/javascript" src="<?=PROOT?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=PROOT?>js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?=PROOT?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=PROOT?>js/contacts.js"></script>


    <?=$this->content('head')?>

    <title><?=$this->_siteTitle?></title>
  </head>
  <body>
    <?php (Users::currentUser()) ? include 'authinfo.php' : ''; ?>
    <?php include 'main_menu.php' ?>

    <div class="container-fluid" style="min-height:cal(100% - 125px)">
      <?=Session::displayMsg()?>

      <?=Session::createSwalMsg('swalMsgParams')?>
      <?=$this->content('body')?>
    </div>



  </body>
</html>
