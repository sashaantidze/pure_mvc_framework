<?php
namespace Core\validators;
use Core\validators\CustomValidator;

class UniqueValidator extends CustomValidator
{
  public function runValidation()
  {
    $field = (is_array($this->_model->{$this->field})) ? $this->field[0] : $this->field;
    $value = $this->_model->{$field};

    $conditions = ["{$field} = ?"];
    $bind = [$value];

    // check if record's being updated
    if(!empty($this->_model->id)){
      $conditions[] = "id != ?";
      $bind[] = $this->_model->id;
    }

    if(is_array($this->field)){
      array_unshift($this->field);
      foreach($this->field as $adds){
        $conditions[] = "{$adds} = ?";
        $bind[] = $this->_model->{$adds};
      }
    }

    $queryParams = ['conditions'=>$conditions, 'bind'=>$bind];
    $other = $this->_model->findFirst($queryParams);
    return (!$other);
  }


}
