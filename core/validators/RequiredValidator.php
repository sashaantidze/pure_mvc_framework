<?php
namespace Core\validators;
use Core\validators\CustomValidator;

class RequiredValidator extends CustomValidator
{
  public function runValidation()
  {
    $value = $this->_model->{$this->field};
    $passes = (!empty($value));
    return $passes;
  }
}
