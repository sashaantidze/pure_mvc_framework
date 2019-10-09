<?php
use Core\Router;
use Core\H;
use App\Models\Users;


  $menu = Router::getMenu('menu_acl');
  $currentPage = H::currentPage();

 ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand " href="<?=PROOT?>home"><?=SITE_TITLE?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="main_menu">
    <ul class="navbar-nav mr-auto">
      <?php foreach($menu as $key => $value) :
      $active = ''; ?>
      <?php if(is_array($value)) : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=$key?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php foreach($value as $k => $v) :
            $active = ($v == $currentPage) ? 'active' : ''; ?>
            <?php if($k == 'separator') : ?>
              <div class="dropdown-divider"></div>
            <?php else : ?>
              <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?></a>
            <?php endif; ?>

            <?php endforeach; ?>
          </div>
        </li>
      <?php else :
        $active = ($value == $currentPage) ? 'active' : ''; ?>
        <li class="nav-item">
          <a class="dropdown-item  <?=$active?>" href="<?=$value?>"><?=$key?></a>
        </li>
      <?php endif; ?>
      <?php endforeach; ?>

    </ul>

    <div class="">
      <?php if(Users::currentUser()) : ?>
        <h4>
          <a class="badge badge-dark" href="">Hello <?=Users::currentUser()->username?></a>
          <a class="badge badge-primary" href="<?=PROOT?>register/profile">Profile </a>
        </h4>
      <?php endif; ?>
    </div>


  </div>
</nav>
