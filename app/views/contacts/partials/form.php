<?php
use Core\FH;
 ?>
<form action="<?=$this->postAction?>" class="form" method="post">
  <?=FH::displayErrors($this->displayErrors)?>
  <?=FH::csrfInput()?>
  <div class="row">
    <?=FH::inputBlock('text', 'First Name', 'fname', $this->contact->fname, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
    <?=FH::inputBlock('text', 'Last Name', 'lname', $this->contact->lname, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
  </div>
  <div class="row">
    <?=FH::inputBlock('text', 'Address', 'address', $this->contact->address, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
    <?=FH::inputBlock('text', 'Address 2', 'address2', $this->contact->address2, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
  </div>
  <div class="row">
    <?=FH::inputBlock('text', 'City', 'city', $this->contact->city, ['class'=>'form-control'], ['class'=>'form-group col-md-5'])?>
    <?=FH::inputBlock('text', 'State', 'state', $this->contact->state, ['class'=>'form-control'], ['class'=>'form-group col-md-3'])?>
    <?=FH::inputBlock('text', 'Zip Code', 'postal_code', $this->contact->postal_code, ['class'=>'form-control'], ['class'=>'form-group col-md-4'])?>
  </div>
  <div class="row">
    <?=FH::inputBlock('text', 'Email', 'email', $this->contact->email, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
    <?=FH::inputBlock('text', 'Cell Phone', 'cell_phone', $this->contact->cell_phone, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
  </div>
  <div class="row">
    <?=FH::inputBlock('text', 'Home Phone', 'home_phone', $this->contact->home_phone, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
    <?=FH::inputBlock('text', 'Work Phone', 'work_phone', $this->contact->work_phone, ['class'=>'form-control'], ['class'=>'form-group col-md-6'])?>
  </div>
  <div class="text-right">
      <a href="<?=PROOT?>contacts" class="btn btn-danger">Cancel</a>
      <?=FH::submitTag('Save', ['class'=>'btn btn-primary'])?>
  </div>
</form>
