<?php $this->setSiteTitle($this->contact->displayFullName() . ' - Edit A Contact'); ?>
<?php $this->start('body'); ?>

<div class="col-md-8 offset-md-2 card card-body bg-light">
  <h2 class="text-center">Edit <?=$this->contact->displayFullName()?></h2>
  <hr>
  <?php $this->partial('contacts', 'form'); ?>
</div>

<?php $this->end(); ?>
