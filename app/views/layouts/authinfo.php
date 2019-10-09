<?php
use App\Models\Users;
 ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
          <div class="card card-body bg-dark text-white">
              <div class="media">

                  <div class="media-body">
                      <h4 class="media-heading"><?=Users::currentUser()->fname.' '.Users::currentUser()->lname?></h4>
                  <p>
                    <span class="label label-info"><?=Users::currentUser()->email?></span><br>
                    <span class="label label-warning"><?=Users::currentUser()->username?></span>
                  </p>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
