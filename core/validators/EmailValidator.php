<?php
namespace Core\validators;
use Core\validators\CustomValidator;

class EmailValidator extends CustomValidator
{

  public function runValidation()
  {
    $email = $this->_model->{$this->field};
    $pass = true;
    if(!empty($email)){
      $pass = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    return $pass;
  }

}
