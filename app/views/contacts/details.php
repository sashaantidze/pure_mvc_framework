<?php $this->setSiteTitle($this->contact->displayFullName() . ' - Contact Details'); ?>
<?php $this->start('body'); ?>

<div class="col-md-8 offset-md-2 card card-body bg-light">
  <h2 class="text-center mb-5"><?=$this->contact->displayFullName()?></h2>

  <div class="row">
    <div class="col-md-6 text-center">
      <p><span class="font-weight-bold">Email: </span> <?=$this->contact->email?></p>
    </div>
    <div class="col-md-6 text-center">
      <p><span class="font-weight-bold">Cell Phone: </span> <?=$this->contact->cell_phone?></p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 text-center">
      <p><span class="font-weight-bold">Home Phone: </span> <?=$this->contact->home_phone?></p>
    </div>
    <div class="col-md-6 text-center">
      <p><span class="font-weight-bold">Work Phone: </span> <?=$this->contact->work_phone?></p>
    </div>
  </div>

  <div class="row">

    <div class="col-md-12 text-center"><h3>Address</h3><?=$this->contact->displayAddressLabel()?></div>
  </div>

  <div class="row">
    <div class="col-md-2">
      <a href="javascript:history.go(-1)" class="btn btn-xs btn-primary">Back</a>
    </div>
  </div>

</div>

<?php $this->end(); ?>
