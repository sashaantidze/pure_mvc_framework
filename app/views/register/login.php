<?php
use Core\FH;
 ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="col-md-6 offset-md-3 card card-body bg-light">
  <form class="form" action="<?=PROOT?>register/login" method="post">
    <?=FH::csrfInput()?>
    <?=FH::displayErrors($this->displayErrors)?>

    <h3 class="text-center">Log in</h3>
    <?=FH::inputBlock('text', 'Username', 'username', $this->login->username, ['class'=>'form-control'],['class'=>'form-group'])?>
    <?=FH::inputBlock('password', 'Password', 'password', '', ['class'=>'form-control'],['class'=>'form-group'])?>
    <?=FH::checkboxBlock('Remembe Me', 'remember_me', $this->login->getRememberMeChecked(), [], ['class'=>'form-group'])?>

    <?=FH::submitBlock('Login', ['class'=>'btn btn-lg btn-success'], ['class'=>'form-group'])?>


    <div class="text-right">
      <a href="<?=PROOT?>register/register" class="btn btn-md btn-info">Register Now</a>
      <a href="<?=PROOT?>" class="btn btn-sm btn-info">Home</a>
    </div>

  </form>
</div>


<?php $this->end(); ?>
