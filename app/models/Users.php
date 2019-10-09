<?php
namespace App\models;
use Core\Model;
use App\Models\Users;
use App\Models\UserSessions;
use Core\Cookie;
use Core\Session;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;

class Users extends Model
{

  private $_isLoggedIn, $_sessionName, $_cookieName, $_confirm;
  public static $currentLoggedInUser = null;
  public $id,$username,$email,$password,$fname,$lname,$acl,$deleted=0;

  public function __construct($user = '')
  {

    $table = 'users';
    parent::__construct($table);
    $this->_sessionName = CURRENT_USER_SESSION_NAME;
    $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
    $this->_softDelete = true;
    if($user != ''){
      if(is_int($user)){
        $u = $this->_db->findFirst('users', ['conditions'=>'id = ?', 'bind'=>[$user]], 'App\Models\Users');
      }else{
        $u = $this->_db->findFirst('users', ['conditions'=>'username = ?', 'bind'=>[$user]], 'App\Models\Users');
      }
      if($u){
        foreach($u as $key => $value){
          $this->$key = $value;
        }
      }
    }
  }


  public function validator()
  {
    $this->run_Validation(new RequiredValidator($this, ['field'=>'fname', 'msg'=>'First name is required.']));
    $this->run_Validation(new RequiredValidator($this, ['field'=>'lname', 'msg'=>'Last name is required.']));
    $this->run_Validation(new RequiredValidator($this, ['field'=>'email', 'msg'=>'Email is required.']));
    $this->run_Validation(new EmailValidator($this, ['field'=>'email', 'msg'=>'You must provide a valid email address.']));
    $this->run_Validation(new UniqueValidator($this, ['field'=>'username', 'msg'=>'Username already exists. Pick another one.']));
    $this->run_Validation(new UniqueValidator($this, ['field'=>'email', 'msg'=>'Email already exists. Pick another one.']));

    $this->run_Validation(new MinValidator($this, ['field'=>'username', 'rule'=>3, 'msg'=>'Username must be at least 6 characters long.']));
    $this->run_Validation(new MaxValidator($this, ['field'=>'username', 'rule'=>100, 'msg'=>'Username must be at maximum 10 characters long.']));
    if($this->isNew()){
      $this->run_Validation(new RequiredValidator($this, ['field'=>'password', 'msg'=>'Password is required.']));
      $this->run_Validation(new MinValidator($this, ['field'=>'password', 'rule'=>5, 'msg'=>'Password must be minimum 5 characters long.']));
      $this->run_Validation(new MatchesValidator($this, ['field'=>'password', 'rule'=>$this->_confirm, 'msg'=>'Password fields must match.']));
    }

  }


  public function beforeSave()
  {
    if($this->isNew()){
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }



  public static function CurrentUser()
  {
    if(!isset(self::$currentLoggedInUser)){
      if(Session::exists(CURRENT_USER_SESSION_NAME)){
        $U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
        self::$currentLoggedInUser = $U;
      }
    }

    return self::$currentLoggedInUser;
  }


  public function findByUsername($username)
  {
    return $this->findFirst(['conditions'=>'username = ?', 'bind'=>[$username]]);
  }


  public function login($rememberMe = false)
  {
    Session::set($this->_sessionName, $this->id);
    if($rememberMe){
      $hash = md5(uniqid() + rand(0, 100));
      $user_agent = Session::uagent_no_version();
      Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRY);
      $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
      $this->_db->query("DELETE FROM `user_sessions` WHERE `user_id` = ? AND `user_agent` = ?", [$this->id, $user_agent]);
      $this->_db->insert('user_sessions', $fields);
    }
  }


  public static function loginUserFromCookie()
  {
    $userSession = UserSessions::getFromCookie();

    if($userSession && $userSession->user_id != ''){
      $user = new self((int)$userSession->user_id);

      if($user){
        $user->login();
      }
      return $user;
    }
    return null;
  }


  public function logout()
  {

    $userSession = UserSessions::getFromCookie();
    if($userSession){
      $userSession->delete();
    }
    Session::delete(CURRENT_USER_SESSION_NAME);
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
      Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$currentLoggedInUser = null;
    true;
  }



  public function acls()
  {
    if(empty($this->acl)){
      return [];
    }

    return json_decode($this->acl, true);
  }


  public function setConfirm($value)
  {
    $this->_confirm = $value;
  }


  public function getConfirm()
  {
    return $this->_confirm;
  }


}
