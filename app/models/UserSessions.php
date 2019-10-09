<?php
namespace App\models;
use Core\Model;
use Core\Cookie;
use Core\Session;

class UserSessions extends Model
{

  public $id,$user_id,$session,$user_agent;

  public function __construct()
  {
    $table = 'user_sessions';
    parent::__construct($table);
  }



  public static function getFromCookie()
  {
    $userSessions = new self();
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
      $userSession = $userSessions->findFirst([
        'conditions' => "user_agent = ? AND session = ?",
        'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
      ]);
    }
    if(!$userSession){
      return false;
    }
    return $userSession;
  }

}
