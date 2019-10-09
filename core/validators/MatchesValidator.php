<?php
namespace Core\validators;
use Core\validators\CustomValidator;


class MatchesValidator extends CustomValidator
{

  public function runValidation()
  {
    $value = $this->_model->{$this->field};
    return $value == $this->rule;
  }

}
