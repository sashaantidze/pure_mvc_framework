<?php $this->setSiteTitle('Add A Contact'); ?>
<?php $this->start('body'); ?>

<div class="col-md-8 offset-md-2 card card-body bg-light">
  <h2 class="text-center">Add a new contact</h2>
  <hr>
  <?php $this->partial('contacts', 'form'); ?>
</div>

<?php $this->end(); ?>
