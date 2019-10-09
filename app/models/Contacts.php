<?php
namespace App\models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\UniqueValidator;
use Core\Validators\NumericValidator;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;

class Contacts extends Model
{

  public $id,$user_id,$fname,$lname,$address,$address2,$city,$state,$postal_code;
  public $email,$home_phone,$cell_phone,$work_phone,$deleted=0;

  public function __construct()
  {
    $table = 'contacts';
    parent::__construct($table);
    $this->_softDelete = true;
  }


  public function validator()
  {
    $this->run_Validation(new RequiredValidator($this, ['field'=>'fname', 'msg'=>'First name is required']));
    $this->run_Validation(new RequiredValidator($this, ['field'=>'lname', 'msg'=>'Last name is required']));
    $this->run_Validation(new RequiredValidator($this, ['field'=>'email', 'msg'=>'Email is required']));
    $this->run_Validation(new RequiredValidator($this, ['field'=>'cell_phone', 'msg'=>'Cell phone is required.']));
    $this->run_Validation(new NumericValidator($this, ['field'=>'cell_phone', 'msg'=>'Please provide a valid cell phone number.']));
    $this->run_Validation(new NumericValidator($this, ['field'=>'home_phone', 'msg'=>'Please provide a valid cell phone number.']));
    $this->run_Validation(new NumericValidator($this, ['field'=>'work_phone', 'msg'=>'Please provide a valid cell phone number.']));
    $this->run_Validation(new UniqueValidator($this, ['field'=>'email', 'msg'=>'Email already exists. Pick another one.']));
    $this->run_Validation(new EmailValidator($this, ['field'=>'email', 'msg'=>'Please provide a valid email.']));
    $this->run_Validation(new MinValidator($this, ['field'=>'email', 'rule'=>3, 'msg'=>'Given email is too short.']));
    $this->run_Validation(new MaxValidator($this, ['field'=>'fname', 'rule'=>156, 'msg'=>'First name must be less than 156 characters']));
    $this->run_Validation(new MaxValidator($this, ['field'=>'lname', 'rule'=>156, 'msg'=>'Last name must be less than 156 characters']));
    $this->run_Validation(new MinValidator($this, ['field'=>'fname', 'rule'=>3, 'msg'=>'First name must be at least 3 characters']));
    $this->run_Validation(new MinValidator($this, ['field'=>'lname', 'rule'=>3, 'msg'=>'Last name must be at least 3 characters']));
  }


  public function findAllByUserId($user_id, $params = [])
  {
    $conditions = [
      'conditions' => '`user_id` = ?',
      'bind' => [$user_id]
    ];
    $conditions = array_merge($conditions, $params);
    return $this->find($conditions);
  }


  public function displayFullName()
  {
    return $this->fname . ' ' . $this->lname;
  }


  public function findByIdAndUserId($contact_id, $user_id, $params = [])
  {
    $conditions = [
      'conditions' => '`id` = ? AND `user_id` = ?',
      'bind' => [$contact_id, $user_id]
    ];
    $conditions = array_merge($conditions, $params);
    return $this->findFirst($conditions);
  }


  public function displayAddress()
  {
    $address = '';
    if(!empty($this->address)){
      $address .= $this->address .'<br>';
    }
    if(!empty($this->address2)){
      $address .= $this->address2 .'<br>';
    }
    if(!empty($this->city)){
      $address .= $this->city .', ';
    }

    $address .= $this->state . ' ' . $this->postal_code . '<br>';

    return $address;
  }


  public function displayAddressLabel()
  {
    $html = $this->displayFullName() .'<br>';
    $html .= $this->displayAddress();

    return $html;
  }



}
