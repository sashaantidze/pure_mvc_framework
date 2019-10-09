<?php $this->start('body'); ?>

  <h2 class="text-center">My Contacts <span id="headerLoader" class="hidden"><i class="fas fa-spinner fa-spin"></i></span></h2>
  <table class="table table-hover table-striped table-condensed table-bordered">

    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Cell Phone</th>
        <th>Home Phone</th>
        <th>Work Phone</th>
        <th colspan="2">Actions</th>
      </tr>
    </thead>

    <tbody>

      <?php foreach($this->contacts as $contact) : ?>

        <tr id="contactTableRow-<?=$contact->id?>">
          <td id="fullname-<?=$contact->id?>" data-name="fullname" ondblclick="editContactDetail(this);"><?=$contact->displayFullName()?></td>
          <td id="email-<?=$contact->id?>" data-name="email" ondblclick="editContactDetail(this);"><?=$contact->email?></td>
          <td id="cell_phone-<?=$contact->id?>" data-name="cell_phone" ondblclick="editContactDetail(this);"><?=$contact->cell_phone?></td>
          <td id="home_phone-<?=$contact->id?>" data-name="home_phone" ondblclick="editContactDetail(this);"><?=$contact->home_phone?></td>
          <td id="work_phone-<?=$contact->id?>" data-name="work_phone" ondblclick="editContactDetail(this);"><?=$contact->work_phone?></td>
          <td class="text-center">
            <a class="btn btn-xs btn-info" href="<?=PROOT?>contacts/details/<?=$contact->id?>">Details <i class="fas fa-info"></i></a>
            <a class="btn btn-xs btn-primary" href="<?=PROOT?>contacts/edit/<?=$contact->id?>">Edit <i class="fas fa-edit"></i></a>
          </td>
          <td class="text-center"><a class="btn btn-xs btn-danger" onclick="if(!confirm('Are you sure you want to delete this contact?')){return false;}" href="<?=PROOT?>contacts/delete/<?=$contact->id?>">Delete <i class="fas fa-trash-alt"></i></a></td>

        </tr>

      <?php endforeach; ?>

    </tbody>
  </table>

<?php $this->end(); ?>
