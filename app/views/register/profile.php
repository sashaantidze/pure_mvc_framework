<?php
use Core\FH;
 ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>

<h1 class="text-center text-primary">Profile</h1>

<div class="col-md-6 offset-md-3 card card-body bg-light">
  <h3 class="text-center">Profile details</h3><hr>
  <form action="" method="post" class="form">
    <?=FH::csrfInput()?>
    <?=FH::displayErrors($this->displayErrors)?>

    <?=FH::inputBlock('text', 'First name', 'fname', $this->user->fname, ['class'=>'form-control input-sm'],['class'=>'form-group'])?>
    <?=FH::inputBlock('text', 'Last name', 'lname', $this->user->lname, ['class'=>'form-control input-sm'],['class'=>'form-group'])?>
    <?=FH::inputBlock('text', 'Email', 'email', $this->user->email, ['class'=>'form-control input-sm'],['class'=>'form-group'])?>
    <?=FH::inputBlock('text', 'Username', 'username', $this->user->username, ['class'=>'form-control input-sm'],['class'=>'form-group'])?>
    <hr>
    <?=FH::submitBlock('Update', ['class'=>'btn btn-primary btn-lg'],['class'=>'text-right'])?>



  </form>
</div>

<?php $this->end(); ?>
