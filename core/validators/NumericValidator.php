<?php
namespace Core\validators;
use Core\validators\CustomValidator;

class NumericValidator extends CustomValidator
{

  public function runValidation()
  {
    $value = $this->_model->{$this->field};
    $pass = true;
    if(!empty($value)){
      $pass = is_numeric($value);
    }
    return $pass;
  }

}
